<?php

namespace Database\Seeders;

use App\Models\PropertyType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PropertyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = ['Condominiums', 'Houses', 'Land', 'Commercial'];

        foreach($data as $item){
            PropertyType::create([
                'name' => $item,
                'status' => 'active',
            ]);
        }
    }
}
