<?php

namespace Database\Seeders;

use App\Models\ProjectType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = ['Condominiums', 'Houses', 'Land', 'Commercial'];

        foreach ($data as $item) {
            ProjectType::create([
                'name' => $item,
                'status' => 'active',
            ]);
        }
    }
}
