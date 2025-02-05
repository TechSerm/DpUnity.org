<?php

use App\Helpers\BanglaFormatter;
use App\Services\SiteData\SiteDataService;
use App\Helpers\CacheService\CacheServiceHelper;
use App\Helpers\CacheService\SettingOptionHelper;
use App\Helpers\DeviceInfo;
use App\Services\Theme\ThemeService;

/**
 * Bangla Convert
 *
 * @return string
 */
if (!function_exists('banglaFormatter')) {
    function banglaFormatter()
    {
        return new BanglaFormatter();
    }
}

if (!function_exists('convertBanglaNumber')) {
    function convertBanglaNumber($number)
    {
        $numbers = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
        $number = number_format($number, 0, '.', ',');
        $number = strtr($number, $numbers);
        return $number;
    }
}

if (!function_exists('deviceInfo')) {
    function deviceInfo()
    {
        return new DeviceInfo();
    }
}

if (!function_exists('theme')) {
    function theme()
    {
        $infoInstance = ThemeService::getInstance();
        return $infoInstance;
    }
}

if (!function_exists('siteData')) {
    function siteData()
    {
        $dataService = SiteDataService::getInstance();
        return $dataService;
    }
}

if (!function_exists('cacheService')) {
    function cacheService()
    {
        $cacheService = CacheServiceHelper::getInstance();
        return $cacheService;
    }
}

if (!function_exists('settingOptions')) {
    function settingOptions()
    {
        $settingOptionHelper = SettingOptionHelper::getInstance();
        return $settingOptionHelper;
    }
}


if (!function_exists('getProductDiscount')) {
    function getProductDiscountIncValue($price)
    {
        $incDiv = ceil($price / 100);
        if ($price < 100) return $incDiv;
        if ($price % 5 != 0) return $incDiv;
        $divFiv = ceil($incDiv / 5);
        $amount = $divFiv * 5;
        if ($divFiv > 600) return 10;
        return $divFiv * 5;
    }
}
