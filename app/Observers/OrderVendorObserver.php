<?php

namespace App\Observers;

use App\Models\OrderVendor;
use Illuminate\Support\Str;

class OrderVendorObserver
{
    public function creating(OrderVendor $order)
    {
        $order->uuid = Str::uuid();
    }
}
