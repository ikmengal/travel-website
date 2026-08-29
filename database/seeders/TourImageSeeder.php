<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tour;
use App\Models\TourImage;

class TourImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tourImages = [
            'Dubai Desert Safari & City Highlights' => [
                ['image' => 'images/destinations/dubai.jpg', 'title' => 'Burj Khalifa', 'caption' => 'Iconic skyline of Dubai'],
                ['image' => 'images/destinations/dubai.jpg', 'title' => 'Desert Safari', 'caption' => 'Dune bashing adventure'],
                ['image' => 'images/destinations/dubai.jpg', 'title' => 'Dubai Mall', 'caption' => 'World-class shopping'],
                ['image' => 'images/destinations/dubai.jpg', 'title' => 'Marina Cruise', 'caption' => 'Evening Dhow cruise'],
            ],
            'Bali Honeymoon Special' => [
                ['image' => 'images/destinations/bali.jpg', 'title' => 'Private Villa', 'caption' => 'Luxury pool villa'],
                ['image' => 'images/destinations/bali.jpg', 'title' => 'Temples', 'caption' => 'Sacred island temples'],
                ['image' => 'images/destinations/bali.jpg', 'title' => 'Beach', 'caption' => 'White sand beaches'],
                ['image' => 'images/destinations/bali.jpg', 'title' => 'Rice Terraces', 'caption' => 'Ubud rice terraces'],
            ],
            'Paris Luxury & Romance Tour' => [
                ['image' => 'images/destinations/paris.jpg', 'title' => 'Eiffel Tower', 'caption' => 'The city of love icon'],
                ['image' => 'images/destinations/paris.jpg', 'title' => 'Louvre Museum', 'caption' => 'World-famous art museum'],
                ['image' => 'images/destinations/paris.jpg', 'title' => 'Seine Cruise', 'caption' => 'Romantic river cruise'],
                ['image' => 'images/destinations/paris.jpg', 'title' => 'Champs Elysees', 'caption' => 'Famous avenue'],
            ],
            'Istanbul Heritage & Bosphorus Tour' => [
                ['image' => 'images/destinations/istanbul.jpg', 'title' => 'Hagia Sophia', 'caption' => 'Historic mosque'],
                ['image' => 'images/destinations/istanbul.jpg', 'title' => 'Bosphorus', 'caption' => 'Strait cruise'],
                ['image' => 'images/destinations/istanbul.jpg', 'title' => 'Grand Bazaar', 'caption' => 'Historic marketplace'],
                ['image' => 'images/destinations/istanbul.jpg', 'title' => 'Blue Mosque', 'caption' => 'Iconic architecture'],
            ],
            'Bangkok Adventure Group Tour' => [
                ['image' => 'images/destinations/bangkok.jpg', 'title' => 'Grand Palace', 'caption' => 'Royal complex'],
                ['image' => 'images/destinations/bangkok.jpg', 'title' => 'Floating Market', 'caption' => 'Local water market'],
                ['image' => 'images/destinations/bangkok.jpg', 'title' => 'Street Food', 'caption' => 'Famous night market'],
                ['image' => 'images/destinations/bangkok.jpg', 'title' => 'Temples', 'caption' => 'Golden temples'],
            ],
            'Maldives Beach Paradise' => [
                ['image' => 'images/destinations/maldives.jpg', 'title' => 'Overwater Villa', 'caption' => 'Luxury villa stay'],
                ['image' => 'images/destinations/maldives.jpg', 'title' => 'Lagoon', 'caption' => 'Crystal clear waters'],
                ['image' => 'images/destinations/maldives.jpg', 'title' => 'Snorkeling', 'caption' => 'Underwater adventure'],
                ['image' => 'images/destinations/maldives.jpg', 'title' => 'Sunset', 'caption' => 'Breathtaking sunset'],
            ],
            'Zurich Swiss Alps Escape' => [
                ['image' => 'images/destinations/zurich.jpg', 'title' => 'Lake Zurich', 'caption' => 'Scenic lakeside city'],
                ['image' => 'images/destinations/zurich.jpg', 'title' => 'Alps', 'caption' => 'Snow mountains'],
                ['image' => 'images/destinations/zurich.jpg', 'title' => 'Train Journey', 'caption' => 'Scenic rail route'],
                ['image' => 'images/destinations/zurich.jpg', 'title' => 'Old Town', 'caption' => 'Historic streets'],
            ],
            'Hunza Valley Adventure Tour' => [
                ['image' => 'images/destinations/hunza.jpg', 'title' => 'Attabad Lake', 'caption' => 'Turquoise lake'],
                ['image' => 'images/destinations/hunza.jpg', 'title' => 'Passu Cones', 'caption' => 'Iconic peaks'],
                ['image' => 'images/destinations/hunza.jpg', 'title' => 'Eagle Nest', 'caption' => 'Panoramic viewpoint'],
                ['image' => 'images/destinations/hunza.jpg', 'title' => 'Valley', 'caption' => 'Breathtaking scenery'],
            ],
            'Skardu Lakes & Mountains Tour' => [
                ['image' => 'images/destinations/skardu.jpg', 'title' => 'Shangrila Resort', 'caption' => 'Scenic resort'],
                ['image' => 'images/destinations/skardu.jpg', 'title' => 'Kachura Lake', 'caption' => 'Serene lake views'],
                ['image' => 'images/destinations/skardu.jpg', 'title' => 'Satpara Lake', 'caption' => 'Mountain lake'],
                ['image' => 'images/destinations/skardu.jpg', 'title' => 'Deosai', 'caption' => 'Vast plains'],
            ],
            'Kuala Lumpur Family Fun Tour' => [
                ['image' => 'images/destinations/kuala-lumpur.jpg', 'title' => 'Twin Towers', 'caption' => 'Petronas Towers'],
                ['image' => 'images/destinations/kuala-lumpur.jpg', 'title' => 'Genting Highlands', 'caption' => 'Theme park adventure'],
                ['image' => 'images/destinations/kuala-lumpur.jpg', 'title' => 'Shopping', 'caption' => 'Modern malls'],
                ['image' => 'images/destinations/kuala-lumpur.jpg', 'title' => 'Street Food', 'caption' => 'Local delights'],
            ],
        ];

        foreach ($tourImages as $tourTitle => $images) {
            $tour = Tour::where('title', $tourTitle)->first();
            if (!$tour) {
                continue;
            }

            foreach ($images as $index => $item) {
                TourImage::firstOrCreate(
                    [
                        'tour_id' => $tour->id,
                        'title' => $item['title'],
                    ],
                    [
                        'image' => $item['image'],
                        'caption' => $item['caption'],
                        'feature' => $index === 0,
                        'status' => true,
                        'sort_order' => $index + 1,
                    ]
                );
            }
        }
    }
}
