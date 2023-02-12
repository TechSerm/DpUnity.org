<?php

namespace App\Console\Commands;

use App\Services\DeviceToken\DeviceTokenService;
use Illuminate\Console\Command;

class NotificationDeviceCleanCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification_device:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notification Device Clean';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        (new DeviceTokenService())->cleanUpData();
        return 0;
    }
}
