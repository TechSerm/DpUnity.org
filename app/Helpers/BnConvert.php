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

    public function floatNumber($number, $decimalPoint = 2)
    {
        $numbers = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
        $formattedNumber = number_format($number, $decimalPoint, '.', ',');
        $formattedNumber = strtr($formattedNumber, $numbers);

        if ($decimalPoint > 0) {
            $formattedNumber = rtrim($formattedNumber, '০'); // Remove trailing zeros
            $formattedNumber = rtrim($formattedNumber, '.'); // Remove decimal point if no decimal places left
        }

        return $formattedNumber;
    }


    public function date($date)
    {

        $enShortMonths = [
            'Jan' => 'জানুয়ারী',
            'Feb' => 'ফেব্রুয়ারী',
            'Mar' => 'মার্চ',
            'Apr' => 'এপ্রিল',
            'May' => 'মে',
            'June' => 'জুন',
            'July' => 'জুলাই',
            'Aug' => 'অগাস্ট',
            'Sep' => 'সেপ্টেম্বর',
            'Oct' => 'অক্টোবর',
            'Nov' => 'নভেম্বর',
            'Dec' => 'ডিসেম্বর'
        ];

        $humanString = [
            'ago' => 'পূর্বে',
            'second' => 'সেকেন্ড',
            'seconds' => 'সেকেন্ড',
            'minute' => 'মিনিট',
            'minutes' => 'মিনিট',
            'hour' => 'ঘন্টা',
            'hours' => 'ঘন্টা',
            'day' => 'দিন',
            'days' => 'দিন',
            'week' => 'সপ্তাহ ',
            'weeks' => 'সপ্তাহ ',
            'month' => 'মাস',
            'months' => 'মাস',
            'year' => 'বছর',
            'years' => 'বছর',
        ];

        $date = $this->number($date, false);
        $date = strtr($date, $enShortMonths);
        $date = strtr($date, $humanString);

        return $date;
    }
}
