<?php

namespace App\Services\Setting;

use App\Models\Setting;

class SettingService
{
    private $settingOptions;

    public function __construct()
    {
        $this->settingOptions = Setting::all();
    }

    public function getData($key)
    {
        $option = $this->settingOptions->where('key', $key)->first();
        return $option ? $option->value : "";
    }
}
