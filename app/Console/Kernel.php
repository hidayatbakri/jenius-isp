<?php

namespace App\Console;

use App\Models\Customer;
use App\Models\Olt;
use App\Models\Paket;
use App\Models\TelegramApi;
use App\Models\Telnet;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected $commands = [
        Commands\TransactionCron::class,
        Commands\OltCron::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command($this->commands[0])->everyFifteenMinutes();
        $schedule->command($this->commands[1])->everyTenMinutes();


        // $schedule->call(function () {
        // })->everyTenMinutes();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
