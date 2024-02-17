<?php

namespace App\Helpers\CacheService;

use App\Helpers\Helper;
use App\Helpers\HelperTrait;
use App\Services\Cache\HomePageProductCacheService;
use App\Services\Cache\SettingOptionsCacheService;


class CacheServiceHelper
{
    use HelperTrait;

    private $settingOptionsCacheService;
    private $homePageProductCacheService;

    public function __construct()
    {
        $this->settingOptionsCacheService = new SettingOptionsCacheService();
        $this->homePageProductCacheService = new HomePageProductCacheService();
    }

    public function settingOptions()
    {
        return $this->settingOptionsCacheService;
    }

    public function homePageProduct()
    {
        return $this->homePageProductCacheService;
    }
}
