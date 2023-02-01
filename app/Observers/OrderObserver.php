<?php

namespace App\Observers;

use App\Models\Order;
use Illuminate\Support\Str;

class OrderObserver
{
    public function creating(Order $order)
    {
        $order->uuid = Str::uuid();
    }
}