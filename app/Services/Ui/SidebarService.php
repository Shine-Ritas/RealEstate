<?php

namespace App\Services\Ui;

class SidebarService
{
    public static function get(): array
    {
        return [
            [
                'title' => 'Dashboard',
                'icon' => 'home',
                'route' => route('dashboard'),
                'route_name' => 'dashboard',
                'permission' => 'public',
            ],
            [
                'title' => 'Announcements',
                'icon' => 'speaker-wave',
                'route' => route('dashboard'), // Update when announcements.index route exists
                'route_name' => 'announcements*',
                'permission' => 'view-properties', // Using view-properties for now, update when announcements permission exists
            ],
            [
                'title' => 'Facilities',
                'icon' => 'sparkles',
                'route' => route('facilities.index'),
                'route_name' => 'facilities*',
                'permission' => 'view-property_types', // Update when facilities permission exists
            ],
            [
                'title' => 'Properties',
                'icon' => 'building-office',
                'route' => route('properties.index'), // Update when projects.index route exists
                'route_name' => 'projects.index',
                'permission' => 'view-projects',
            ],
            [
                'title' => 'Bookings',
                'icon' => 'calendar-days',
                'route' => route('dashboard'), // Update when bookings.index route exists
                'route_name' => 'bookings*',
                'permission' => 'view-bookings',
            ],
            [
                'title' => 'Reports',
                'icon' => 'chart-bar',
                'route' => route('dashboard'), // Update when reports.index route exists
                'route_name' => 'reports*',
                'permission' => 'view-reports',
            ],
            [
                'title' => 'Roles',
                'icon' => 'lock-closed',
                'route' => route('roles.index'),
                'route_name' => 'roles*',
                'permission' => 'view-roles',
            ],
            [
                'title' => 'Users',
                'icon' => 'user-group',
                'route' => route('users.index'),
                'route_name' => 'users*',
                'permission' => 'view-users',
            ],
            [
                'title' => 'Settings',
                'icon' => 'cog-6-tooth',
                'route' => route('profile.edit'),
                'route_name' => 'settings*',
                'permission' => 'view-settings',
            ],
        ];
    }
}
