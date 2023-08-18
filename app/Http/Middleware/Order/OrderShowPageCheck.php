<?php

namespace App\Http\Middleware\Order;

use App\Models\Order;
use Closure;
use Illuminate\Http\Request;

class OrderShowPageCheck
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
        if (auth()->user()->isVendor()) {
            $order = is_object(request()->order) ? request()->order : Order::where(['id' => request()->order])->firstOrFail();
            $vendor = $order?->vendors()->where(['vendor_id' => auth()->user()->id])->first();
            if (empty($vendor)) abort(401);
        }
        return $next($request);
    }
}
