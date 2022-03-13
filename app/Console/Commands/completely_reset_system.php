<?php

namespace Bank\Console\Commands;

use Illuminate\Console\Command;

class completely_reset_system extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bank:complete-reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Completely flush all caches; jobs; db tables etc and rebuild db';

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
        $commands = [
            'php artisan auth:clear-resets',
            'php artisan optimize:clear',
            'php artisan queue:clear',
            'php artisan queue:flush',
            'php artisan schedule:clear-cache',
            'php artisan telescope:clear',
            'php artisan migrate:fresh --seed'
        ];

        $result = 0;
        $allOutput = [];
        foreach ($commands as $command) {
            $output = null;
            $resultCode = null;

            exec(command: $command, output: $output, result_code: $resultCode);

            $allOutput[] = [
                'command' => $command,
                'output' => $output,
                'resultCode' => $resultCode
            ];

            if ($resultCode !== 0) {
                $result = $resultCode;
            }
        }

        var_dump($allOutput);

        return $result;
    }
}
