<?php

use App\Helpers\BnConvert;

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
