<?php

namespace Bank\Http\Controllers;

use Bank\Events\ScanForRegulars;
use Bank\Http\Requests\RegularRequest;
use Bank\Models\PaymentMethod;
use Bank\Models\Provider;
use Bank\Models\Regular;
use Bank\UtilityClasses\RegularTransactionUtilities;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class RegularController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $all = Regular::myRecords()->get();
        return view('regulars.index')
            ->with('transactions', Regular::myRecords()->with('provider:id,name')->get())
            ->with('total', array_sum($all->pluck('amount')->toArray()))
            ->with('payment_methods', PaymentMethod::list())
            ->with('providers');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('regulars.create')
            ->with('providers', Provider::all()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RegularRequest  $request
     *
     * @return Response
     * @throws \Throwable
     */
    public function store(RegularRequest $request)
    {
        $validated = $request->validated();

        $regular = new Regular($validated);
        $regular->user_id = Auth::id();
        $regular->saveOrFail();

        return redirect(route('regulars.index'))
            ->with('flashMessage', [
                'type' => 'success',
                'title' => 'Success!',
                'text' => 'Item successfully created'
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Regular  $regular
     * @return Response
     */
    public function edit(Regular $regular)
    {
        $regular->verifyRecordOwnership();

        return view('regulars.edit')
            ->with('regular', $regular)
            ->with('providers', Provider::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Regular  $regular
     * @return Response
     * @throws \Throwable
     */
    public function update(RegularRequest $request, Regular $regular)
    {
        $regular->verifyRecordOwnership();

        $validated = $request->validated();
        $regular->update($validated);
        $regular->saveOrFail();

        return redirect(route('regulars.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Regular  $regular
     * @return Response
     * @throws Exception
     */
    public function destroy(Regular $regular)
    {
        $regular->delete();
        return redirect(route('regulars.index'))
            ->with('flashMessage', [
                'type' => 'success',
                'title' => 'Success!',
                'text' => 'Item successfully deleted'
            ]);

    }

    /**
     * Manually request a new scan of new regulars
     */
    public function scan()
    {
        ScanForRegulars::dispatch();
        $flashData = [
            'type' => 'success',
            'title' => 'Success!',
            'text' => 'A new scan is underway, and you\\\'ll be informed of the results in a few minutes'
        ];

        session()->flash('alert', $flashData);

        return view('home');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @todo: Extract this to global functionality, not just for regulars
     *
     */
    public function scanResults()
    {
        return view('regulars.scanResults');
    }

    public function possibleNew()
    {
        $dir = RegularTransactionUtilities::getRegularScanDirectory();
        $latestFilename = "${dir}/latest.json";
        $latestContents = file_get_contents($latestFilename);

//        $userId = (int) Auth::id();
//        $search = '';// !empty($value = request()->get('search', ['value' => ''])) ? $value['value'] : '';
//        $orderByColumn = !empty($sort = request()->get('orderBy')) ? '0' : 'transactions.id';
//        $orderByDirection = request()->get('ascending') == 1 ? 'asc' : 'desc';
//        $startingRecord = ($limit * ($page - 1)) + 1;
//        $endRecord = $limit * $page;
//
//        $query = Transaction::with(['tags', 'provider', 'paymentMethod'])
//            ->where('transactions.user_id', Auth::id());
//
//        $totalRecords = $query->count();
//
//        if (!empty($search)) {
//            $query
//                ->where('transactions.entry', 'like', '%%'.$search.'%')
//                ->orWhere('transactions.remarks', 'like', '%%'.$search.'%')
//                ->orWhere('transactions.amount', 'like', '%%'.$search.'%');
//                ->orWhere('providers.name',       'like', '%%'.$search.'%');
//        }
//
//        $filteredRecords = $query->count();
//
//        $query->orderBy($orderByColumn, $orderByDirection);
//        $query->limit($limit);
//        $query->forPage($page, $limit);
//
//        $data = $query->get();
//
//        $query2 = DB::table('transactions')
//            ->where('user_id', Auth::id())
//            ->where('amount', '>', 0)
//            ->average('amount');
//        $query3 = DB::table('transactions')
//            ->where('user_id', Auth::id())
//            ->where('amount', '<', 0)
//            ->average('amount');
//
//
//        $stats = [
//            'totalRecords' => (int) $totalRecords,
//            'filteredRecords' => (int) $filteredRecords,
//            'startingRecord' => (int) $startingRecord,
//            'endRecord' => (int) $endRecord,
//            'page' => (int) $page,
//            'limit' => (int) $limit,
//            'average_in' => $query2,
//            'average_out' => $query3
//        ];

        $decoded = json_decode($latestContents);
        return [
            'data' => $decoded,
            'stats' => [
            ]
        ];
    }
}
