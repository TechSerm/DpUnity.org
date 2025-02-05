<?php

namespace App\Helpers;

class BanglaFormatter
{
    /**
     * Mapping of Arabic digits to Bangla digits.
     *
     * @var array<string, string>
     */
    private const BANGLA_DIGITS = [
        '0' => '০',
        '1' => '১',
        '2' => '২',
        '3' => '৩',
        '4' => '৪',
        '5' => '৫',
        '6' => '৬',
        '7' => '৭',
        '8' => '৮',
        '9' => '৯'
    ];

    /**
     * Mapping of English months to Bangla months.
     *
     * @var array<string, string>
     */
    private const EN_TO_BN_MONTHS = [
        'Jan' => 'জানুয়ারী',
        'Feb' => 'ফেব্রুয়ারী',
        'Mar' => 'মার্চ',
        'Apr' => 'এপ্রিল',
        'May' => 'মে',
        'Jun' => 'জুন',
        'Jul' => 'জুলাই',
        'Aug' => 'অগাস্ট',
        'Sep' => 'সেপ্টেম্বর',
        'Oct' => 'অক্টোবর',
        'Nov' => 'নভেম্বর',
        'Dec' => 'ডিসেম্বর'
    ];
    
    /**
     * Mapping of English full names of months to Bangla months.
     *
     * @var array<string, string>
     */
    private const EN_TO_BN_FULL_MONTHS = [
        'January' => 'জানুয়ারী',
        'February' => 'ফেব্রুয়ারী',
        'March' => 'মার্চ',
        'April' => 'এপ্রিল',
        'May' => 'মে',
        'June' => 'জুন',
        'July' => 'জুলাই',
        'August' => 'অগাস্ট',
        'September' => 'সেপ্টেম্বর',
        'October' => 'অক্টোবর',
        'November' => 'নভেম্বর',
        'December' => 'ডিসেম্বর'
    ];

    /**
     * Mapping of relative time words to Bangla.
     *
     * @var array<string, string>
     */
    private const RELATIVE_TIME_WORDS = [
        'ago' => 'পূর্বে',
        'second' => 'সেকেন্ড',
        'seconds' => 'সেকেন্ড',
        'minute' => 'মিনিট',
        'minutes' => 'মিনিট',
        'hour' => 'ঘন্টা',
        'hours' => 'ঘন্টা',
        'day' => 'দিন',
        'days' => 'দিন',
        'week' => 'সপ্তাহ',
        'weeks' => 'সপ্তাহ',
        'month' => 'মাস',
        'months' => 'মাস',
        'year' => 'বছর',
        'years' => 'বছর',
    ];

    /**
     * Convert a unit name to its Bangla representation.
     *
     * @param string $unit
     * @return string
     */
    public function unit(string $unit): string
    {
        return Constant::UNITS[$unit] ?? $unit;
    }

    /**
     * Convert numbers to Bangla.
     *
     * @param string|int|float $number
     * @param bool $commaSeparator
     * @return string
     */
    public function number($number, bool $commaSeparator = true): string
    {
        if ($number === '') {
            return '';
        }

        $formattedNumber = $commaSeparator
            ? number_format($number, 0, '.', ',')
            : (string)$number;

        return $this->translateDigitsToBangla($formattedNumber);
    }

    /**
     * Convert float numbers to Bangla.
     *
     * @param string|int|float $number
     * @param int $decimalPoint
     * @return string
     */
    public function float($number, int $decimalPoint = 2): string
    {
        $formattedNumber = number_format($number, $decimalPoint, '.', ',');
        $banglaNumber = $this->translateDigitsToBangla($formattedNumber);

        if ($decimalPoint > 0) {
            $banglaNumber = rtrim($banglaNumber, '০');
            $banglaNumber = rtrim($banglaNumber, '.');
        }

        return $banglaNumber;
    }

    /**
     * Convert English date/time and relative time strings to Bangla.
     *
     * @param string $date
     * @return string
     */
    public function date(string $date): string
    {
        $banglaDateString = $this->number($date, false);
        $banglaDateString = strtr($banglaDateString, self::EN_TO_BN_FULL_MONTHS);
        $banglaDateString = strtr($banglaDateString, self::EN_TO_BN_MONTHS);
        $banglaDateString = strtr($banglaDateString, self::RELATIVE_TIME_WORDS);

        return $banglaDateString;
    }

    /**
     * Translate digits to Bangla.
     *
     * @param string $input
     * @return string
     */
    private function translateDigitsToBangla(string $input): string
    {
        return strtr($input, self::BANGLA_DIGITS);
    }
}
