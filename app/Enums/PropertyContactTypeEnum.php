<?php

namespace App\Enums;


use App\Contracts\BaseEnumInterface;
use App\Traits\HasDropDown;


enum PropertyContactTypeEnum  : string implements BaseEnumInterface
{
    use HasDropDown;

    case Office = 'office';
    case Agent = 'agent';

    public function label(): string
    {
        return match ($this) {
            self::Office => 'Office',
            self::Agent => 'Agent',
        };
    }

}
