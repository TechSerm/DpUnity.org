<?php

namespace App\Http\Middleware\Notification;

use App\Models\NotificationDevice;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NotificationDeviceTokenCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (deviceInfo()->hasDeviceToken()) {
            $deviceToken = deviceInfo()->getDeviceToken();
            $notificationDevice = NotificationDevice::where(['token' => $deviceToken, 'last_visit_ip' => $request->ip()])->first();
            
            if(auth()->check() && auth()->user()->device_token != $deviceToken){
                
                auth()->user()->update([
                    'device_token' => $deviceToken
                ]);
            }
            
            if ($notificationDevice ) {
                if((new Carbon($notificationDevice->last_visit_time))->diffInMinutes(Carbon::now()) > 60){
                    $notificationDevice->update([
                        'last_visit_time' => Carbon::now(),
                    ]);
                }
                
            } else {
                NotificationDevice::create([
                    'token' => $deviceToken,
                    'last_visit_ip' => $request->ip(),
                    'last_visit_time' => Carbon::now(),
                ]);
            }
            //Log::info("device token: " . base64_decode(request()->device_token) ." from : ". $request->ip());
        }
        return $next($request);
    }
}
