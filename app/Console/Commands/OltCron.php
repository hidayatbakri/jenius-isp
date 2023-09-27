<?php

namespace App\Console\Commands;

use App\Models\CustomerProfile;
use App\Models\TelegramApi;
use Illuminate\Console\Command;

class OltCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:olt-cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cp = new CustomerProfile();
        $cp->refresh();

        $telegramApi = new TelegramApi;
        $telegramApi->sendMessage("Refresh data");
    }
}
