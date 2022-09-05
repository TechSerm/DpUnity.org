<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Woo\Order\OrderSync;
use Woo\Queue\WooQueueCron;

class WooQueueCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'WooQueue:release';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Woo Queue Release';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::debug("Cron Call");
        (new OrderSync())->syncAllOrder();
        //(new WooQueueCron())->singleRun();
        return 0;
    }
}
