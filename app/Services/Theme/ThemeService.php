<?php

namespace App\Services\Theme;

use App\Cart\Cart;
use App\Enums\OrderStatusEnum;
use App\Enums\SettingEnum;
use App\Models\Order;
use App\Models\Slider;
use App\Services\Setting\SettingService;
use Illuminate\Support\Facades\DB;

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
    private $labelCount;
    private $address;
    private $email;
    private $description;
    private $customHeadCode;
    private $customBodyCode;
    private $customFooterCode;

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
        $this->email = $settingService->getData(SettingEnum::EMAIL_ADDRESS);
        $this->description = $settingService->getData(SettingEnum::SHORT_DESCRIPTION);
        $this->customHeadCode = $settingService->getData(SettingEnum::CUSTOM_HEAD_CODE);
        $this->customBodyCode = $settingService->getData(SettingEnum::CUSTOM_BODY_CODE);
        $this->customFooterCode = $settingService->getData(SettingEnum::CUSTOM_FOOTER_CODE);
        $this->address = $settingService->getData(SettingEnum::STREET) . ", " . $settingService->getData(SettingEnum::CITY) . ", " . $settingService->getData(SettingEnum::STREET);

        $this->textColor = (new ThemeColor())->get($this->color());
        $this->header = (new HeaderService())->get();
    }

    public function header()
    {
        return $this->header;
    }

    public function color()
    {
        return $this->color;
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

    public function description()
    {
        return $this->description;
    }

    public function totalCart()
    {
        return Cart::totalCart();
    }

    public function email()
    {
        return $this->email;
    }

    public function address()
    {
        return $this->address;
    }

    public function customHeadCode()
    {
        return $this->customHeadCode;
    }

    public function customBodyCode()
    {
        return $this->customBodyCode;
    }

    public function customFooterCode()
    {
        return $this->customFooterCode;
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

    public function isOrderMenu($menuText)
    {
        $menuList = OrderStatusEnum::asSelectArray();
        array_push($menuList, "All Orders");
        return in_array($menuText, $menuList);
    }

    public function getLableCount($menuText)
    {
        if (empty($this->labelCount)) {

            $this->labelCount = Order::select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->pluck('count', 'status')->toArray();
            $this->labelCount['all orders'] = array_sum($this->labelCount);
        }

        return $this->labelCount[strtolower($menuText)] ?? 0;
    }
}
