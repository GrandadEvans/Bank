<?php

namespace Bank\Listeners;

use Bank\Events\PossibleRegularScanFinished;
use Bank\Events\ScanForRegulars;
use Bank\UtilityClasses\NewRegularFinder;

class StartNewRegularsScan
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param ScanForRegulars $event
     *
     * @return void
     */
    public function handle(ScanForRegulars $event): void
    {
        new NewRegularFinder(returnFindings: false);
        PossibleRegularScanFinished::dispatch();
    }
}
