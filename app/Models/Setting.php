<?php

namespace App\Models;

use App\Enums\SettingEnum;
use App\Services\Image\ImageService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Setting extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'uuid',
        'key',
        'title',
        'value',
    ];

    public function getTitleAttribute($value)
    {
        $lowercaseString = strtolower($this->key);
        $titleCaseString = ucwords($lowercaseString);
        $finalString = str_replace('_', ' ', $titleCaseString);
        return $finalString;
    }

    public function scopeGeneral($query)
    {
        $groupSetting = $this->groupSetting();
        return $query->whereIn("key", $groupSetting["general"]);
    }

    public function scopeLogo($query)
    {
        $groupSetting = $this->groupSetting();
        return $query->whereIn("key", $groupSetting["logo"]);
    }

    public function scopeSocialLink($query)
    {
        $groupSetting = $this->groupSetting();
        return $query->whereIn("key", $groupSetting["social_link"]);
    }

    public function getValueAttribute($value)
    {

        if (SettingEnum::LOGO == $this->key || SettingEnum::FAVICON == $this->key) {
            if ($value != "") {
                $image = Image::find($value);
                if ($image) {
                    return $image->src();
                }
            }

            return asset('assets/img/default_logo.png');
        }

        return $value;
    }

    public function getImageAttribute()
    {
        if ($this->getRawOriginal('value') == "") return null;
        $image = Image::find($this->getRawOriginal('value'));
        return $image;
    }

    public function getInputTypeAttribute()
    {
        if ($this->key == SettingEnum::THEME_COLOR) return "color";

        return "text";
    }

    public function isTextArea()
    {
        return $this->key == SettingEnum::SHORT_DESCRIPTION;
    }

    public function imageTable()
    {
        return $this->belongsTo(Image::class, 'image_id');
    }

    public function groupSetting()
    {
        return [
            "general" => [
                SettingEnum::WEBSITE_TITLE, SettingEnum::THEME_COLOR, SettingEnum::SLOGAN,
                SettingEnum::HEADLINE, SettingEnum::MOBILE_NUMBER, SettingEnum::EMAIL_ADDRESS,
                SettingEnum::COPYRIGHT, SettingEnum::STREET, SettingEnum::CITY, SettingEnum::STATE,
                SettingEnum::POSTER_CODE, SettingEnum::SHORT_DESCRIPTION,  SettingEnum::MESSANGER_LINK,
            ],
            "logo" => [
                SettingEnum::LOGO, SettingEnum::FAVICON,
            ],
            "social_link" => [
                SettingEnum::FACEBOOK, SettingEnum::TWITTER, SettingEnum::INSTAGRAM,
                SettingEnum::LINKEDIN, SettingEnum::YOUTUBE,
            ]
        ];
    }
}
