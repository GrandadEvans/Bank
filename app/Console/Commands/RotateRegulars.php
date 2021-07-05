<?php

namespace Bank\Console\Commands;

use Bank\Models\Dates;
use Bank\Models\Regular;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class RotateRegulars extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bank:rotate-regulars';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Increase a next occurrence date by the required intervals.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @todo    simplify this & move bulk to model
     *
     * @return mixed
     */
    public function handle()
    {
        $yesterdays = Regular::yesterdays();

        echo "There are " . count($yesterdays) . " that need rotating today\n\n";

        foreach ($yesterdays as $regular) {
            $duration = Regular::makeShortDurationReadable($regular->days);
            echo "  *  Bumping the date of \"" . Str::limit($regular->description, 50) . "\" by " . $duration . "\n";
            $regular->nextDue = Dates::bumpDate(Carbon::yesterday(), $duration);
            $regular->lastRotated = Carbon::today();
            $regular->save();
        }
        echo "\nComplete\n\n";
    }
}
