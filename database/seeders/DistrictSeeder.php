<?php

namespace Database\Seeders;

use App\Models\District;
use App\Services\Clients\VendorClient;
use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendorClient = new VendorClient;
        $districts = $vendorClient->getDistricts()->json();

        $insertDistrict = [];
        foreach ($districts as $district) {
            $insertDistrict[] = [
                'd_code' => 'DT-'.str_pad($district['id'], 6, '0', STR_PAD_LEFT),
                'd_name' => $district['name_en'],
                'p_code' => 'PL-'.str_pad($district['province_id'], 3, '0', STR_PAD_LEFT),
            ];
        }

        District::insert($insertDistrict);
    }
}
