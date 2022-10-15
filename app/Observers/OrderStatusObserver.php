<?php

namespace App\Observers;

use App\Models\OrderStatus;
use Illuminate\Support\Str;

class OrderStatusObserver
{
    public function creating(OrderStatus $orderStatus)
    {
        $orderStatus->uuid = Str::uuid();
        $orderStatus->status = 'pending';
    }
}
