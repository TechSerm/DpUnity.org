<?php

namespace App\Services\Theme;


class ThemeService
{
    private static $instance;

    private $textColor;
    private $color;
    private $header;

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
        $this->color = "#8e44ad";
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
        return "https://digital-bazar.com/uploads/info/logo.png";
    }

    public function favicon()
    {
        return "";
    }
}
