<?php

namespace App\Services\Cache;

use App\Services\SettingOption\SettingOptionService;

class SettingOptionsCacheService extends CacheService
{
    protected $cacheKey = "setting_option";

    protected function data()
    {
        $settingOptionsCacheDataService = new SettingOptionService();
        return $settingOptionsCacheDataService->getKeyValueData();
    }
}
