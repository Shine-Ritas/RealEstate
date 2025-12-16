<?php

namespace App\Enums;

use App\Contracts\BaseEnumInterface;
use App\Traits\HasDropDown;

enum ListingTypeEnum : string implements BaseEnumInterface
{
    use HasDropDown;
    case Rent = 'rent';
    case Sale = 'sale';
    case Both = 'both';

    public function label(): string
    {
        return match ($this) {
            self::Rent => 'Rent',
            self::Sale => 'Sale',
            self::Both => 'Both',
        };
    }

}
