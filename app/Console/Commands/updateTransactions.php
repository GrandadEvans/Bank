<?php

namespace Bank\Console\Commands;

use Illuminate\Console\Command;

class updateTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bank:update-transactions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "This will grab the latest transactions from the bank's website and add them to the database";

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
     * @return int
     */
    public function handle()
    {
        $binary = "/usr/bin/chromium";
        $script = "--user-data-dir=/home/john/.config/chromium --url=start.ui.vision.html";
        $output = null;
        $resultCode = null;
        $options = [
            'direct=1',
            'macro=update_transactions',
            'savelog=log.txt',
            'closeBrowser=1',
            'closeRPA=0'
            ];
        $optionString = join('&', $options);


        $command = "{$binary} {$script}";
        exec(
            "firefox --new-window 'file:///home/john/Projects/bank/start.ui.vision.html'?{$optionString}",
            $output,
            $resultCode
        );
        var_dump($output);
        return $resultCode;
    }
}
