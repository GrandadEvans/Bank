<?php

namespace Bank\Http\Controllers;

use Bank\Http\Requests\TransactionAjaxRemarkRequest;
use Bank\Http\Requests\TransactionRequest;
use Bank\Jobs\ImportTransactions;
use Bank\Models\PaymentMethod;
use Bank\Models\Provider;
use Bank\Models\Transaction;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Throwable;

/**
 * General Transactions Controller
 *
 * @todo Split the file down
 */
class TransactionController extends Controller
{
    /**
     * how the transactions home page and list them
     *
     * return View
     */
    public function index($search = null): View
    {
        return view('transactions.index')
            ->with(['search' => $search]);
    }

    /**
     * how the transactions home page and list them
     *
     * return View
     */
    public function filter(string $search): View
    {
        return $this->index(search: $search);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('transactions.create')
            ->with('providers', Provider::all());
    }

    /**
     * Display a listing of the resource.
     *
     * @todo Handle unhandled exceptions
     *
     * return array
     */
    #[ArrayShape(['data' => 'Collection', 'stats' => '[]'])]
    public function all(int $page = 1, int $limit = 25, string $search = ''): array
    {
        $sort = request()->get('orderBy');
        $asc = request()->get('ascending');

        $orderByColumn = !empty($sort) ? '0' : 'transactions.id';
        $orderByDirection = ($asc == 1) ? 'asc' : 'desc';
        $startingRecord = ($limit * ($page - 1)) + 1;
        $endRecord = $limit * $page;

        $query = Transaction::with(['tags', 'provider', 'paymentMethod'])
            ->where('transactions.user_id', Auth::id());

        $totalRecords = $query->count();

        if (!empty($search)) {
            $query
                ->where('transactions.entry', 'like', '%%'.$search.'%')
                ->orWhere('transactions.remarks', 'like', '%%'.$search.'%')
                ->orWhere('transactions.amount', 'like', '%%'.$search.'%');
        }

        $filteredRecords = $query->count();

        $query->orderBy($orderByColumn, $orderByDirection);
        $query->limit($limit);
        $query->forPage($page, $limit);

        $data = $query->get();

        $stats = [
            'totalRecords' => $totalRecords,
            'filteredRecords' => $filteredRecords,
            'startingRecord' => (int) $startingRecord,
            'endRecord' => (int) $endRecord,
            'page' => $page,
            'limit' => $limit,
        ];

        return [
            'data' => $data,
            'stats' => $stats
        ];
    }

    /**
     * @param  Transaction  $transaction
     *
     * @return false|string
     */
    public function getJsonTags(Transaction $transaction): false|string
    {
        return json_encode($this->getTags($transaction));
    }

    /**
     * @param  int  $transactionId
     *
     * @return array
     */
    public function getNonJsonTags(int $transactionId): array
    {
        $transaction = Transaction::find($transactionId);
        return $this->getTags($transaction);
    }

    /**
     * @param  Transaction  $transaction
     * @param  int  $providerId
     *
     * @return Response
     */
    public function updateProvider(Transaction $transaction, int $providerId): Response
    {
        try {
            $transaction->provider_id = $providerId;
            $transaction->save();
        } catch (Exception $exception) {
            return new Response('Failed: '.$exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        $prov = Provider::where('id', $providerId)->get();
        return new Response($prov, Response::HTTP_ACCEPTED);
    }

    /**
     * @param  Transaction  $transaction
     * @param int $tagId
     *
     * @return Response
     */
    public function unlinkTag(Transaction $transaction, int $tagId): Response
    {
        try {
            DB::table('tag_transaction')
                ->where('tag_id', $tagId)
                ->where('transaction_id', $transaction->id)
                ->delete();
        } catch (Exception $e) {
            return new Response($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        return new Response('OK', Response::HTTP_ACCEPTED);
    }

    /**
     * @param  Transaction  $transaction
     *
     * @return array
     */
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
     *
     * @return RedirectResponse|Redirector
     * @throws Throwable
     */
    public function store(TransactionRequest $request): Redirector|RedirectResponse
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
     *
     * @return View
     */
    public function edit(Transaction $transaction): View
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
     * @param  TransactionRequest  $request
     * @param  Transaction  $transaction
     *
     * @return Redirector|RedirectResponse
     * @throws Throwable
     */
    public function update(TransactionRequest $request, Transaction $transaction): Redirector|RedirectResponse
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
     * @param  TransactionAjaxRemarkRequest  $request
     * @param  Transaction  $transaction
     *
     * @return JsonResponse
     * @throws Throwable
     */
    public function ajaxUpdate(TransactionAjaxRemarkRequest $request, Transaction $transaction): JsonResponse
    {
        $validated = $request->validated();
        $transaction->remarks = $validated['remarks'];
        $transaction->saveOrFail();

        return response()->json($transaction, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Transaction $transaction
     *
     * @return Redirector|RedirectResponse
     * @throws Exception
     */
    public function destroy(Transaction $transaction): Redirector|RedirectResponse
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
     * @return View
     */
    public function import(): View
    {
        return view('transactions.import');
    }

    /**
     * Provide the user with the multiple provider matches that are available
     *
     * @return View
     */
    public function providerChoice(): View
    {
        return view('transactions.providerChoice');
    }

    /**
     * Accept a file and import the contents
     * @param Request $request
     *
     * @return Factory|View|Application
     * @throws Exception
     */
    public function manualImport(Request $request): Factory|View|Application
    {
        $userId = Auth::id();
        $path = $request->file_input->path();
        $directory = base_path()."/resources/statements/user_$userId";

        if (!file_exists($directory)) {
            mkdir($directory);
        }
        try {
            copy($path, $directory.'/latest.csv');
        } catch (Exception $error) {
            throw new FileException($error->getMessage());
        }
        return $this->importFromFilename();
    }

    /**
     * @return RedirectResponse
     */
    public function autoImport(): RedirectResponse
    {
        $files = glob(base_path() .'/statement_downloads/*.csv', GLOB_BRACE);
        foreach ($files as $file) {
            $this->importFromFilename();
            $this->deleteFile($file);
        }

        return Redirect::route('transactions.index');
    }

    /**
     * @TODO Creat a a decent logger for this
     *
     * @param string $filename
     *
     * @return bool
     */
    protected function deleteFile(string $filename): bool
    {
        return unlink($filename);
    }

    /**
     * @return Factory|View|Application
     */
    protected function importFromFilename(): Factory|View|Application
    {
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

    /**
     * @return string
     * @throws Exception
     */
    public function getTransactionDates(): string
    {
        return '<div>'
            .(Transaction::getTransactionScrapeDates())['lastDate']
            .'</div><div>'
            .Transaction::getTransactionScrapeDates()['yesterday']
            .'</div>';
    }

    /**
     * @param  Request  $request
     * @return Response
     */
    public function addRemarkFromJs(Request $request): Response
    {
        $responseCode = Response::HTTP_CREATED;
        $errors = [];
        $transactionDetails = [];

        try {
            $transactionId = intval($request->get('transaction_id'));
            $remark = htmlspecialchars($request->get('remark'), ENT_QUOTES|ENT_SUBSTITUTE|ENT_HTML5);

            $transaction = Transaction::findOrFail($transactionId);
            $transaction->remarks = $remark;
            $transaction->save();

            $transactionDetails = [
                'transaction_id' => $transaction->id,
                'remark' => $transaction->remarks
            ];
        } catch (Exception $e) {
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
