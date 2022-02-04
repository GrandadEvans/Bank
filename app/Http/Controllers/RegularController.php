<?php

namespace Bank\Http\Controllers;

use Bank\Events\ScanForRegulars;
use Bank\Http\Requests\RegularRequest;
use Bank\Models\PaymentMethod;
use Bank\Models\Provider;
use Bank\Models\Regular;
use Bank\Models\Transaction;
use Bank\UtilityClasses\RegularTransactionUtilities;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
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

    public function possibleNew(int $iteration)
    {
        $iteration--; // convert page number to array index
        $dir = RegularTransactionUtilities::getRegularScanDirectory();
        $latestFilename = "${dir}/latest.json";
        $latestContents = file_get_contents($latestFilename);
        $decoded = json_decode(json: $latestContents, associative: true);
        $keys = array_keys($decoded['transactions']);
        $values = array_values($decoded['transactions']);

        $userId = (int) Auth::id();

        $query = Transaction::with(['tags', 'provider', 'paymentMethod'])
            ->where('transactions.user_id', Auth::id())
            ->where('transactions.entry', $keys[$iteration])
            ->distinct();


        $query->orderBy('date', 'DESC');
        $data = $query->get();

//        $grouped = $data->groupBy(['entry']);
//        dd($grouped->all());
        $period = $values[$iteration];

        $lastSixMonths = $data->takeWhile(function ($item) {
            $now = Carbon::create('now');
            $sixMonthsAgo = Carbon::create('6 months ago');
            $test = Carbon::create($item->date);

            return $test->isBetween($now, $sixMonthsAgo);
        });

        $lastOneYear = $data->takeWhile(function ($item) {
            $now = Carbon::create('now');
            $oneYearAgo = Carbon::create('now')->subYear();
            $test = Carbon::create($item->date);

            return $test->isBetween($now, $oneYearAgo);
        });

        $allTime = $this->getStatsPerPeriod($data);
        $lastFiveEntries = $this->getStatsPerPeriod($data->take(5));
        $lastTenEntries = $this->getStatsPerPeriod($data->take(10));
        $lastSixMonths = $this->getStatsPerPeriod($lastSixMonths);
        $lastYear = $this->getStatsPerPeriod($lastOneYear);

        return [
            'data' => [
                'transactions' => $data,
            ],
            'stats' => [
                'lastFiveEntries' => $lastFiveEntries,
                'lastTenEntries' => $lastTenEntries,
                'lastSixMonths' => $lastSixMonths,
                'lastOneYear' => $lastYear,
                'allTime' => $allTime,
                'name' => $data->first()->entry,
                'period' => $period,
                'totalDistinct' => count($decoded['transactions'])
            ]
        ];
    }

    private function getStatsPerPeriod(Collection $collection)
    {
        $sum = $collection->sum('amount');
        $count = $collection->count();
        if ($count) {
            $average = ($sum / $count);
            return [$sum, $count, $average];
        }

        return [0, 0, 0];
    }
}
