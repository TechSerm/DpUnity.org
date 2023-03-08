<?php

namespace App\Console\Commands\UpgradeSystem;

use App\Services\UpgradeSystem\UpgradeMultiVendorOrderService;
use Illuminate\Console\Command;

class UpgradeMultiVendorSystemCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upgrade:multivendor_order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upgrate normal order to multivendor order data';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        (new UpgradeMultiVendorOrderService());
        return 0;
    }
}
