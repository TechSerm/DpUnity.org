<?php

namespace App\Services\DeviceToken;

use App\Models\NotificationDevice;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeviceTokenService
{
    private $cookieTime = 2628000; //5 year
    private $cookieKey = "device_token_key";

    public function updateDeviceToken()
    {
        if (!deviceInfo()->hasDeviceToken()) return;

        $deviceToken = deviceInfo()->getDeviceToken();
        $deviceId = $this->getCacheId();

        if (!$deviceId) {
            $notificationDevice = NotificationDevice::where(['token' => $deviceToken])->first();
        } else {
            $notificationDevice = NotificationDevice::where(['id' => $deviceId])->first();
        }

        if (!$notificationDevice) {
            $notificationDevice = NotificationDevice::create([
                'token' => $deviceToken,
                'last_visit_ip' => request()->ip(),
                'last_visit_time' => Carbon::now(),
                'last_visit_page' => request()->fullUrl()
            ]);
        }

        if (!$deviceId && $notificationDevice) {
            $this->createCacheId($notificationDevice->id);
        }

        $this->updateLoginUserDeviceToken($deviceToken);

        if ((new Carbon($notificationDevice->last_visit_time))->diffInMinutes(Carbon::now()) >= 1) {
            $notificationDevice->update([
                'last_visit_time' => Carbon::now(),
                'last_visit_ip' => request()->ip(),
                'hits' => $notificationDevice->hits + 1,
                'last_visit_page' => request()->fullUrl()
            ]);
        }

        if ($notificationDevice->token != $deviceToken) {
            $notificationDevice->update([
                'token' => $deviceToken,
                'last_visit_ip' => request()->ip(),
            ]);
        }
    }

    private function updateLoginUserDeviceToken($deviceToken)
    {
        //update login user device token
        if (auth()->check() && auth()->user()->device_token != $deviceToken) {
            auth()->user()->update([
                'device_token' => $deviceToken
            ]);
        }
    }

    private function getCacheId()
    {
        return Cookie::has($this->cookieKey) ? Cookie::get($this->cookieKey) : '';
    }

    private function createCacheId($deviceId)
    {
        Cookie::queue($this->cookieKey, $deviceId, $this->cookieTime);
    }

    public function dashboardCalculation()
    {
        $today = Carbon::now()->format('Y-m-d 00:00:00');
        $lastWeek = Carbon::now()->sub('6 days')->format('Y-m-d 00:00:00');
        $lastMonth = Carbon::now()->sub('29 days')->format('Y-m-d 00:00:00');

        $lastVisit = NotificationDevice::where('last_visit_time', '>=', date('Y-m-d H:i:s', strtotime('-30 minutes')))->count();
        $todayVisit = NotificationDevice::where('last_visit_time', '>=', $today)->count();
        $weekVisit = NotificationDevice::where('last_visit_time', '>=', $lastWeek)->count();
        $monthVisit = NotificationDevice::where('last_visit_time', '>=', $lastMonth)->count();

        $totalDevice = NotificationDevice::count();
        $todayAddDevice = NotificationDevice::where('created_at', '>=', $today)->count();
        $weekAddDevice = NotificationDevice::where('created_at', '>=', $lastWeek)->count();
        $monthAddDevice = NotificationDevice::where('created_at', '>=', $lastMonth)->count();

        return [
            'lastVisit' => $lastVisit,
            'today' => $todayVisit,
            'weekVisit' => $weekVisit,
            'monthVisit' => $monthVisit,

            'totalDevice' => $totalDevice,
            'todayAddDevice' => $todayAddDevice,
            'weekAddDevice' => $weekAddDevice,
            'monthAddDevice' => $monthAddDevice,
        ];
    }

    public function cleanUpData()
    {
        $ipList = NotificationDevice::select('last_visit_ip')
                 ->groupBy('last_visit_ip')
                 ->get()
                 ->pluck('last_visit_ip');
        foreach ($ipList as $ip) {
            $devices = NotificationDevice::where(['last_visit_ip' => $ip])->orderBy('last_visit_time', 'desc')->skip(1)->take(PHP_INT_MAX)->pluck('id');
            if(count($devices) > 0){
                NotificationDevice::whereIn('id', $devices)->delete();
                echo $ip . " " . count($devices) . " Clear \n";
            }
        }
    }
}
