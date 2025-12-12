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
            ['name' => 'Swimming Pool',       'icon' => 'water-ladder',        'status' => 'active'],
            ['name' => 'Gym',                 'icon' => 'dumbbell',            'status' => 'active'],
            ['name' => 'Sauna',               'icon' => 'fire',                'status' => 'active'],
            ['name' => 'Steam Room',          'icon' => 'cloud',               'status' => 'active'],

            // Security
            ['name' => '24-Hour Security',    'icon' => 'shield',               'status' => 'active'],
            ['name' => 'CCTV',                'icon' => 'camera',               'status' => 'active'],
            ['name' => 'Keycard Access',      'icon' => 'key',                  'status' => 'active'],
            ['name' => 'Security Guard',      'icon' => 'user-shield',          'status' => 'active'],

            // Parking & Transport
            ['name' => 'Car Parking',         'icon' => 'car',                  'status' => 'active'],
            ['name' => 'Motorbike Parking',   'icon' => 'motorcycle',           'status' => 'active'],
            ['name' => 'Bicycle Parking',     'icon' => 'bicycle',              'status' => 'active'],
            ['name' => 'Shuttle Bus',         'icon' => 'bus',                  'status' => 'active'],

            // Outdoor Facilities
            ['name' => 'Rooftop Garden',      'icon' => 'leaf',                 'status' => 'active'],
            ['name' => 'Garden / Park',       'icon' => 'tree',                 'status' => 'active'],
            ['name' => 'Playground',          'icon' => 'child',                'status' => 'active'],
            ['name' => 'BBQ Area',            'icon' => 'fire',                 'status' => 'active'],

            // Indoor Facilities
            ['name' => 'Library',             'icon' => 'book-open',            'status' => 'active'],
            ['name' => 'Meeting Room',        'icon' => 'users',                'status' => 'active'],
            ['name' => 'Co-working Space',    'icon' => 'building',             'status' => 'active'],
            ['name' => 'Lounge',              'icon' => 'couch',                 'status' => 'active'],

            // Building-level
            ['name' => 'Elevator',            'icon' => 'arrow-up',              'status' => 'active'],
            ['name' => 'Service Elevator',    'icon' => 'truck',                'status' => 'active'],
            ['name' => 'Lobby',               'icon' => 'home',                  'status' => 'active'],

            // Sports
            ['name' => 'Tennis Court',        'icon' => 'table-tennis-paddle-ball', 'status' => 'active'],
            ['name' => 'Basketball Court',    'icon' => 'basketball',           'status' => 'active'],
            ['name' => 'Squash Court',        'icon' => 'table-tennis-paddle-ball', 'status' => 'active'],
            ['name' => 'Yoga Room',           'icon' => 'user',                 'status' => 'active'],

            // Lifestyle
            ['name' => 'Pet Friendly',        'icon' => 'paw',                  'status' => 'active'],
            ['name' => 'Restaurant',          'icon' => 'utensils',              'status' => 'active'],
            ['name' => 'Cafe',                'icon' => 'coffee',                'status' => 'active'],
            ['name' => 'Mini Mart',           'icon' => 'shopping-bag',          'status' => 'active'],

            // Wellness
            ['name' => 'Spa',                 'icon' => 'star',                  'status' => 'active'],
            ['name' => 'Massage Room',        'icon' => 'hand',                  'status' => 'active'],
            ['name' => 'Clinic / Nurse',      'icon' => 'hospital',              'status' => 'active'],

            // Utilities
            ['name' => 'Wi-Fi',               'icon' => 'wifi',                  'status' => 'active'],
            ['name' => 'Laundry Room',        'icon' => 'shirt',                 'status' => 'active'],
            ['name' => 'Garbage Disposal',    'icon' => 'trash',                 'status' => 'active'],
        ];

        Facility::insert($dataSets);
    }
}
