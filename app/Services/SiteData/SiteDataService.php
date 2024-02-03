<?php

namespace App\Services\SiteData;

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
        return 80;
    }

    public static function outsideDhakaDeliveryFee()
    {
        return 130;
    }
}
