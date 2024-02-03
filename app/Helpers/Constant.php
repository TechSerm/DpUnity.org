<?php

namespace App\Helpers;

class Constant
{
    public const UNITS = [
        'gram' => 'গ্রাম',
        'kg' => 'কেজি',
        'pice' => 'পিস',
        'box' => 'বাক্স',
        'liter' => 'লিটার',
        'ml' => 'মিলি',
    ];

    public const SITE_NAME = "Shobeikhane";

    public const IMAGE_DIR = "images/";

    public const DEFAULT_IMAGE = "default.png";

    public const SHIPPING_AREA_TYPE = [
        'all', 'selected'
    ];
}
