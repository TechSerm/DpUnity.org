<?php

namespace App\Services\Setting;

use App\Models\Setting;

class SettingService
{
    public function getData($key)
    {
        $option = [];
        return $option[$key] ?? "";
    }
}
