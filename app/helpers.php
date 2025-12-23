<?php

use App\Services\Ui\SidebarService;

if (! function_exists('sidebar')) {
    function sidebar(): array
    {
        return SidebarService::get();
    }
}

if (! function_exists('numberToK')) {
    function numberToK($number, $round = 2): mixed
    {
        if ($number >= 1000) {
            return round($number / 1000, $round).'k';
        }

        return $number;
    }
}

if (! function_exists('is_active_navigation')) {
    function is_active_navigation($route): bool
    {
        return request()->routeIs($route);
    }
}

if(!function_exists('convert_to_dropdown')) {
    function convert_to_dropdown(mixed $data, string $label, string $value,string $icon = null): mixed {
            return $data->map(function ($item) use ($label, $value,$icon) {
                return [
                    'label' => ucfirst($item->$label),
                    'value' => $item->$value,
                    'icon' => $icon ? $item->$icon : null
                ];
            });
    }
}


if(!function_exists('currency')) {
    function currency(): string
    {
        return config('control.default_currency');
    }
}

if(!function_exists('currency_symbol')) {
    function currency_symbol(): string
    {
        return match(currency()) {
            'THB' => '฿',
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'JPY' => '¥',
            'KRW' => '₩',
            'CNY' => '¥',
        };
    }
}