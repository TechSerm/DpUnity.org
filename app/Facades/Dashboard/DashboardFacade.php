<?php

namespace App\Facades\Dashboard;

use App\Services\Dashboard\DashboardService;
use Illuminate\Support\Facades\Facade;

class DashboardFacade extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return DashboardService::class; }

}