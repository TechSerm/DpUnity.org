<?php

namespace App\Enums\data;

use App\Enums\SettingEnum;
use App\Enums\UploadDirectoryEnum;
use App\Services\FormBuilder\FormComponentBuilder;
use Illuminate\Support\Collection;

class SettingEnumData
{
    /**
     * Get all setting configurations with detailed metadata
     *
     * @return Collection
     */
    public static function getSettings(): Collection
    {
        return collect(self::settingsData());
    }

    /**
     * Get configuration for a specific setting
     *
     * @param string $key
     * @param string|null $subKey
     * @return mixed
     */
    public static function getSetting(string $key, ?string $subKey = null): mixed
    {
        $settings = self::getSettings();
        $setting = $settings->firstWhere('key', $key);

        return $subKey ? $setting->{$subKey} ?? null : $setting;
    }

    public static function getCastType(string $key): string
    {
        $settings = self::getSettings();
        $setting = $settings->firstWhere(function ($setting) use ($key) {
            return $setting->getKey() === $key;
        });

        return $setting ? $setting->getCastType() : 'string';
    }

    /**
     * Get default value for a setting
     *
     * @param string $key
     * @return mixed
     */
    public static function getDefaultValue(string $key)
    {
        return self::getSetting($key, 'default');
    }

    /**
     * Get validation rules for a setting
     *
     * @param string $key
     * @return array
     */
    public static function getValidationRules(string $key): array
    {
        return self::getSetting($key, 'rules') ?? [];
    }

    /**
     * Get settings grouped by main group and subgroup
     *
     * @return Collection
     */
    public static function getGroupedSettings(): Collection
    {
        return self::getSettings()
            ->groupBy(fn($setting) => $setting->getGroupName())
            ->map(function ($groupSettings) {
                return $groupSettings
                    ->groupBy(fn($setting) => $setting->getSubGroupName())
                    ->map(function ($subgroupSettings) {
                        return $subgroupSettings
                            ->sortBy('priority')
                            ->values();
                    });
            });
    }

    /**
     * Internal method to define settings data
     *
     * @return array
     */
    private static function settingsData(): array
    {
        return [
            // Website Group
            FormComponentBuilder::make(SettingEnum::WEBSITE_TITLE)
                ->textInput()
                ->group("General")
                ->subgroup("Basics")
                ->label("Website Title")
                ->width(6)
                ->default("DpUnity")
                ->rules(['required', 'string', 'max:100'])
                ->helperText("The main title of your website")
                ->priority(1),

            FormComponentBuilder::make(SettingEnum::SLOGAN)
                ->textInput()
                ->group("General")
                ->subgroup("Basics")
                ->label("Website Slogan")
                ->width(6)
                ->default("Empowering Communities")
                ->rules(['nullable', 'string', 'max:255'])
                ->helperText("A short, memorable tagline for your website")
                ->priority(2),

            FormComponentBuilder::make(SettingEnum::SHORT_DESCRIPTION)
                ->textArea()
                ->group("General")
                ->subgroup("Basics")
                ->label("Site Description")
                ->width(6)
                ->rules(['nullable', 'string', 'max:500'])
                ->helperText("A brief description of your website (for SEO)")
                ->priority(3),

            // Visual Assets Group
            FormComponentBuilder::make(SettingEnum::LOGO)
                ->image()
                ->group("General")
                ->subgroup("Visual")
                ->label("Website Logo")
                ->width(6)
                ->rules(['nullable', 'image', 'mimes:png,jpg,jpeg,svg', 'max:2048'])
                ->helperText("Upload your website logo (recommended: PNG, max 2MB)")
                ->directory(UploadDirectoryEnum::LOGOS)
                ->priority(1),

            FormComponentBuilder::make(SettingEnum::FAVICON)
                ->image()
                ->group("General")
                ->subgroup("Visual")
                ->label("Favicon")
                ->width(6)
                ->rules(['nullable', 'image', 'mimes:png,ico', 'max:512'])
                ->helperText("Upload your website favicon (recommended: PNG, ICO, max 512KB)")
                ->directory(UploadDirectoryEnum::FAVICONS)
                ->priority(2),

            // Contact Group
            FormComponentBuilder::make(SettingEnum::MOBILE_NUMBER)
                ->textInput()
                ->group("contact")
                ->subgroup("primary")
                ->label("Contact Mobile Number")
                ->rules(['nullable', 'string'])
                ->helperText("Primary contact mobile number (Bangladeshi format)")
                ->priority(1),

            FormComponentBuilder::make(SettingEnum::EMAIL_ADDRESS)
                ->email()
                ->group("contact")
                ->subgroup("primary")
                ->label("Contact Email")
                ->rules(['nullable', 'email', 'max:100'])
                ->helperText("Primary contact email address")
                ->priority(2),

            // Social Media Group
            FormComponentBuilder::make(SettingEnum::FACEBOOK)
                ->url()
                ->group("social")
                ->subgroup("platforms")
                ->label("Facebook Page URL")
                ->rules(['nullable', 'url'])
                ->helperText("Link to your Facebook page")
                ->priority(1),

            FormComponentBuilder::make(SettingEnum::TWITTER)
                ->url()
                ->group("social")
                ->subgroup("platforms")
                ->label("Twitter Profile URL")
                ->rules(['nullable', 'url'])
                ->helperText("Link to your Twitter profile")
                ->priority(2),

            FormComponentBuilder::make(SettingEnum::INSTAGRAM)
                ->url()
                ->group("social")
                ->subgroup("platforms")
                ->label("Instagram Profile URL")
                ->rules(['nullable', 'url'])
                ->helperText("Link to your Instagram profile")
                ->priority(3),

            FormComponentBuilder::make(SettingEnum::LINKEDIN)
                ->url()
                ->group("social")
                ->subgroup("platforms")
                ->label("LinkedIn Profile URL")
                ->rules(['nullable', 'url'])
                ->helperText("Link to your LinkedIn profile")
                ->priority(4),

            FormComponentBuilder::make(SettingEnum::YOUTUBE)
                ->url()
                ->group("social")
                ->subgroup("platforms")
                ->label("YouTube Channel URL")
                ->rules(['nullable', 'url'])
                ->helperText("Link to your YouTube channel")
                ->priority(5),

            FormComponentBuilder::make(SettingEnum::ABOUT_US)
                ->repeater()
                ->group("About Us")
                ->label("About Us")
                ->fields([
                    // Text input for title
                    FormComponentBuilder::make('title')
                        ->textInput()
                        ->label('Title')
                        ->rules(['required'])
                        ->helperText('Title for the About Us section'),

                    // Rich editor for description
                    FormComponentBuilder::make('content')
                        ->richEditor()
                        ->label('Content')
                        ->rules(['nullable'])
                        ->directory(UploadDirectoryEnum::ABOUT_US)
                        ->helperText('Detailed description for the About Us section')
                ])
                ->priority(999),

            FormComponentBuilder::make(SettingEnum::SLIDERS)
                ->image()
                ->group("Home Page")
                ->subgroup("Basic")
                ->label("Slider")
                ->width(12)
                ->multiple()
                ->reorderable()
                ->imageEditor()
                ->maxFiles(10)
                ->panelLayout('grid')
                ->rules(['nullable', 'image', 'mimes:png,jpg,jpeg,svg', 'max:2048'])
                ->helperText("Upload your website logo (recommended: PNG, max 2MB)")
                ->directory(UploadDirectoryEnum::SLIDERS)
                ->priority(1),
        ];
    }
}
