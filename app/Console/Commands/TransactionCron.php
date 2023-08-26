<?php

namespace App\Console\Commands;

use App\Models\TelegramApi;
use Illuminate\Console\Command;

class TransactionCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transaction:cron';

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
        $telegramApi = new TelegramApi;
        $telegramApi->sendMessage('tse');
    }
}
