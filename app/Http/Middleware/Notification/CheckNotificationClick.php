<?php

namespace App\Http\Middleware\Notification;

use App\Models\PushNotification;
use App\Models\PushNotificationClick;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;

class CheckNotificationClick
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
        if (isset($request->push_notification_id) && $request->push_notification_id != '' && PushNotification::find($request->push_notification_id)) {
           
            $pushNotification = PushNotificationClick::where([
                'push_notification_id' => $request->push_notification_id,
                'ip' => request()->ip()
            ])->first();

            if (!$pushNotification) {
                PushNotificationClick::create([
                    'push_notification_id' => $request->push_notification_id,
                    'ip' => request()->ip()
                ]);
            }
        }
        return $next($request);
    }
}
