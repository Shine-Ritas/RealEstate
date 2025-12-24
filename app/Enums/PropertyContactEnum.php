<?php

namespace App\Enums;

use App\Contracts\BaseEnumInterface;
use App\Traits\HasDropDown;

enum PropertyContactEnum : string implements BaseEnumInterface
{
    use HasDropDown;

    // $table->enum("contact_type",['line','phone','email','website','facebook','instagram','twitter','youtube','linkedin','other']);
    case Line = 'line';
    case Phone = 'phone';
    case Email = 'email';
    case Website = 'website';
    case Facebook = 'facebook';
    case Instagram = 'instagram';
    case Twitter = 'twitter';
    case Other = 'other';

    public function label(): string
    {
        return match ($this) {
            self::Line => 'Line',
            self::Phone => 'Phone',
            self::Email => 'Email',
            self::Website => 'Website',
            self::Facebook => 'Facebook',
            self::Instagram => 'Instagram',
            self::Twitter => 'Twitter',
            self::Other => 'Other',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Line => 'line',
            self::Phone => 'phone',
            self::Email => 'envelope',
            self::Website => 'globe',
            self::Facebook => 'facebook',
            self::Instagram => 'instagram',
            self::Twitter => 'twitter',
            self::Other => 'braille',
        };
    }
}
