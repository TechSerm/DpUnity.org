<?php

namespace App\Facades\Vendor;

use App\Services\Vendor\VendorService;
use Illuminate\Support\Facades\Facade;

class Vendor extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return VendorService::class; }

}