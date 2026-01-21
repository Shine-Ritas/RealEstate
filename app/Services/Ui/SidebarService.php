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
                'title' => 'Social Links',
                'icon' => 'link',
                'route' => route('social-links.index'),
                'route_name' => 'users*',
                'permission' => 'view-users',
            ],
            [
                'title' => 'Listings',
                'icon' => 'list-bullet',
                'route' => route('prefer-list.index'),
                'route_name' => 'prefer-list*',
                'permission' => 'view-prefer-list',
            ],
            [
                'title' => 'CRM',
                'icon' => 'clipboard-document',
                'route' => route('content-page.index'),
                'route_name' => 'content-page*',
                'permission' => 'view-content-page',
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
