<?php

namespace App\Facades\Order;

use App\Services\Order\OrderShippingDetailsService;
use Illuminate\Support\Facades\Facade;

class OrderShippingDetails extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return OrderShippingDetailsService::class; }

}