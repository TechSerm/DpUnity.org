<?php

namespace App\Services\MetaData;

use App\Enums\SettingEnum;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;


class MetaDataCacheService
{
    private static $instance = null;

    private $settings;
    private const CACHE_KEY = 'meta_data';
    private const CACHE_DURATION = 60 * 24 * 365; // 1 year

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getData()
    {
        if($this->settings) return $this->settings;

        $this->settings =  cache()->remember(self::CACHE_KEY, self::CACHE_DURATION, function () {
            return $this->getDBSettings();
        });

        return $this->settings;
    }

    public function refresh()
    {
        cache()->put(self::CACHE_KEY, $this->getDBSettings());
    }

    private function getDBSettings()
    {
        return Setting::all()->pluck('value', 'key');
    }
}