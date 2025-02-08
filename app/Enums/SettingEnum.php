<?php

namespace App\Enums;

use App\Enums\data\SettingEnumData;
use BenSampo\Enum\Enum;

final class SettingEnum extends Enum
{
    const WEBSITE_TITLE = "WEBSITE_TITLE";
    const SLOGAN = "SLOGAN";
    const HEADLINE = "HEADLINE";
    const MOBILE_NUMBER = 'MOBILE_NUMBER';
    const EMAIL_ADDRESS = "EMAIL_ADDRESS";
    const COPYRIGHT = "COPY_RIGHT";
    const SHORT_DESCRIPTION = "SHORT_DESCRIPTION";
    const MESSANGER_LINK = "MESSANGER_LINK";
    const LOGO = "LOGO";
    const FAVICON = "FAVICON";
    const FACEBOOK = "FACEBOOK";
    const TWITTER = "TWITTER";
    const INSTAGRAM = "INSTAGRAM";
    const LINKEDIN = "LINKEDIN";
    const YOUTUBE = "YOUTUBE";
    const TESTFIELD = "TESTFIELD";
    const ABOUT_US = "ABOUT_US";
    const SLIDERS = "SLIDERS";

    public function getCastType(): string
    {
        return SettingEnumData::getCastType($this->value);
    }
    
}
