<?php

namespace Bank\Http\Controllers;

use App\Http\Requests\AcceptPossibleRegularRequest;
use App\Http\Requests\StorePossibleRegularRequest;
use App\Http\Requests\UpdatePossibleRegularRequest;
use Bank\Events\ScanForRegulars;
use Bank\Models\PossibleRegular;
use Bank\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PossibleRegularController extends Controller
{

    public function getFirstOutstanding()
    {
        $possibles = PossibleRegular::outstanding()->get();
        return $possibles->first();
    }

    public function view()
    {
        $possibilities = PossibleRegular::outstanding()->get();

         if ($possibilities->count() === 0) {
            return 'no results';
        }
         $possibility = $possibilities->first();

        $userId = (int) Auth::id();

        $transactionsQuery = Transaction::with(['tags', 'provider', 'paymentMethod'])
            ->where('transactions.user_id', $userId)
            ->where('transactions.entry', $possibility->entry)
            ->distinct();

        $transactionsQuery->orderBy('date', 'DESC');
        $transactionsCollection = $transactionsQuery->get();

        $period = $possibility->period;

        $lastSixMonths = $transactionsCollection->takeWhile(function ($item) {
            $now = Carbon::create('now');
            $sixMonthsAgo = Carbon::create('6 months ago');
            $test = Carbon::create($item->date);

            return $test->isBetween($now, $sixMonthsAgo);
        });

        $lastOneYear = $transactionsCollection->takeWhile(function ($item) {
            $now = Carbon::create('now');
            $oneYearAgo = Carbon::create('now')->subYear();
            $test = Carbon::create($item->date);

            return $test->isBetween($now, $oneYearAgo);
        });

        $allTime = $this->getStatsPerPeriod($transactionsCollection);
        $lastFiveEntries = $this->getStatsPerPeriod($transactionsCollection->take(5));
        $lastTenEntries = $this->getStatsPerPeriod($transactionsCollection->take(10));
        $lastSixMonths = $this->getStatsPerPeriod($lastSixMonths);
        $lastYear = $this->getStatsPerPeriod($lastOneYear);

        return [
            'data' => [
                'transactions' => $transactionsCollection,
            ],
            'stats' => [
                'lastFiveEntries' => $lastFiveEntries,
                'lastTenEntries' => $lastTenEntries,
                'lastSixMonths' => $lastSixMonths,
                'lastOneYear' => $lastYear,
                'allTime' => $allTime,
                'name' => $transactionsCollection->first()->entry,
                'period' => $period,
                'totalDistinct' => $possibilities->count()
            ]
        ];
    }

    /**
     * Mark an entry as accepted.
     *
     * @return \Illuminate\Http\Response
     */
    public function accept()
    {
        $possibleRegular = $this->getFirstOutstanding();
        $possibleRegular->last_action = 'accepted';
        $possibleRegular->last_action_happened = now();
        if ($possibleRegular->save()) {
            return \response($this->view(), \Symfony\Component\HttpFoundation\Response::HTTP_ACCEPTED);
        } else {
            return response('Unknown error', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Mark an entry as declined.
     *
     * @return \Illuminate\Http\Response
     */
    public function decline()
    {
        $possibleRegular = $this->getFirstOutstanding();
        $possibleRegular->last_action = 'declined';
        $possibleRegular->last_action_happened = now();
        if ($possibleRegular->save()) {
            return \response($this->view(), \Symfony\Component\HttpFoundation\Response::HTTP_ACCEPTED);
        } else {
            return response('Unknown error', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Mark an entry as postponed.
     *
     * @return \Illuminate\Http\Response
     */
    public function postpone()
    {
        $possibleRegular = $this->getFirstOutstanding();
        $possibleRegular->last_action = 'postponed';
        $possibleRegular->last_action_happened = now();
        if ($possibleRegular->save()) {
            return \response($this->view(), \Symfony\Component\HttpFoundation\Response::HTTP_ACCEPTED);
        } else {
            return response('Unknown error', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
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
