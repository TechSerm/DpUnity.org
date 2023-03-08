<?php

namespace App\Observers;

use App\Models\VendorPayment;
use Illuminate\Support\Str;

class VendorPaymentObserver
{
    /**
     * Handle the Product "created" event.
     *
     * @param  \App\Models\VendorPayment  $product
     * @return void
     */
    public function creating(VendorPayment $vendorPayment)
    {
        $vendorPayment->uuid = Str::uuid();
    }
}
