<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tour;
use App\Models\TourInclude;

class TourIncludeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $includes = [
            ['title' => 'Hotel Stay', 'icon' => 'ti ti-bed'],
            ['title' => 'Flights', 'icon' => 'ti ti-plane'],
            ['title' => 'Breakfast', 'icon' => 'ti ti-coffee'],
            ['title' => 'Transport', 'icon' => 'ti ti-car'],
            ['title' => 'Tour Guide', 'icon' => 'ti ti-user-check'],
        ];

        $tours = Tour::all();

        foreach ($tours as $tour) {
            foreach ($includes as $index => $item) {
                TourInclude::firstOrCreate(
                    [
                        'tour_id' => $tour->id,
                        'title' => $item['title'],
                    ],
                    [
                        'icon' => $item['icon'],
                        'sort_order' => $index + 1,
                        'status' => true,
                    ]
                );
            }
        }
    }
}
