<?php

namespace App\Enums;

use App\Contracts\BaseEnumInterface;
use App\Traits\HasDropDown;
enum PropertyStatusTypeEnum :string implements BaseEnumInterface    
{
    use HasDropDown;
    case Active = 'active';
    case Pending = 'pending';
    case Sold = 'sold';
    case Rented = 'rented';
    case Draft = 'draft';

    public function label(): string
    {
        return match ($this) {
            self::Active => 'Active',
            self::Pending => 'Pending',
            self::Sold => 'Sold',
            self::Rented => 'Rented',
            self::Draft => 'Draft',
        };
    }

}
