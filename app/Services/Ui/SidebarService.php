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
                'title' => 'Properties',
                'icon' => 'building-office-2',
                'route' => '#',
                'route_name' => 'properties*',
                'permission' => 'view-properties',
                'children' => [
                    [
                        'title' => 'List',
                        'icon' => 'table-cells',
                        'route' => route('dashboard'), // Update when properties.index route exists
                        'route_name' => 'properties.index',
                        'permission' => 'view-properties',
                    ],
                    [
                        'title' => 'New',
                        'icon' => 'folder-plus',
                        'route' => route('dashboard'), // Update when properties.create route exists
                        'route_name' => 'properties.create',
                        'permission' => 'create-properties',
                    ],
                ],
            ],
            [
                'title' => 'Announcements',
                'icon' => 'speaker-wave',
                'route' => route('dashboard'), // Update when announcements.index route exists
                'route_name' => 'announcements*',
                'permission' => 'view-properties', // Using view-properties for now, update when announcements permission exists
            ],
            [
                'title' => 'Users',
                'icon' => 'user-group',
                'route' => '#',
                'route_name' => 'users*',
                'permission' => 'view-users',
                'children' => [
                    [
                        'title' => 'List',
                        'icon' => 'table-cells',
                        'route' => route('dashboard'), // Update when users.index route exists
                        'route_name' => 'users.index',
                        'permission' => 'view-users',
                    ],
                    [
                        'title' => 'New',
                        'icon' => 'folder-plus',
                        'route' => route('dashboard'), // Update when users.create route exists
                        'route_name' => 'users.create',
                        'permission' => 'create-users',
                    ],
                ],
            ],
            [
                'title' => 'Locations',
                'icon' => 'map-pin',
                'route' => '#',
                'route_name' => 'locations*',
                'permission' => 'view-property_types',
                'children' => [
                    [
                        'title' => 'Property Types',
                        'icon' => 'tag',
                        'route' => route('dashboard'), // Update when property-types.index route exists
                        'route_name' => 'property-types.index',
                        'permission' => 'view-property_types',
                    ],
                ],
            ],
            [
                'title' => 'Facilities',
                'icon' => 'sparkles',
                'route' => route('facilities.index'),
                'route_name' => 'facilities*',
                'permission' => 'view-property_types', // Update when facilities permission exists
            ],
            [
                'title' => 'Projects',
                'icon' => 'building-office',
                'route' => route('projects.index'), // Update when projects.index route exists
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
                'title' => 'Settings',
                'icon' => 'cog-6-tooth',
                'route' => route('profile.edit'),
                'route_name' => 'settings*',
                'permission' => 'view-settings',
            ],
        ];
    }
}
