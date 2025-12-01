<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $partners = [
            [
                'name' => 'Partner 1',
                'email' => 'partner1@gmail.com',
                'status' => 'active',
                'logo_path' => 'https://www.google.com',
            ],
        ];
        Partner::insert($partners);
    }
}
