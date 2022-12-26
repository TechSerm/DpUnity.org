<?php

use App\Helpers\BnConvert;
use App\Helpers\DeviceInfo;

/**
 * Bangla Convert
 *
 * @return string
 */
if (!function_exists('bnConvert')) {
    function bnConvert()
    {
        return new BnConvert();
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