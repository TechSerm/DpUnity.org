<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class CategoryEnum extends Enum
{
    const SODDOSHO = "soddosho";
    const SHOHOJODDHA = "shohojoddha";
    const SHUVOKANKKHI = "shuvokankkhi";

    public function toBangla()
    {
        switch ($this->value) {
            case self::SODDOSHO:
                return "সদস্য";
            case self::SHOHOJODDHA:
                return "সহযোদ্ধা";
            case self::SHUVOKANKKHI:
                return "শুভাকাঙ্ক্ষী";
            default:
                return $this->value;
        }
    }

    public static function toBanglaArray()
    {
        return [
            self::SODDOSHO => "সদস্য",
            self::SHOHOJODDHA => "সহযোদ্ধা",
            self::SHUVOKANKKHI => "শুভাকাঙ্ক্ষী",
        ];
    }
}
