<?php

namespace App\Services\MetaData;

use App\Enums\SettingEnum;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MetaDataService
{
    private static $instance;
    private $settings;

    public function __construct()
    {
        $this->settings = $this->cache()->getData();
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function cache()
    {
        return MetaDataCacheService::getInstance();
    }

    public function __call($name, $arguments)
    {
        // Check if method starts with 'get'
        if (strpos($name, 'get') === 0) {
            // Remove 'get' prefix and convert to SNAKE_CASE
            $enumKey = Str::upper(Str::snake(substr($name, 3)));

            // Check if the key exists in SettingEnum
            if (SettingEnum::hasKey($enumKey)) {
                return $this->settings[$enumKey] ?? null;
            }
        }

        throw new \BadMethodCallException("Method {$name} does not exist.");
    }

    public function getSliders()
    {
        $sliders = $this->settings[SettingEnum::SLIDERS] ?? [];
        return collect($sliders)->map(fn($slider) => Storage::url($slider))->reverse()->toArray();
    }

    public function getLogo()
    {
        $logo = $this->settings[SettingEnum::LOGO] ?? null;
        return Storage::url($logo);
    }

    public function getFavicon()
    {
        $favicon = $this->settings[SettingEnum::FAVICON] ?? null;
        return Storage::url($favicon);
    }
}
