<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Counter;

class CounterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $counters = [
            [
                'icon' => 'ti ti-users',
                'title' => 'Happy Travelers',
                'number' => 50,
                'prefix' => '',
                'suffix' => 'K+',
                'description' => 'Satisfied customers who trusted us to plan their perfect escape.',
                'sort_order' => 1,
                'status' => true,
            ],
            [
                'icon' => 'ti ti-map-2',
                'title' => 'Destinations',
                'number' => 500,
                'prefix' => '',
                'suffix' => '',
                'description' => 'Worldwide destinations covered across tours, hotels and flights.',
                'sort_order' => 2,
                'status' => true,
            ],
            [
                'icon' => 'ti ti-trophy',
                'title' => 'Awards Won',
                'number' => 125,
                'prefix' => '',
                'suffix' => '',
                'description' => 'Industry recognitions for outstanding travel and hospitality service.',
                'sort_order' => 3,
                'status' => true,
            ],
            [
                'icon' => 'ti ti-calendar',
                'title' => 'Years Experience',
                'number' => 15,
                'prefix' => '',
                'suffix' => '',
                'description' => 'A decade and a half of crafting seamless travel journeys.',
                'sort_order' => 4,
                'status' => true,
            ],
        ];

        foreach ($counters as $counter) {
            Counter::updateOrCreate(
                [
                    'title' => $counter['title'],
                    'sort_order' => $counter['sort_order'],
                ],
                $counter
            );
        }
    }
}
