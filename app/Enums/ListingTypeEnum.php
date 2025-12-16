<?php

namespace App\Enums;

use App\Contracts\BaseEnumInterface;
use App\Traits\HasDropdown;

enum ListingTypeEnum : string implements BaseEnumInterface
{
    use HasDropdown;
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
