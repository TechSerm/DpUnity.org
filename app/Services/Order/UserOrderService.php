<?php

namespace App\Services\Order;

use App\Models\Order;
use Illuminate\Support\Facades\Cookie;

class UserOrderService
{
    private $cookieTime = 2628000; //5 year
    private $cookieKey = "user_order_cache";

    public function __construct()
    {
        $this->saveOrderCookie();
    }

    private function saveOrderCookie()
    {
        $orderIds = $this->userOrderQuery()->pluck('id')->toArray();
        Cookie::queue($this->cookieKey, json_encode($orderIds), $this->cookieTime);
    }

    private function getOrderCookie()
    {
        return Cookie::has($this->cookieKey) ? json_decode(Cookie::get($this->cookieKey), true) : [];
    }

    private function userOrderQuery()
    {
        $orderIds = $this->getOrderCookie();
        return Order::where(['customer_ip_address' => request()->ip()])->OrWhereIn('id', $orderIds);
    }

    public function all()
    {
    }

    public function active()
    {
        return $this->userOrderQuery()->where('order_status', '!=', '"delivered"')->get();
    }
}
