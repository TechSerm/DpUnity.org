<?php

namespace App\Services\SettingOption;

use App\Models\Setting;

class SettingOptionService
{
    public function __construct()
    {
    }

    public function getKeyValueData()
    {
        $settingOptions = Setting::all();
        $settingOptionsData = [];
        foreach ($settingOptions as $settingOption) {
            $settingOptionsData[$settingOption->key] = $settingOption->value;
        }
        return $settingOptionsData;
    }
}
