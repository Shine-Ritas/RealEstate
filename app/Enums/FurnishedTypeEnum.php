<?php

namespace App\Enums;

use App\Contracts\BaseEnumInterface;
use App\Traits\HasDropDown;

enum FurnishedTypeEnum : string implements BaseEnumInterface
{
    use HasDropDown;
    case Unfurnished = 'unfurnished';
    case Partial = 'partial';
    case Fully = 'fully';

    public function label(): string
    {
        return match ($this) {
            self::Unfurnished => 'Unfurnished',
            self::Partial => 'Partial',
            self::Fully => 'Fully',
        };
    }
}
