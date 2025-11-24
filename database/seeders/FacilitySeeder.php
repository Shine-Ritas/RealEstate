<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataSets = [
            // Core Facilities
            ['name' => 'Swimming Pool',       'icon' => 'swimming',          'status' => 'active'],
            ['name' => 'Gym',                 'icon' => 'dumbbell',           'status' => 'active'],
            ['name' => 'Sauna',               'icon' => 'flame',              'status' => 'active'],
            ['name' => 'Steam Room',          'icon' => 'cloud',              'status' => 'active'],
            ['name' => 'Jacuzzi',             'icon' => 'waves',              'status' => 'active'],

            // Security
            ['name' => '24-Hour Security',    'icon' => 'shield-check',       'status' => 'active'],
            ['name' => 'CCTV',                'icon' => 'camera',             'status' => 'active'],
            ['name' => 'Keycard Access',      'icon' => 'key-round',          'status' => 'active'],
            ['name' => 'Security Guard',      'icon' => 'user-shield',        'status' => 'active'],

            // Parking & Transport
            ['name' => 'Car Parking',         'icon' => 'car',                'status' => 'active'],
            ['name' => 'Motorbike Parking',   'icon' => 'motorcycle',         'status' => 'active'],
            ['name' => 'Bicycle Parking',     'icon' => 'bike',               'status' => 'active'],
            ['name' => 'Shuttle Bus',         'icon' => 'bus',                'status' => 'active'],

            // Outdoor Facilities
            ['name' => 'Rooftop Garden',      'icon' => 'leaf',               'status' => 'active'],
            ['name' => 'Garden / Park',       'icon' => 'tree-pine',          'status' => 'active'],
            ['name' => 'Playground',          'icon' => 'sailboat',           'status' => 'active'],
            ['name' => 'BBQ Area',            'icon' => 'flame',              'status' => 'active'],

            // Indoor Facilities
            ['name' => 'Library',             'icon' => 'book-open',          'status' => 'active'],
            ['name' => 'Meeting Room',        'icon' => 'presentation-chart-line', 'status' => 'active'],
            ['name' => 'Co-working Space',    'icon' => 'building-office-2',  'status' => 'active'],
            ['name' => 'Lounge',              'icon' => 'couch',              'status' => 'active'],

            // Building-level
            ['name' => 'Elevator',            'icon' => 'arrow-up-down',      'status' => 'active'],
            ['name' => 'Service Elevator',    'icon' => 'truck',              'status' => 'active'],
            ['name' => 'Lobby',               'icon' => 'home-modern',        'status' => 'active'],

            // Sports
            ['name' => 'Tennis Court',        'icon' => 'circle',             'status' => 'active'],
            ['name' => 'Basketball Court',    'icon' => 'circle',             'status' => 'active'],
            ['name' => 'Squash Court',        'icon' => 'circle',             'status' => 'active'],
            ['name' => 'Yoga Room',           'icon' => 'user',               'status' => 'active'],

            // Lifestyle
            ['name' => 'Pet Friendly',        'icon' => 'paw-print',          'status' => 'active'],
            ['name' => 'Restaurant',          'icon' => 'fork-knife',         'status' => 'active'],
            ['name' => 'Cafe',                'icon' => 'cup',                'status' => 'active'],
            ['name' => 'Mini Mart',           'icon' => 'shopping-bag',       'status' => 'active'],

            // Wellness
            ['name' => 'Spa',                 'icon' => 'sparkles',           'status' => 'active'],
            ['name' => 'Massage Room',        'icon' => 'sparkles',           'status' => 'active'],
            ['name' => 'Clinic / Nurse',      'icon' => 'medical-cross',      'status' => 'active'],

            // Utilities
            ['name' => 'Wi-Fi',               'icon' => 'wifi',               'status' => 'active'],
            ['name' => 'Laundry Room',        'icon' => 'washing-machine',    'status' => 'active'],
            ['name' => 'Garbage Disposal',    'icon' => 'trash',              'status' => 'active'],
        ];

        Facility::insert($dataSets);
    }
}
