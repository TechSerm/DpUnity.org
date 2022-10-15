<?php

namespace App\Services\Order;

use App\Cart\Cart;
use App\Facades\Order\OrderShippingDetails;
use App\Facades\PushNotification\PushNotificationFacade;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\Order\NewOrderService;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function newOrder()
    {
        return (new NewOrderService());
    }

    public function updateTotalCalculation(Order $order){
        $orderTotalCalculations = $order->items()->select([
            DB::raw("sum(total) as subtotal"),  
            DB::raw("sum(wholesale_price_total) as wholesale_total"),
            DB::raw("sum(profit) as products_profit"),
        ])->first();

        $order->subtotal = $orderTotalCalculations->subtotal;
        $order->wholesale_total = $orderTotalCalculations->wholesale_total;
        $order->products_profit = $orderTotalCalculations->products_profit;
        $order->total_profit = $orderTotalCalculations->products_profit + $order->delivery_fee;
        $order->total = $order->subtotal + $order->delivery_fee;
        
        $order->save();

        return $order;
    }
    
    public function userOrder()
    {
        return new UserOrderService();
    }
}
