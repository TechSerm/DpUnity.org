<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class UploadDirectoryEnum extends Enum
{
    const NEWS_THUMBNAILS = "news/news-thumbnails";
    const NEWS_CONTENT = "news/news-content";
    const SLIDERS = "settings/sliders";
    const LOGOS = "settings/logos";
    const FAVICONS = "settings/favicons";
    const GENERAL = "settings/general";
    const ABOUT_US = "settings/about_us";
    const PROJECT_EXPENCES = "project-expences";
    
}
