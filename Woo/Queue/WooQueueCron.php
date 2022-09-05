<?php

namespace Woo\Queue;

use App\Models\WooQueue;
use Carbon\Carbon;

class WooQueueCron
{
    private $multiCronStart;

    public function run($isStart = true)
    {
        if ($isStart) {
            $this->multiCronStart = Carbon::now()->timestamp;
        }

        $now = Carbon::now()->timestamp;
        if (($now - $this->multiCronStart) >= 50) {
            return;
        }

        $wooQueue = $this->singleRun();

        if (!$wooQueue) {
            sleep(1);
        } else {
            usleep(100000);
        }

        $this->run(false);
    }

    public function singleRun()
    {
        $wooQueue = WooQueue::first();
        if ($wooQueue) $wooQueue->release();
        return $wooQueue;
    }
}
