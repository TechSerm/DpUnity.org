<?php

namespace App\Models;

use App\Enums\SettingEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    /**
     * Get the setting enum associated with the key.
     *
     * @return SettingEnum|null
     */
    public function getSettingEnumAttribute(): ?SettingEnum
    {
        if (!$this->key) {
            return null;
        }

        return SettingEnum::hasKey($this->key) ? SettingEnum::fromKey($this->key) : null;
    }

    public function scopeOnlyEnumData($query)
    {
        return $query->whereIn('key', SettingEnum::getKeys());
    }

    /**
     * Get the title attribute in a human-readable format.
     *
     * @param string $value
     * @return string
     */
    public function getTitleAttribute($value): string
    {
        $key = $this->key ?? '';
        $lowercaseString = strtolower($key);
        $titleCaseString = ucwords(str_replace('_', ' ', $lowercaseString));
        return $titleCaseString;
    }

    /**
     * Get the value attribute with proper casting based on SettingEnum.
     *
     * @param string|null $value
     * @return mixed
     */
    public function getValueAttribute($value)
    {
        if ($this->isArrayField()) {
            return json_decode($value, true);
        }

        return $value;
    }

    public function setValueAttribute($value)
    {
        if ($this->isArrayField()) {
            $value = json_encode($value);
        }

        $this->attributes['value'] = $value;
    }

    private function isArrayField(): bool
    {
        $settingEnum = $this->settingEnum;
        return $settingEnum && $settingEnum->getCastType() === 'array';
    }
}
