<?php

namespace App\Services\Order;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;

class UserOrderService
{
    private $cookieTime = 2628000; //5 year
    private $cookieKey = "user_order_cache_key";

    public function __construct()
    {
        $this->saveOrderCookie();
    }

    private function saveOrderCookie($orderIds = [])
    {
        $orderIds = empty($orderIds) ? $this->userOrderQuery()->pluck('id')->toArray() : $orderIds;
        Cookie::queue($this->cookieKey, json_encode($orderIds), $this->cookieTime);
    }

    private function getOrderCookie()
    {
        return Cookie::has($this->cookieKey) ? json_decode(Cookie::get($this->cookieKey), true) : [];
    }

    private function userOrderQuery()
    {
        $orderIds = $this->getOrderCookie();
        $orderQuery = Order::whereIn('id', $orderIds);
        if (deviceInfo()->hasDeviceToken()) {
            $token = deviceInfo()->getDeviceToken();
            $orderQuery->orWhere('user_agent', 'LIKE', '%' . $token . '%');
        }
        return $orderQuery->orderBy('id','desc')->get();
    }

    public function addOrderCookie(Order $order){
        $orderIds = $this->userOrderQuery()->pluck('id')->toArray();
        if(!in_array($order->id, $orderIds))array_push($orderIds, $order->id);
        $this->saveOrderCookie($orderIds);
    }

    public function all()
    {
        return $this->userOrderQuery();
    }

    public function active()
    {
        return $this->userOrderQuery()->filter(function ($order) {
            return ($order->is_delivery_complete ==  false && $order->is_cancelled ==  false);
        });
    }

    public function activeOrToday()
    {
        return $this->userOrderQuery()->filter(function ($order) {
            $timeDiff = $order->created_at->diffInMinutes(Carbon::now());
            return ($order->is_delivery_complete ==  false && $order->is_cancelled ==  false) || $timeDiff <= 1440;
        });
    }
}
