<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TourCategory;
use Illuminate\Support\Str;

class TourCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Adventure', 'icon' => 'ti ti-mountain', 'color' => '#dc2626', 'sort_order' => 1],
            ['name' => 'Luxury', 'icon' => 'ti ti-crown', 'color' => '#d4af37', 'sort_order' => 2],
            ['name' => 'Honeymoon', 'icon' => 'ti ti-heart', 'color' => '#ec4899', 'sort_order' => 3],
            ['name' => 'Family', 'icon' => 'ti ti-users', 'color' => '#3b82f6', 'sort_order' => 4],
            ['name' => 'Beach', 'icon' => 'ti ti-umbrella', 'color' => '#06b6d4', 'sort_order' => 5],
            ['name' => 'Cultural', 'icon' => 'ti ti-building', 'color' => '#f59e0b', 'sort_order' => 6],
            ['name' => 'Group Tours', 'icon' => 'ti ti-road', 'color' => '#8b5cf6', 'sort_order' => 7],
        ];

        foreach ($categories as $index => $item) {
            TourCategory::updateOrCreate(
                ['slug' => Str::slug($item['name'])],
                [
                    'name' => $item['name'],
                    'slug' => Str::slug($item['name']),
                    'icon' => $item['icon'],
                    'color' => $item['color'],
                    'sort_order' => $item['sort_order'],
                    'status' => true,
                ]
            );
        }
    }
}
