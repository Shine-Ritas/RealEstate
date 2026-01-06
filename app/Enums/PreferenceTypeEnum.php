<?php

namespace App\Enums;
use App\Contracts\BaseEnumInterface;
use App\Traits\HasDropDown;


enum PreferenceTypeEnum : string implements BaseEnumInterface
{
    use HasDropDown;

    case Recommendation = "recommendation";
    case Popular = 'popular';

    public function label(): string
    {
        return match ($this) {
            self::Recommendation => 'Recommendation',
            self::Popular => 'Popular'
        };
    }
}
