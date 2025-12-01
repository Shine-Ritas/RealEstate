<?php

namespace Database\Seeders;

use App\Models\SocialLink;
use Illuminate\Database\Seeder;

class SocialLinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $socialLinks = [
            [
                'name' => 'Facebook',
                'url' => 'https://www.facebook.com',
                'status' => 'active',
                'icon' => 'facebook',
            ],
            [
                'name' => 'Twitter',
                'url' => 'https://www.twitter.com',
                'status' => 'active',
                'icon' => 'twitter',
            ],
            [
                'name' => 'Instagram',
                'url' => 'https://www.instagram.com',
                'status' => 'active',
                'icon' => 'instagram',
            ],
            [
                'name' => 'Line',
                'url' => 'https://www.line.com',
                'status' => 'active',
                'icon' => 'line',
            ],
            [
                'name' => 'YouTube',
                'url' => 'https://www.youtube.com',
                'status' => 'active',
                'icon' => 'youtube',
            ],
        ];

        SocialLink::insert($socialLinks);
    }
}
