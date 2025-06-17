<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;

class Kernel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:kernel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * List of registered commands.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\GenerarAlertas::class,
        Commands\GenerarAlertas::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('farmacia:generar-alertas')->daily();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}