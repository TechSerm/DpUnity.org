<?php

namespace App\Services\Theme;

use App\Cart\Cart;
use App\Enums\SettingEnum;
use App\Models\Slider;
use App\Services\Setting\SettingService;

class ThemeService
{
    private static $instance;

    private $textColor;
    private $color;
    private $header;
    private $slogan;
    private $mobile;
    private $messangerLink;
    private $title;
    private $logo;
    private $headline;
    private $favicon;

    public function __construct()
    {
        $this->initThemeData();
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function initThemeData()
    {
        $settingService = new SettingService();

        $this->color = $settingService->getData(SettingEnum::THEME_COLOR);
        $this->slogan =  $settingService->getData(SettingEnum::SLOGAN);
        $this->messangerLink = $settingService->getData(SettingEnum::MESSANGER_LINK);
        $this->mobile = $settingService->getData(SettingEnum::MOBILE_NUMBER);
        $this->title = $settingService->getData(SettingEnum::WEBSITE_TITLE);
        $this->logo = $settingService->getData(SettingEnum::LOGO);
        $this->favicon = $settingService->getData(SettingEnum::FAVICON);
        $this->headline = $settingService->getData(SettingEnum::HEADLINE);

        $this->textColor = (new ThemeColor())->get($this->color());
        $this->header = (new HeaderService())->get();
    }

    public function header()
    {
        return $this->header;
    }

    public function color()
    {
        return $this->color == "" ? "#000000" : $this->color;
    }

    public function textColor()
    {
        return $this->textColor;
    }

    public function logo()
    {
        return $this->logo;
    }

    public function favicon()
    {
        return $this->favicon;
    }

    public function slogan()
    {
        return $this->slogan;
    }

    public function mobile()
    {
        return $this->mobile;
    }

    public function messangerLink()
    {
        return $this->messangerLink;
    }

    public function title()
    {
        return $this->title;
    }

    public function headline()
    {
        return $this->headline;
    }

    public function totalCart()
    {
        return Cart::totalCart();
    }

    public function sliders()
    {
        $sliders = Slider::serialOrder()->with(['imageTable'])->get();
        $sliderImage = [];
        foreach ($sliders as $slider) {
            array_push($sliderImage, $slider->image);
        }

        return $sliderImage;
    }
}
