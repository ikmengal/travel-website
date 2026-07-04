<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SocialLink;

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
                'slug' => 'facebook',
                'icon' => 'ti ti-brand-facebook',
                'url' => 'https://facebook.com/',
                'color' => '#1877F2',
                'open_in_new_tab' => true,
                'is_header' => true,
                'is_footer' => true,
                'status' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Instagram',
                'slug' => 'instagram',
                'icon' => 'ti ti-brand-instagram',
                'url' => 'https://instagram.com/',
                'color' => '#E4405F',
                'open_in_new_tab' => true,
                'is_header' => true,
                'is_footer' => true,
                'status' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'X (Twitter)',
                'slug' => 'twitter',
                'icon' => 'ti ti-brand-x',
                'url' => 'https://x.com/',
                'color' => '#000000',
                'open_in_new_tab' => true,
                'is_header' => true,
                'is_footer' => true,
                'status' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'LinkedIn',
                'slug' => 'linkedin',
                'icon' => 'ti ti-brand-linkedin',
                'url' => 'https://linkedin.com/',
                'color' => '#0A66C2',
                'open_in_new_tab' => true,
                'is_header' => false,
                'is_footer' => true,
                'status' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'YouTube',
                'slug' => 'youtube',
                'icon' => 'ti ti-brand-youtube',
                'url' => 'https://youtube.com/',
                'color' => '#FF0000',
                'open_in_new_tab' => true,
                'is_header' => false,
                'is_footer' => true,
                'status' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'TikTok',
                'slug' => 'tiktok',
                'icon' => 'ti ti-brand-tiktok',
                'url' => 'https://tiktok.com/',
                'color' => '#000000',
                'open_in_new_tab' => true,
                'is_header' => false,
                'is_footer' => true,
                'status' => true,
                'sort_order' => 6,
            ],
            [
                'name' => 'WhatsApp',
                'slug' => 'whatsapp',
                'icon' => 'ti ti-brand-whatsapp',
                'url' => 'https://wa.me/',
                'color' => '#25D366',
                'open_in_new_tab' => true,
                'is_header' => true,
                'is_footer' => true,
                'status' => true,
                'sort_order' => 7,
            ],
            [
                'name' => 'Telegram',
                'slug' => 'telegram',
                'icon' => 'ti ti-brand-telegram',
                'url' => 'https://t.me/',
                'color' => '#26A5E4',
                'open_in_new_tab' => true,
                'is_header' => false,
                'is_footer' => true,
                'status' => true,
                'sort_order' => 8,
            ],
            [
                'name' => 'Pinterest',
                'slug' => 'pinterest',
                'icon' => 'ti ti-brand-pinterest',
                'url' => 'https://pinterest.com/',
                'color' => '#E60023',
                'open_in_new_tab' => true,
                'is_header' => false,
                'is_footer' => true,
                'status' => true,
                'sort_order' => 9,
            ],
        ];

        foreach ($socialLinks as $socialLink) {
            SocialLink::updateOrCreate(
                [
                    'slug' => $socialLink['slug']
                ],
                $socialLink
            );
        }
    }
}
