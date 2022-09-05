<?php

namespace Woo\Queue;

use App\Models\WooQueue;

class WooQueueService
{
    public function create($queueData)
    {
        $alreadyExistsWooQueue = $this->getAlreadyExistsWooQueue($queueData);

        if ($alreadyExistsWooQueue) {
            $this->updateQueue($alreadyExistsWooQueue, $queueData);
        } else {
            $queueData['data'] = json_encode($queueData['data']);
            WooQueue::create($queueData);
        }
    }

    public function getAlreadyExistsWooQueue($queueData)
    {
        return WooQueue::where([
            'slug' => $queueData['slug'],
            'method' => $queueData['method']
        ])->first();
    }

    public function updateQueue(WooQueue $wooQueue, $queueData)
    {
        $wooQueue->update([
            'data' => json_encode(array_merge(json_decode($wooQueue->data, true), $queueData['data']))
        ]);
    }
}
