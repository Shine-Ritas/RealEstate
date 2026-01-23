<?php

namespace Database\Seeders;

use App\Models\Content;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // header
        $guest = require base_path('lang/my/guest.php');

        $keys = array_keys($guest);

        foreach ($keys as $key => $value) {
            // get from langague files
            $en = trans('guest.'.$value, [], 'en');
            $th = trans('guest.'.$value, [], 'th');
            $my = trans('guest.'.$value, [], 'my');
            $zh = trans('guest.'.$value, [], 'zh');
            $insert[] = [
                'key' => $value,
                'label' => $en,
                'en' => $en,
                'th' => $th,
                'my' => $my,
                'zh' => $zh,
            ];
        }
        Content::insert($insert);
    }
}
