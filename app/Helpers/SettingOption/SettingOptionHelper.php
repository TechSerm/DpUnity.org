<?php

namespace App\Helpers\CacheService;

use App\Helpers\HelperTrait;

class SettingOptionHelper
{
    use HelperTrait;
    private $settingOptions;

    public function __construct()
    {
        $this->settingOptions = cacheService()->settingOptions()->get();
    }

    public function __get($key)
    {
        $key = strtoupper($key);
        return $this->settingOptions[$key] ?? "";
    }
}
