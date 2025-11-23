<?php

namespace Database\Seeders;

use App\Models\Province;
use App\Services\Clients\VendorClient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendorClient = new VendorClient();
        $provinces = $vendorClient->getProvinces()->json();

        $insertProvince = [];
        foreach($provinces as $province){
            $insertProvince[] = [
                'p_code' => "PL-".str_pad($province['id'], 3, '0', STR_PAD_LEFT),
                'p_name' => $province['name_en'],
            ];
        }

        Province::insert($insertProvince);
    }
}
