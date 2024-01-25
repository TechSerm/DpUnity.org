<?php
// Example background color (you would get this dynamically)
if(!function_exists('getRelativeLuminance')){
function getRelativeLuminance($color)
{
    $color = str_replace('#', '', $color);
    $r = hexdec(substr($color, 0, 2)) / 255;
    $g = hexdec(substr($color, 2, 2)) / 255;
    $b = hexdec(substr($color, 4, 2)) / 255;

    $r = $r <= 0.03928 ? $r / 12.92 : pow(($r + 0.055) / 1.055, 2.4);
    $g = $g <= 0.03928 ? $g / 12.92 : pow(($g + 0.055) / 1.055, 2.4);
    $b = $b <= 0.03928 ? $b / 12.92 : pow(($b + 0.055) / 1.055, 2.4);

    return 0.2126 * $r + 0.7152 * $g + 0.0722 * $b;
}
}

// Example background color (you can replace this with the actual background color)
$backgroundColor = '#000000';

// Calculate the luminance of the background color
$luminance = getRelativeLuminance($backgroundColor);

// Determine the contrast threshold (you can adjust this value based on your needs)
$contrastThreshold = 0.5;

// Set the text color based on the contrast
$textColor = $luminance > $contrastThreshold ? '#000000' : '#ffffff';

?>


<style>
    .theme-bg {
        background-color: {{ $backgroundColor }};
        color: {{ $textColor }};
    }

    .theme-bg a {
        color: {{ $textColor }};
    }

    .theme-bg a:hover {
        opacity: 0.7;
    }
</style>
