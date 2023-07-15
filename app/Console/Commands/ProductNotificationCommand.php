<?php

namespace App\Console\Commands;

use App\Services\Product\ProductNotificationService;
use Illuminate\Console\Command;

class ProductNotificationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product_notification:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        (new ProductNotificationService())->sendNotification();
    }
}
