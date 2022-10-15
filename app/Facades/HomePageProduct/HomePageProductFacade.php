<?php

namespace App\Facades\HomePageProduct;

use App\Services\HomePageProduct\HomePageProductService;
use Illuminate\Support\Facades\Facade;

class HomePageProductFacade extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return HomePageProductService::class; }

}