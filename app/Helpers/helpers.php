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

if (!function_exists('getProductDiscount')) {
    function getProductDiscountIncValue($price)
    {
        $incDiv = ceil($price / 100);
        if($price < 100)return $incDiv;
        if ($price % 5 != 0) return $incDiv;
        $divFiv = ceil($incDiv / 5);
        $amount = $divFiv * 5;
        if($divFiv > 600)return 10;
        return $divFiv * 5;
    }
}
