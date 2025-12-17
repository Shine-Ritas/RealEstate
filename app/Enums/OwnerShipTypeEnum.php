<?php

namespace App\Enums;

use App\Contracts\BaseEnumInterface;
use App\Traits\HasDropDown;
enum OwnerShipTypeEnum : string implements BaseEnumInterface
{
    use HasDropDown;
    case Freehold = 'freehold';
    case Leasehold = 'leasehold';

    public function label(): string
    {
        return match ($this) {
            self::Freehold => 'Freehold',
            self::Leasehold => 'Leasehold',
        };
    }
}
