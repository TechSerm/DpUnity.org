<?php

namespace App\Observers;

use App\Models\OrderItem;
use Illuminate\Support\Str;

class OrderItemObserver
{
    public function creating(OrderItem $orderItem)
    {
        $orderItem->uuid = Str::uuid();
        $orderItem->wholesale_price_total = $orderItem->wholesale_price * $orderItem->quantity;
        $orderItem->total = $orderItem->price * $orderItem->quantity;
        $orderItem->profit = $orderItem->total - $orderItem->wholesale_price_total;
    }
}
