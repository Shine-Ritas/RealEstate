<?php

namespace App\Traits;

trait HasDropdown
{
    /**
     * [
     *   ['label' => 'Condo', 'value' => 'condo'],
     *   ...
     * ]
     */
    public static function dropdown(): array
    {
        return collect(self::cases())
            ->map(fn ($case) => [
                'label' => $case->label(),
                'value' => $case->value,
            ])
            ->values()
            ->toArray();
    }

    /**
     * value => label (useful for edit forms)
     */
    public static function dropdownByValue(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn ($case) => [
                $case->value => $case->label(),
            ])
            ->toArray();
    }

    /**
     * Get label from value safely
     */
    public static function labelFrom(string|int|null $value): ?string
    {
        return self::tryFrom($value)?->label();
    }
}
