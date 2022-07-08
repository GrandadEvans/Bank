<?php

namespace Bank\Http\Controllers;

use Bank\Exceptions\InvalidPaymentMethodException;
use Bank\Exceptions\ResourceAccessException;
use Bank\Http\Requests\TransactionAjaxRemarkRequest;
use Bank\Http\Requests\TransactionRequest;
use Bank\Jobs\ImportTransactions;
use Bank\Models\PaymentMethod;
use Bank\Models\Provider;
use Bank\Models\Transaction;
use Bank\UtilityClasses\TimePeriods;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Throwable;

class TransactionController extends Controller
{
    /**
     * TransactionController constructor.
     */
    public function __construct()
    {
    }

    /**
     * how the transactions home page and list them
     */
    public function index($search = null)
    {
//        PossibleRegularScanFinished::dispatch();
//        return $this->all();
        return view('transactions.index')
            ->with(['search' => $search]);
    }

    /**
     * how the transactions home page and list them
     */
    public function filter($search)
    {
        return $this->index($search);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('transactions.create')
            ->with('providers', Provider::all());
    }

    /**
     * Display a listing of the resource.
     */
    public function all(int $page = 1, int $limit = 25, string $period = 'unset', string $search = '')
    {
        $userId = (int) Auth::id();
        $orderByColumn = !empty($sort = request()->get('orderBy')) ? '0' : 'transactions.id';
        $orderByDirection = request()->get('ascending') == 1 ? 'asc' : 'desc';
        $startingRecord = ($limit * ($page - 1)) + 1;
        $endRecord = $limit * $page;

        $query = Transaction::with(['tags', 'provider', 'paymentMethod'])
            ->where('transactions.user_id', Auth::id());

        if ($period !== 'unset') {
            $allowedPeriods = TimePeriods::$availablePeriods;

            if (in_array($period, $allowedPeriods)) {
                $fnName = 'sub'. ucfirst($period);
                $limitedPeriod = Carbon::create('now')->$fnName()->format('Y-m-d');
                $query
                ->whereDate('date', '>=', $limitedPeriod);
            }
        }
        
        $totalRecords = $query->count();

        if (!empty($search)) {
            $query
                ->where('transactions.entry', 'like', '%%'.$search.'%')
                ->orWhere('transactions.remarks', 'like', '%%'.$search.'%')
                ->orWhere('transactions.amount',  'like', '%%'.$search.'%');
//                ->orWhere('providers.name',       'like', '%%'.$search.'%');
        }

        $filteredRecords = $query->count();

        $query->orderBy($orderByColumn, $orderByDirection);
        $query->limit($limit);
        $query->forPage($page, $limit);

        $data = $query->get();

//        $query2 = DB::table('transactions')
//            ->where('user_id', Auth::id())
//            ->where('amount', '>', 0)
//            ->average('amount');
//        $query3 = DB::table('transactions')
//            ->where('user_id', Auth::id())
//            ->where('amount', '<', 0)
//            ->average('amount');


        $totalAmount = 0;
        foreach($data as $item) {
            $totalAmount += $item->amount;
        }

        $recordsShown = $data->count();
        $stats = [
            'totalRecords' => (int) $totalRecords,
            'filteredRecords' => (int) $filteredRecords,
            'startingRecord' => (int) $startingRecord,
            'endRecord' => (int) $endRecord,
            'page' => (int) $page,
            'limit' => (int) $limit,
            'numberOfEntriesShown' => (int) $recordsShown,
            'averageAmountShown' => (float) ($totalAmount / $recordsShown),
            'totalAmountShown' => (float) $totalAmount
//            'average_in' => $query2,
//            'average_out' => $query3
        ];

        return [
            'data' => $data,
            'stats' => $stats
        ];
    }

    public function getJsonTags(Request $request, Transaction $transaction)
    {
        return json_encode($this->getTags($transaction));
    }

    public function getNonJsonTags(int $id): array
    {
        $transaction = Transaction::find($id);
        return $this->getTags($transaction);
    }

    public function updateProvider(Transaction $transaction, $provider_id)
    {
        try {
            $transaction->provider_id = $provider_id;
            $transaction->save();
        } catch (Exception $exception) {
            return new Response('Failed: '.$exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        $prov = Provider::where('id', $provider_id)->get();
        return new Response($prov, Response::HTTP_ACCEPTED);
    }

    public function unlinkTag(Transaction $transaction, $tag_id)
    {
        try {
            DB::table('tag_transaction')
                ->where('tag_id', $tag_id)
                ->where('transaction_id', $transaction->id)
                ->delete();
        } catch (Exception $e) {
            return new Response($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        return new Response('OK', Response::HTTP_ACCEPTED);
    }

    public function getTags(Transaction $transaction): array
    {
        $tagString = [];
        $tags = $transaction->tags()->get();
        foreach ($tags as $tag) {
            $tagString[] = [
                'id' => $tag->id,
                'tag' => $tag->tag,
                'default_color' => $tag->default_color,
                'contrasted_color' => $tag->contrasted_color,
                'icon' => $tag->icon
            ];
        }
        return $tagString;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TransactionRequest  $request
     * @return Response
     * @throws Throwable
     */
    public function store(TransactionRequest $request)
    {
        $validated = $request->validated();

        $regular = new Transaction($validated);
        $regular->user_id = Auth::id();
        $regular->saveOrFail();

        $flashData = [
            'type' => 'success',
            'title' => 'Success!',
            'text' => 'Item successfully created'
        ];

        session()->flash('alert', $flashData);

        return redirect(route('transactions.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Transaction  $transaction
     * @return Response
     */
    public function edit(Transaction $transaction)
    {
        $transaction->verifyRecordOwnership();
        return view('transactions.edit')
            ->with('transaction', $transaction)
            ->with('paymentMethods', PaymentMethod::all())
            ->with('providers', Provider::all()->get());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Transaction  $transaction
     * @return Response
     */
    public function update(TransactionRequest $request, Transaction $transaction)
    {
        $transaction->verifyRecordOwnership();
        $validated = $request->validated();
        $transaction->update($validated);
        $transaction->saveOrFail();

        return redirect(route('transactions.index'));
    }

    /**
     * Update the specified resource in storage from an Ajax request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Bank\Transaction  $transaction
     * @return Response
     */
    public function ajaxUpdate(TransactionAjaxRemarkRequest $request, Transaction $transaction)
    {
        $validated = $request->validated();
        $transaction->remarks = $validated['remarks'];
        $transaction->saveOrFail();

        return response()->json($transaction, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @param  \Bank\Transaction  $transaction
     * @return Response
     * @throws Exception
     */
    public function destroy(Request $request, Transaction $transaction)
    {
        $transaction->verifyRecordOwnership();

        $transaction->delete();
        $flashData = [
            'type' => 'success',
            'title' => 'Success!',
            'text' => 'Item successfully deleted'
        ];

        session()->flash('alert', $flashData);

        return redirect(route('transactions.index'));

    }

    /**
     * Manual Import page
     *
     * @param Request $request
     * @return void
     */
    public function import() {
        return view('transactions.import');
    }

    /**
     * Provide the user with the multiple provider matches that are available
     *
     * @param Request $request
     * @return void
     */
    public function providerChoice(Request $request) {
        return view('transactions.providerChoice');
    }

    /**
     * Accept a file and import the contents
     * @param Request $request
     *
     * @return Factory|View|Application
     * @throws Exception
     */
    public function manual_import(Request $request): Factory|View|Application
    {
//        if ( ! $request->hasFile('file_input')) {
//            throw new FileNotFoundException("There was an error in your uploaded file, check it again, please!");
//        }

        // Get a list of all providers
        $providers = Provider::all()->get();

        $userId = Auth::id();
        $path = $request->file_input->path();
        $directory = base_path()."/resources/statements/user_{$userId}";

        if (!file_exists($directory)) {
            mkdir($directory);
        }
        try {
            copy($path, $directory.'/latest.csv');
        } catch (Exception $e) {
            throw new FileException($e->getMessage());
        }
        return $this->importFromFilename();
    }

    public function autoImport()
    {
        $files = glob(base_path() . "/statement_downloads/*.csv", GLOB_BRACE);
        foreach($files as $file) {
            $this->importFromFilename($file);
            $this->deleteFile($file);
        }

        return Redirect::route('transactions.index');
    }

    /**
     * @TODO Creata a decent logger for this
     *
     * @param $filename
     */
    protected function deleteFile($filename)
    {
//        chdir(base_path() . "/statement_downloads");
//        $properFile = explode('/', $filename);
//        $filename = array_pop($properFile);

        unlink($filename);
    }

    protected function importFromFilename(): Factory|View|Application
    {
        $id = Auth::id();

        /*
         * @todo: switch back to dispatch & figure out why sync si not working on server
         */
        ImportTransactions::dispatchSync(Auth::user());
        $flashData = [
            'type' => 'info',
            'title' => 'Transactions transacting!',
            'text' => "Don't worry, your transactions are being added in the background, and will be available to view
                soon, so keep checking back",
            'showConfirmButton' => 'true',
            'showCancelButton' => 'false'
        ];

        session()->flash('alert', $flashData);

        return $this->index();
    }

    public function getTransactionScrapeDates()
    {
        return '<div>'
            .(Transaction::getTransactionScrapeDates())['lastDate']
            .'</div><div>'
            .Transaction::getTransactionScrapeDates()['yesterday']
            .'</div>';
    }

    public function addRemarkFromJs(Request $request)
    {
        $responseCode = Response::HTTP_CREATED;
        $responseText = "OK";
        $errors = [];
        $transactionDetails = [];

        try {
            $id = intval($request->get('transaction_id'));
            $remark = filter_var($request->get('remark'), FILTER_SANITIZE_STRING);

            $transaction = Transaction::findOrFail($id);
            $transaction->remarks = $remark;
            $transaction->save();

            $transactionDetails = [
                'transaction_id' => $transaction->id,
                'remark' => $transaction->remarks
            ];
        } catch (\Exception $e) {
            $errors[] = [
                'action' => 'find and update transaction remark',
                'error' => $e->getMessage(),
                'transactionId' => intval($request->get('id')) || 0
            ];
            $responseCode = Response::HTTP_BAD_REQUEST;
        }

        $responseText = [
            'errors' => $errors,
            'transaction' => $transactionDetails
        ];
        return new Response($responseText, $responseCode);
    }
}
