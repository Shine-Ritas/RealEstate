<?php

namespace Database\Seeders;

use App\Models\Subdistrict;
use App\Services\Clients\VendorClient;
use Illuminate\Database\Seeder;

class SubdistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendorClient = new VendorClient;
        $subdistricts = $vendorClient->getSubdistricts()->json();

        // this has 9000 records go by chunk
        $chunkSize = 1000;
        $subdistrictChunks = array_chunk($subdistricts, $chunkSize);

        $insertSubdistrict = [];
        foreach ($subdistrictChunks as $subdistrict) {

            foreach ($subdistrict as $si) {
                $insertSubdistrict[] = [
                    's_code' => 'SD-'.str_pad($si['id'], 9, '0', STR_PAD_LEFT),
                    's_name' => $si['name_en'],
                    'd_code' => 'DT-'.str_pad($si['district_id'], 6, '0', STR_PAD_LEFT),
                    'zip_code' => $si['zip_code'],
                ];
            }
        }

        Subdistrict::insert($insertSubdistrict);
    }
}
