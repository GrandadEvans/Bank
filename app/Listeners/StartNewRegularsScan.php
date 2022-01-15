<?php

namespace Bank\Listeners;

use Bank\Models\Regular;
use Bank\Events\ScanForRegulars;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
     * @param  \Bank\Events\ScanForRegulars  $event
     * @return void
     */
    public function handle(ScanForRegulars $event)
    {
        Regular::findDistinctEntries();
    }
}
