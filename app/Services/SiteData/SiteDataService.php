<?php

namespace App\Services\SiteData;

use App\Enums\SettingEnum;
use App\Services\Setting\SettingService;

class SiteDataService
{
    private static $instance;

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function insideDhakaDeliveryFee()
    {
        $settingService = new SettingService();
        return $settingService->getData(SettingEnum::INSIDE_DHAKA);
    }

    public static function outsideDhakaDeliveryFee()
    {
        $settingService = new SettingService();
        return $settingService->getData(SettingEnum::OUTSIDE_DHAKA);
    }
}
