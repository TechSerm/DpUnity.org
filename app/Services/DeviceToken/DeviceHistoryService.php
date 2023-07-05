<?php

namespace App\Services\DeviceToken;

use App\Facades\Order\OrderShippingDetails;
use App\Models\DeviceHistory;

class DeviceHistoryService
{
    public function addHistory()
    {
        if (!deviceInfo()->hasDeviceToken()) return;
        $deviceId = (new DeviceTokenService())->getCacheId();
        
        try {
            $data = [
                'device_id' => $deviceId,
                'ip' => request()->ip(),
                'url' => request()->fullUrl(),
                'user_id' => auth()->user() ? auth()->user()->id : null,
                'cache_data' => json_encode($this->getCacheData())
            ];
            if ($this->isInsertable($data, $deviceId)) DeviceHistory::create($data);
        } catch (\Exception $e) {
        }
    }

    private function getCacheData()
    {
        return [
            'checkout_info' => OrderShippingDetails::get(true)
        ];
    }

    private function isInsertable($data, $deviceId)
    {
        $cacheData = cache()->get('device_history_' . $deviceId, []);

        $differences = array_diff($data, $cacheData);

        cache()->put('device_history_' . $deviceId, $data);

        return empty($differences) ? false : true;
    }
}
