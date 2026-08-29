<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tour;
use App\Models\TourExclude;

class TourExcludeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $excludes = [
            ['title' => 'Visa Fees', 'icon' => 'ti ti-file-stamp'],
            ['title' => 'Travel Insurance', 'icon' => 'ti ti-shield-check'],
            ['title' => 'Personal Expenses', 'icon' => 'ti ti-wallet'],
        ];

        $tours = Tour::all();

        foreach ($tours as $tour) {
            foreach ($excludes as $index => $item) {
                TourExclude::firstOrCreate(
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
