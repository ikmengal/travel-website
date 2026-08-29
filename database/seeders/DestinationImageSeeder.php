<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Destination;
use App\Models\DestinationImage;

class DestinationImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $images = [
            'Dubai' => [
                ['image' => 'images/destinations/dubai.jpg', 'title' => 'Burj Khalifa Skyline', 'sort_order' => 1],
                ['image' => 'images/destinations/dubai.jpg', 'title' => 'Desert Safari', 'sort_order' => 2],
                ['image' => 'images/destinations/dubai.jpg', 'title' => 'Luxury Marina Cruises', 'sort_order' => 3],
                ['image' => 'images/destinations/dubai.jpg', 'title' => 'Shopping Malls & Souks', 'sort_order' => 4],
            ],
            'Bali' => [
                ['image' => 'images/destinations/bali.jpg', 'title' => 'Temple of the Gods', 'sort_order' => 1],
                ['image' => 'images/destinations/bali.jpg', 'title' => 'Rice Terraces', 'sort_order' => 2],
                ['image' => 'images/destinations/bali.jpg', 'title' => 'Beach Resort', 'sort_order' => 3],
                ['image' => 'images/destinations/bali.jpg', 'title' => 'Waterfall Adventure', 'sort_order' => 4],
            ],
            'Paris' => [
                ['image' => 'images/destinations/paris.jpg', 'title' => 'Eiffel Tower', 'sort_order' => 1],
                ['image' => 'images/destinations/paris.jpg', 'title' => 'Louvre Museum', 'sort_order' => 2],
                ['image' => 'images/destinations/paris.jpg', 'title' => 'Seine River Cruise', 'sort_order' => 3],
                ['image' => 'images/destinations/paris.jpg', 'title' => 'Champs Elysees', 'sort_order' => 4],
            ],
            'Istanbul' => [
                ['image' => 'images/destinations/istanbul.jpg', 'title' => 'Hagia Sophia', 'sort_order' => 1],
                ['image' => 'images/destinations/istanbul.jpg', 'title' => 'Blue Mosque', 'sort_order' => 2],
                ['image' => 'images/destinations/istanbul.jpg', 'title' => 'Bosphorus Cruise', 'sort_order' => 3],
                ['image' => 'images/destinations/istanbul.jpg', 'title' => 'Grand Bazaar', 'sort_order' => 4],
            ],
            'Bangkok' => [
                ['image' => 'images/destinations/bangkok.jpg', 'title' => 'Floating Market', 'sort_order' => 1],
                ['image' => 'images/destinations/bangkok.jpg', 'title' => 'Grand Palace', 'sort_order' => 2],
                ['image' => 'images/destinations/bangkok.jpg', 'title' => 'Nightlife District', 'sort_order' => 3],
                ['image' => 'images/destinations/bangkok.jpg', 'title' => 'Temple of Dawn', 'sort_order' => 4],
            ],
            'Maldives' => [
                ['image' => 'images/destinations/maldives.jpg', 'title' => 'Overwater Villa', 'sort_order' => 1],
                ['image' => 'images/destinations/maldives.jpg', 'title' => 'Crystal Clear Lagoon', 'sort_order' => 2],
                ['image' => 'images/destinations/maldives.jpg', 'title' => 'Snorkeling Paradise', 'sort_order' => 3],
                ['image' => 'images/destinations/maldives.jpg', 'title' => 'Sunset Cruise', 'sort_order' => 4],
            ],
            'Zurich' => [
                ['image' => 'images/destinations/zurich.jpg', 'title' => 'Lake Zurich', 'sort_order' => 1],
                ['image' => 'images/destinations/zurich.jpg', 'title' => 'Alpine Views', 'sort_order' => 2],
                ['image' => 'images/destinations/zurich.jpg', 'title' => 'Old Town Zurich', 'sort_order' => 3],
                ['image' => 'images/destinations/zurich.jpg', 'title' => 'Snow Mountains', 'sort_order' => 4],
            ],
            'Hunza' => [
                ['image' => 'images/destinations/hunza.jpg', 'title' => 'Attabad Lake', 'sort_order' => 1],
                ['image' => 'images/destinations/hunza.jpg', 'title' => 'Passu Cones', 'sort_order' => 2],
                ['image' => 'images/destinations/hunza.jpg', 'title' => 'Eagle Nest Viewpoint', 'sort_order' => 3],
                ['image' => 'images/destinations/hunza.jpg', 'title' => 'Karimabad Valley', 'sort_order' => 4],
            ],
            'Skardu' => [
                ['image' => 'images/destinations/skardu.jpg', 'title' => 'Shangrila Resort', 'sort_order' => 1],
                ['image' => 'images/destinations/skardu.jpg', 'title' => 'Upper Kachura Lake', 'sort_order' => 2],
                ['image' => 'images/destinations/skardu.jpg', 'title' => 'Satpara Lake', 'sort_order' => 3],
                ['image' => 'images/destinations/skardu.jpg', 'title' => 'Deosai Plains', 'sort_order' => 4],
            ],
            'Kuala Lumpur' => [
                ['image' => 'images/destinations/kuala-lumpur.jpg', 'title' => 'Petronas Twin Towers', 'sort_order' => 1],
                ['image' => 'images/destinations/kuala-lumpur.jpg', 'title' => 'Genting Highlands', 'sort_order' => 2],
                ['image' => 'images/destinations/kuala-lumpur.jpg', 'title' => 'Shopping Paradise', 'sort_order' => 3],
                ['image' => 'images/destinations/kuala-lumpur.jpg', 'title' => 'Street Food Tour', 'sort_order' => 4],
            ],
        ];

        foreach ($images as $destinationName => $destinationImages) {
            $destination = Destination::where('name', $destinationName)->first();
            if (!$destination) {
                continue;
            }

            foreach ($destinationImages as $item) {
                DestinationImage::firstOrCreate(
                    [
                        'destination_id' => $destination->id,
                        'title' => $item['title'],
                    ],
                    [
                        'image' => $item['image'],
                        'sort_order' => $item['sort_order'],
                    ]
                );
            }
        }
    }
}
