<?php

namespace App\Http\Middleware\Device;

use App\Services\DeviceToken\DeviceHistoryService;
use Closure;
use Illuminate\Http\Request;

class DeviceHistory
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
        (new DeviceHistoryService())->addHistory();
        return $next($request);
    }
}
