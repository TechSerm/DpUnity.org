<?php

namespace App\Http\Middleware\Notification;

use App\Models\NotificationDevice;
use App\Services\DeviceToken\DeviceTokenService;
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
        (new DeviceTokenService())->updateDeviceToken();
        return $next($request);
    }
}
