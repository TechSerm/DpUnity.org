<?php

namespace App\Facades\Order;

use App\Services\Order\OrderService;
use Illuminate\Support\Facades\Facade;

class OrderFacade extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return OrderService::class; }

}