<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BlogCategory;
use Illuminate\Support\Str;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Travel Tips',
                'description' => 'Practical advice and useful tips to help you travel smarter, cheaper and more comfortably.',
            ],
            [
                'name' => 'Destination Guides',
                'description' => 'In-depth guides covering the best attractions, food, culture and experiences across global destinations.',
            ],
            [
                'name' => 'News & Updates',
                'description' => 'The latest travel news, policy updates and announcements from around the world.',
            ],
            [
                'name' => 'Food & Culture',
                'description' => 'Explore the rich cuisines, traditions and cultural highlights of destinations around the world.',
            ],
        ];

        foreach ($categories as $index => $item) {
            BlogCategory::updateOrCreate(
                ['slug' => Str::slug($item['name'])],
                [
                    'name' => $item['name'],
                    'slug' => Str::slug($item['name']),
                    'description' => $item['description'],
                    'status' => true,
                    'sort_order' => $index + 1,
                    'meta_title' => $item['name'].' | TravelBook Blog',
                    'meta_description' => $item['description'],
                ]
            );
        }
    }
}
