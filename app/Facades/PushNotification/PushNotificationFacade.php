<?php

namespace App\Facades\PushNotification;

use App\Services\PushNotification\PushNotificationService;
use Illuminate\Support\Facades\Facade;

class PushNotificationFacade extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return PushNotificationService::class; }

}