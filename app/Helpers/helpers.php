<?php

use App\Helpers\BanglaFormatter;
use App\Services\SiteData\SiteDataService;
use App\Helpers\CacheService\CacheServiceHelper;
use App\Helpers\CacheService\SettingOptionHelper;
use App\Helpers\DeviceInfo;
use App\Services\MetaData\MetaDataService;
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

if(!function_exists('metaData')) {
    function metaData()
    {
        return new MetaDataService();
    }
}





