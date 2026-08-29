<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Destination;
use Illuminate\Support\Str;
use App\Models\Country;
use App\Models\State;
use App\Models\City;

class DestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $destinations = [
            [
                'country' => 'United Arab Emirates',
                'state' => null,
                'city' => 'Dubai',
                'name' => 'Dubai',
                'tagline' => 'City of Luxury & Innovation',
                'short_description' => 'Experience luxury shopping, iconic skyscrapers, desert adventures and world-class attractions.',
                'description' => 'Dubai is one of the most visited travel destinations in the world. Enjoy luxury hotels, shopping malls, desert safari, Burj Khalifa and unforgettable experiences.',
                'featured_image' => 'dubai.jpg',
                'banner_image' => 'dubai.jpg',
                'starting_price' => 185000,
                'latitude' => 25.2048,
                'longitude' => 55.2708,
                'best_time_to_visit' => 'November - March',
                'is_featured' => true,
                'is_popular' => true,
            ],
            [
                'country' => 'Indonesia',
                'state' => null,
                'city' => 'Denpasar',
                'name' => 'Bali',
                'tagline' => 'Island of Gods',
                'short_description' => 'Beautiful beaches, temples and honeymoon destination.',
                'description' => 'Bali offers breathtaking beaches, waterfalls, rice terraces and luxurious resorts perfect for honeymoon and family vacations.',
                'featured_image' => 'bali.jpg',
                'banner_image' => 'bali.jpg',
                'starting_price' => 165000,
                'latitude' => -8.6705,
                'longitude' => 115.2126,
                'best_time_to_visit' => 'April - October',
                'is_featured' => true,
                'is_popular' => true,
            ],
            [
                'country' => 'Pakistan',
                'state' => null,
                'city' => 'Hunza',
                'name' => 'Hunza',
                'tagline' => 'Heaven on Earth',
                'short_description' => 'Mountains, lakes and breathtaking valleys.',
                'description' => 'Hunza Valley is famous for Attabad Lake, Passu Cones, Eagle Nest and stunning mountain scenery.',
                'featured_image' => 'swiss.jpg',
                'banner_image' => 'swiss.jpg',
                'starting_price' => 35000,
                'latitude' => 36.3167,
                'longitude' => 74.6500,
                'best_time_to_visit' => 'May - October',
                'is_featured' => true,
                'is_popular' => true,
            ],
            [
                'country' => 'Pakistan',
                'state' => null,
                'city' => 'Skardu',
                'name' => 'Skardu',
                'tagline' => 'Land of Mountains',
                'short_description' => 'Gateway to K2 and beautiful lakes.',
                'description' => 'Skardu is home to Shangrila Resort, Upper Kachura Lake, Satpara Lake and Deosai National Park.',
                'featured_image' => 'hero.jpg',
                'banner_image' => 'hero.jpg',
                'starting_price' => 45000,
                'latitude' => 35.2971,
                'longitude' => 75.6333,
                'best_time_to_visit' => 'May - September',
                'is_featured' => true,
                'is_popular' => true,
            ],
            [
                'country' => 'France',
                'state' => null,
                'city' => 'Paris',
                'name' => 'Paris',
                'tagline' => 'City of Love',
                'short_description' => 'Romantic city with iconic landmarks.',
                'description' => 'Visit the Eiffel Tower, Louvre Museum and enjoy unforgettable European holidays.',
                'featured_image' => 'paris.jpg',
                'banner_image' => 'paris.jpg',
                'starting_price' => 285000,
                'latitude' => 48.8566,
                'longitude' => 2.3522,
                'best_time_to_visit' => 'April - June',
                'is_featured' => true,
                'is_popular' => true,
            ],
            [
                'country' => 'Turkey',
                'state' => null,
                'city' => 'Istanbul',
                'name' => 'Istanbul',
                'tagline' => 'Where East Meets West',
                'short_description' => 'Historic mosques and Bosphorus cruises.',
                'description' => 'Istanbul offers rich history, shopping, delicious cuisine and unforgettable architecture.',
                'featured_image' => 'poland.jpg',
                'banner_image' => 'poland.jpg',
                'starting_price' => 155000,
                'latitude' => 41.0082,
                'longitude' => 28.9784,
                'best_time_to_visit' => 'April - May',
                'is_featured' => true,
                'is_popular' => true,
            ],
            [
                'country' => 'Thailand',
                'state' => null,
                'city' => 'Bangkok',
                'name' => 'Bangkok',
                'tagline' => 'City That Never Sleeps',
                'short_description' => 'Street food, nightlife and temples.',
                'description' => 'Bangkok is famous for floating markets, shopping malls and cultural attractions.',
                'featured_image' => 'maldives.jpg',
                'banner_image' => 'maldives.jpg',
                'starting_price' => 145000,
                'latitude' => 13.7563,
                'longitude' => 100.5018,
                'best_time_to_visit' => 'November - February',
                'is_featured' => false,
                'is_popular' => true,
            ],
            [
                'country' => 'Malaysia',
                'state' => null,
                'city' => 'Kuala Lumpur',
                'name' => 'Kuala Lumpur',
                'tagline' => 'Modern Asian Metropolis',
                'short_description' => 'Twin Towers and shopping paradise.',
                'description' => 'Explore Petronas Twin Towers, Genting Highlands and world-class shopping.',
                'featured_image' => '1783384756_featured_U2kUyQ.png',
                'banner_image' => '1783384756_featured_U2kUyQ.png',
                'starting_price' => 135000,
                'latitude' => 3.1390,
                'longitude' => 101.6869,
                'best_time_to_visit' => 'May - July',
                'is_featured' => false,
                'is_popular' => true,
            ],
            [
                'country' => 'Maldives',
                'state' => null,
                'city' => 'Male',
                'name' => 'Maldives',
                'tagline' => 'Tropical Paradise',
                'short_description' => 'Luxury resorts and crystal-clear beaches.',
                'description' => 'The Maldives is one of the world’s top honeymoon and luxury travel destinations.',
                'featured_image' => 'maldives.jpg',
                'banner_image' => 'maldives.jpg',
                'starting_price' => 325000,
                'latitude' => 4.1755,
                'longitude' => 73.5093,
                'best_time_to_visit' => 'November - April',
                'is_featured' => true,
                'is_popular' => true,
            ],
            [
                'country' => 'Switzerland',
                'state' => null,
                'city' => 'Zurich',
                'name' => 'Zurich',
                'tagline' => 'Swiss Beauty',
                'short_description' => 'Lakes, mountains and luxury experiences.',
                'description' => 'Zurich is famous for scenic beauty, snow-covered mountains and premium European holidays.',
                'featured_image' => 'swiss.jpg',
                'banner_image' => 'swiss.jpg',
                'starting_price' => 310000,
                'latitude' => 47.3769,
                'longitude' => 8.5417,
                'best_time_to_visit' => 'June - September',
                'is_featured' => true,
                'is_popular' => false,
            ],
        ];

        foreach ($destinations as $index => $item) {
            $country = Country::where('name', $item['country'])->first();
            $state = $item['state']
                ? State::where('name', $item['state'])->first()
                : null;
            $city = City::where('name', $item['city'])->first();
            Destination::updateOrCreate(
                ['slug' => Str::slug($item['name'])],
                [
                    'country_id' => $country?->id,
                    'state_id' => $state?->id,
                    'city_id' => $city?->id,

                    'name' => $item['name'],
                    'slug' => Str::slug($item['name']),
                    'tagline' => $item['tagline'],
                    'short_description' => $item['short_description'],
                    'description' => $item['description'],
                    'featured_image' => $item['featured_image'],
                    'banner_image' => $item['banner_image'],
                    'starting_price' => $item['starting_price'],
                    'latitude' => $item['latitude'],
                    'longitude' => $item['longitude'],
                    'best_time_to_visit' => $item['best_time_to_visit'],
                    'is_featured' => $item['is_featured'],
                    'is_popular' => $item['is_popular'],
                    'sort_order' => $index + 1,
                    'status' => true,
                    'meta_title' => $item['name'].' Tour Packages',
                    'meta_description' => 'Book affordable '.$item['name'].' holiday packages with flights, hotels and tours.',
                ]
            );
        }
    }
}
