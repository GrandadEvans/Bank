<?php

namespace Bank\Http\Controllers;

use Bank\Events\ScanForRegulars;
use Bank\Models\PossibleRegular;
use Bank\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller for the possible regular transaction feature
 */
class PossibleRegularController extends Controller
{

    /**
     * Get the 1st outstanding possible transaction that belongs to the user
     *
     * @return Transaction
     */
    public function getFirstOutstanding(): Transaction
    {
        $possibles = PossibleRegular::outstanding()->get();
        return $possibles->first();
    }

    /**
     * Get the amount of outstanding transactions a user has
     *
     * @return int
     */
    public static function getOutstandingCount(): int
    {
        return PossibleRegular::outstanding()->get()->count();
    }

    /**
     * @return array[]|string
     */
    public function view(): array|string
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
        $transactionCollection = $transactionsQuery->get();

        $periodName = $possibility->period_name;
        $periodMultiplier = $possibility->period_multiplier;

        $lastSixMonths = $transactionCollection->takeWhile(function ($item) {
            $now = Carbon::create('now');
            $sixMonthsAgo = Carbon::create('6 months ago');
            $test = Carbon::create($item->date);

            return $test->isBetween($now, $sixMonthsAgo);
        });

        $lastOneYear = $transactionCollection->takeWhile(function ($item) {
            $now = Carbon::create('now');
            $oneYearAgo = Carbon::create('now')->subYear();
            $test = Carbon::create($item->date);

            return $test->isBetween($now, $oneYearAgo);
        });

        $allTime = $this->getStatsPerPeriod($transactionCollection);
        $lastFiveEntries = $this->getStatsPerPeriod($transactionCollection->take(5));
        $lastTenEntries = $this->getStatsPerPeriod($transactionCollection->take(10));
        $lastSixMonths = $this->getStatsPerPeriod($lastSixMonths);
        $lastYear = $this->getStatsPerPeriod($lastOneYear);

        $nextDate = $transactionCollection->first()->date->copy()->add($periodName, $periodMultiplier);

        return [
            'data' => [
                'transactions' => $transactionCollection,
            ],
            'stats' => [
                'lastFiveEntries' => $lastFiveEntries,
                'lastTenEntries' => $lastTenEntries,
                'lastSixMonths' => $lastSixMonths,
                'lastOneYear' => $lastYear,
                'allTime' => $allTime,
                'name' => $transactionCollection->first()->entry,
                'period_name' => $periodName,
                'period_multiplier' => $periodMultiplier,
                'totalDistinct' => $possibilities->count(),
                'paymentMethodId' => $transactionCollection->first()->payment_method_id,
                'providerId' => $transactionCollection->first()->provider_id,
                'nextDate' => $nextDate->format('Y-m-d')
            ]
        ];
    }

    /**
     * Mark an entry as accepted.
     *
     * @return \Illuminate\Http\Response
     */
    public function accept(): \Illuminate\Http\Response
    {
        $possibleRegular = $this->getFirstOutstanding();
        $possibleRegular->last_action = 'accepted';
        $possibleRegular->last_action_happened = now();
        if ($possibleRegular->save()) {
//            $r = new Regular();
//            $r->user_id = Auth::id();
//            $r->provider_id = 1;
//            $r->nextDue = '';
//            $r->lastRotated = '';
//            $r->description = '';
            return \response($this->view(), Response::HTTP_ACCEPTED);
        } else {
            return response('Unknown error', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Mark an entry as declined.
     *
     * @return \Illuminate\Http\Response
     */
    public function decline(): \Illuminate\Http\Response
    {
        $possibleRegular = $this->getFirstOutstanding();
        $possibleRegular->last_action = 'declined';
        $possibleRegular->last_action_happened = now();
        if ($possibleRegular->save()) {
            return \response($this->view(), Response::HTTP_ACCEPTED);
        } else {
            return response('Unknown error', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Mark an entry as postponed.
     *
     * @return \Illuminate\Http\Response
     */
    public function postpone(): \Illuminate\Http\Response
    {
        $possibleRegular = $this->getFirstOutstanding();
        $possibleRegular->last_action = 'postponed';
        $possibleRegular->last_action_happened = now();
        if ($possibleRegular->save()) {
            return \response($this->view(), Response::HTTP_ACCEPTED);
        } else {
            return response('Unknown error', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Manually request a new scan of new regulars
     */
    public function scan(): \Illuminate\Http\Response|Application|ResponseFactory
    {
        ScanForRegulars::dispatch(Auth::user());

        /*
         * This is not the correct way to move the user back to the previous url.
         * I know the previous url is at url()->previous, but how do I get the system to send the user to the previous
         * url? I think I may have to send the request in the background with js and do it that way
         * @todo: Send the user to the correct URL the correct way
         */
        return \response(null, 202);
    }

    /**
     * @todo: Extract this to global functionality, not just for regulars
     *
     * @return Application|Factory|View
     */
    public function scanResults(): View|Factory|Application
    {
        return view('regulars.scanResults');
    }

    /**
     * @param  Collection  $collection
     * @return array
     */
    private function getStatsPerPeriod(Collection $collection): array
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
