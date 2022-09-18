<?php

namespace App\Helpers;

class BnConvert
{
    public function unit($unit)
    {
        return Constant::UNITS[$unit] ?? $unit;
    }

    public function number($number, $commaSeparator = true)
    {
        $numbers = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
        $number = $commaSeparator ? number_format($number, 0, '.', ',') : $number;
        $number = strtr($number, $numbers);
        return $number;
    }
}
