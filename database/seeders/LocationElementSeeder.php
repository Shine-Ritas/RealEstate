<?php

namespace Database\Seeders;

use App\Models\LocationElement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationElementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'hospital',
                'icon' => 'hospital',
            ],
            [
                'name' => 'school',
                'icon' => 'school',
            ],
            [
                'name' => 'university',
                'icon' => 'building-columns',
            ],
            [
                'name' => 'restaurant',
                'icon' => 'utensils',
            ],
            [
                'name' => 'hotel',
                'icon' => 'hotel',
            ],
            [
                'name' => 'airport',
                'icon' => 'plane-departure',
            ],
            [
                'name' => 'train station',
                'icon' => 'train',
            ],
            [
                'name' => 'bus station',
                'icon' => 'bus',
            ],
            [
                'name' => 'shopping mall',
                'icon' => 'store',
            ],
        ];

        LocationElement::insert($data);
    }
}
