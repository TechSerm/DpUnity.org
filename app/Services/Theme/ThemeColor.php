<?php

namespace App\Services\Theme;

class ThemeColor
{
    public function get($color)
    {
        $luminance = $this->getRelativeLuminance($color);
        $contrastThreshold = 0.5;
        return $luminance > $contrastThreshold ? '#000000' : '#ffffff';
    }

    private function getRelativeLuminance($color)
    {
        $color = str_replace('#', '', $color);
        $r = hexdec(substr($color, 0, 2)) / 255;
        $g = hexdec(substr($color, 2, 2)) / 255;
        $b = hexdec(substr($color, 4, 2)) / 255;

        $r = $r <= 0.03928 ? $r / 12.92 : pow(($r + 0.055) / 1.055, 2.4);
        $g = $g <= 0.03928 ? $g / 12.92 : pow(($g + 0.055) / 1.055, 2.4);
        $b = $b <= 0.03928 ? $b / 12.92 : pow(($b + 0.055) / 1.055, 2.4);

        // Set the text color based on the contrast
        return 0.2126 * $r + 0.7152 * $g + 0.0722 * $b;
    }
}
