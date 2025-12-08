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
