<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tour;
use App\Models\TourDeparture;
use Illuminate\Support\Carbon;

class TourDepartureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tours = Tour::all();

        foreach ($tours as $tour) {
            $durationDays = (int) $tour->duration_days ?: 5;

            $offsets = [
                ['startDays' => 20, 'seats' => 25],
                ['startDays' => 45, 'seats' => 18],
                ['startDays' => 80, 'seats' => 30],
            ];

            foreach ($offsets as $offset) {
                $departureDate = now()->addDays($offset['startDays'])->startOfDay();
                $returnDate = $departureDate->copy()->addDays(max($durationDays - 1, 1));

                TourDeparture::firstOrCreate(
                    [
                        'tour_id' => $tour->id,
                        'departure_date' => $departureDate->format('Y-m-d'),
                    ],
                    [
                        'return_date' => $returnDate->format('Y-m-d'),
                        'available_seats' => $offset['seats'],
                        'price' => $tour->discount_price ?: $tour->price,
                        'status' => true,
                    ]
                );
            }
        }
    }
}
