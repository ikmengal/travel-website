<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tour;
use App\Models\TourItinerary;

class TourItinerarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $itineraries = [
            'Dubai Desert Safari & City Highlights' => [
                ['day' => 1, 'title' => 'Arrival & Welcome', 'description' => 'Arrive in Dubai and check in to your hotel. Enjoy a relaxing evening at leisure.'],
                ['day' => 2, 'title' => 'City Highlights Tour', 'description' => 'Visit the Burj Khalifa, Dubai Mall, and the historic Al Fahidi district.'],
                ['day' => 3, 'title' => 'Desert Safari Adventure', 'description' => 'Enjoy dune bashing, camel riding, and a BBQ dinner under the stars.'],
                ['day' => 4, 'title' => 'Marina & Souk Day', 'description' => 'Explore the Dubai Marina and shop at the traditional souks.'],
                ['day' => 5, 'title' => 'Departure', 'description' => 'Enjoy a final breakfast and transfer to the airport for departure.'],
            ],
            'Bali Honeymoon Special' => [
                ['day' => 1, 'title' => 'Arrival in Bali', 'description' => 'Arrive at Ngurah Rai Airport, meet your driver, and check in to your private villa.'],
                ['day' => 2, 'title' => 'Temples & Rice Terraces', 'description' => 'Visit Uluwatu Temple and the beautiful Ubud rice terraces.'],
                ['day' => 3, 'title' => 'Beach & Spa Day', 'description' => 'Relax on the beaches of Nusa Dua and enjoy a couple spa treatment.'],
                ['day' => 4, 'title' => 'Romantic Sunset Dinner', 'description' => 'Enjoy a private romantic beachfront dinner at sunset.'],
                ['day' => 5, 'title' => 'Waterfall Adventure', 'description' => 'Discover the hidden waterfalls of Bali with a guided trek.'],
                ['day' => 6, 'title' => 'Departure', 'description' => 'Transfer to the airport for your flight back home.'],
            ],
            'Paris Luxury & Romance Tour' => [
                ['day' => 1, 'title' => 'Arrival & Eiffel Tower', 'description' => 'Arrive in Paris and visit the Eiffel Tower for stunning city views.'],
                ['day' => 2, 'title' => 'Louvre Museum', 'description' => 'Explore the world-famous Louvre Museum with a guided tour.'],
                ['day' => 3, 'title' => 'Seine River Cruise', 'description' => 'Enjoy a relaxing cruise along the Seine with dinner.'],
                ['day' => 4, 'title' => 'Versailles Palace', 'description' => 'Take a day trip to the magnificent Palace of Versailles.'],
                ['day' => 5, 'title' => 'Champs Elysees & Shopping', 'description' => 'Stroll the Champs Elysees and enjoy luxury shopping.'],
                ['day' => 6, 'title' => 'Montmartre & Culture', 'description' => 'Explore the artistic Montmartre district and Sacre-Coeur.'],
                ['day' => 7, 'title' => 'Departure', 'description' => 'Enjoy a farewell breakfast and transfer to the airport.'],
            ],
            'Istanbul Heritage & Bosphorus Tour' => [
                ['day' => 1, 'title' => 'Arrival in Istanbul', 'description' => 'Arrive and check in to your hotel in the heart of Istanbul.'],
                ['day' => 2, 'title' => 'Hagia Sophia & Blue Mosque', 'description' => 'Discover the iconic Hagia Sophia and Blue Mosque.'],
                ['day' => 3, 'title' => 'Topkapi Palace', 'description' => 'Explore the historic Topkapi Palace and its treasures.'],
                ['day' => 4, 'title' => 'Bosphorus Cruise', 'description' => 'Enjoy a relaxing cruise along the Bosphorus Strait.'],
                ['day' => 5, 'title' => 'Grand Bazaar & Departure', 'description' => 'Shop at the Grand Bazaar before departing.'],
            ],
            'Bangkok Adventure Group Tour' => [
                ['day' => 1, 'title' => 'Arrival & Night Market', 'description' => 'Arrive in Bangkok and explore the vibrant night markets.'],
                ['day' => 2, 'title' => 'Grand Palace & Temples', 'description' => 'Visit the Grand Palace and the beautiful golden temples.'],
                ['day' => 3, 'title' => 'Floating Market', 'description' => 'Take a boat trip to the famous floating markets.'],
                ['day' => 4, 'title' => 'Street Food & Departure', 'description' => 'Sample Bangkok street food before transferring to the airport.'],
            ],
            'Maldives Beach Paradise' => [
                ['day' => 1, 'title' => 'Arrival & Seaplane', 'description' => 'Arrive and take a scenic seaplane to your resort.'],
                ['day' => 2, 'title' => 'Beach & Lagoon Relaxation', 'description' => 'Relax on white-sand beaches and swim in the crystal-clear lagoon.'],
                ['day' => 3, 'title' => 'Snorkeling Adventure', 'description' => 'Explore the vibrant coral reefs while snorkeling.'],
                ['day' => 4, 'title' => 'Sunset Cruise', 'description' => 'Enjoy a romantic sunset dolphin cruise.'],
                ['day' => 5, 'title' => 'Spa & Leisure', 'description' => 'Indulge in a relaxing spa treatment and leisure time.'],
                ['day' => 6, 'title' => 'Departure', 'description' => 'Transfer back to the airport for your flight home.'],
            ],
            'Zurich Swiss Alps Escape' => [
                ['day' => 1, 'title' => 'Arrival in Zurich', 'description' => 'Arrive in Zurich and enjoy a leisurely evening by the lake.'],
                ['day' => 2, 'title' => 'Zurich City Tour', 'description' => 'Explore Zurich\'s old town and the scenic lakeside promenade.'],
                ['day' => 3, 'title' => 'Alpine Train Journey', 'description' => 'Take a breathtaking scenic train ride into the Swiss Alps.'],
                ['day' => 4, 'title' => 'Mountains & Snow', 'description' => 'Enjoy spectacular Alpine views and snow activities.'],
                ['day' => 5, 'title' => 'Lucerne Day Trip', 'description' => 'Visit the charming lakeside city of Lucerne.'],
                ['day' => 6, 'title' => 'Leisure & Shopping', 'description' => 'Enjoy free time for shopping and leisure in Zurich.'],
                ['day' => 7, 'title' => 'Departure', 'description' => 'Transfer to the airport for your journey home.'],
            ],
            'Hunza Valley Adventure Tour' => [
                ['day' => 1, 'title' => 'Arrival & Travel to Hunza', 'description' => 'Arrive and travel to the beautiful Hunza Valley.'],
                ['day' => 2, 'title' => 'Karimabad & Baltit Fort', 'description' => 'Explore Karimabad bazaar and the historic Baltit Fort.'],
                ['day' => 3, 'title' => 'Attabad Lake & Passu', 'description' => 'Visit the turquoise Attabad Lake and the iconic Passu Cones.'],
                ['day' => 4, 'title' => 'Eagle Nest Viewpoint', 'description' => 'Enjoy panoramic views from Eagle Nest viewpoint.'],
                ['day' => 5, 'title' => 'Hussaini & Gulmit', 'description' => 'Explore Hussaini suspension bridge and the scenic Gulmit village.'],
                ['day' => 6, 'title' => 'Departure', 'description' => 'Travel back with lasting memories of Hunza.'],
            ],
            'Skardu Lakes & Mountains Tour' => [
                ['day' => 1, 'title' => 'Arrival in Skardu', 'description' => 'Arrive and check in at the scenic Shangrila Resort.'],
                ['day' => 2, 'title' => 'Kachura Lakes', 'description' => 'Visit the beautiful Upper and Lower Kachura Lakes.'],
                ['day' => 3, 'title' => 'Satpara Lake', 'description' => 'Explore the serene Satpara Lake and its surroundings.'],
                ['day' => 4, 'title' => 'Deosai National Park', 'description' => 'Take a day trip to the vast Deosai National Park plains.'],
                ['day' => 5, 'title' => 'Blind Lake & Culture', 'description' => 'Visit Blind Lake and experience local Skardu culture.'],
                ['day' => 6, 'title' => 'Leisure & Shopping', 'description' => 'Enjoy free time and shop for local handicrafts.'],
                ['day' => 7, 'title' => 'Departure', 'description' => 'Depart with unforgettable mountain memories.'],
            ],
            'Kuala Lumpur Family Fun Tour' => [
                ['day' => 1, 'title' => 'Arrival in KL', 'description' => 'Arrive in Kuala Lumpur and check in to your hotel.'],
                ['day' => 2, 'title' => 'Petronas Towers', 'description' => 'Visit the iconic Petronas Twin Towers and KLCC Park.'],
                ['day' => 3, 'title' => 'Genting Highlands', 'description' => 'Enjoy the theme parks and cool mountain air at Genting Highlands.'],
                ['day' => 4, 'title' => 'Batu Caves & Shopping', 'description' => 'Visit the Batu Caves and shop at vibrant markets.'],
                ['day' => 5, 'title' => 'Departure', 'description' => 'Enjoy a final meal and transfer to the airport.'],
            ],
        ];

        foreach ($itineraries as $tourTitle => $days) {
            $tour = Tour::where('title', $tourTitle)->first();
            if (!$tour) {
                continue;
            }

            foreach ($days as $item) {
                TourItinerary::firstOrCreate(
                    [
                        'tour_id' => $tour->id,
                        'day' => $item['day'],
                    ],
                    [
                        'title' => $item['title'],
                        'description' => $item['description'],
                        'status' => true,
                    ]
                );
            }
        }
    }
}
