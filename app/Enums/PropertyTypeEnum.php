<?php

namespace App\Enums;

use App\Contracts\BaseEnumInterface;
use App\Traits\HasDropDown;

enum PropertyTypeEnum: string implements BaseEnumInterface
{
    use HasDropDown;
    case Condo = 'condo';
    case House = 'house';
    case Apartment = 'apartment';
    case Townhouse = 'townhouse';
    case Villa = 'villa';
    case Land = 'land';
    case Commercial = 'commercial';

    public function label(): string
    {
        return match ($this) {
            self::Condo => 'Condo',
            self::House => 'House',
            self::Apartment => 'Apartment',
            self::Townhouse => 'Townhouse',
            self::Villa => 'Villa',
            self::Land => 'Land',
            self::Commercial => 'Commercial',
        };
    }

}
