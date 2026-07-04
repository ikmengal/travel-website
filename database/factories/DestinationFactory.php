<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Destination;
use Illuminate\Support\Str;
use App\Models\Country;
use App\Models\State;
use App\Models\City;

/**
 * @extends Factory<Destination>
 */
class DestinationFactory extends Factory
{
    protected $model = Destination::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
public function definition(): array
    {
        $destinations = [
            [
                'name' => 'Dubai',
                'tagline' => 'City of Luxury & Innovation',
                'country' => 'United Arab Emirates',
                'city' => 'Dubai',
                'featured_image' => 'images/destinations/dubai.jpg',
                'banner_image' => 'images/destinations/dubai-banner.jpg',
                'starting_price' => 185000,
                'latitude' => 25.204849,
                'longitude' => 55.270783,
                'best_time_to_visit' => 'November to March',
            ],
            [
                'name' => 'Bali',
                'tagline' => 'Island of Gods',
                'country' => 'Indonesia',
                'city' => 'Denpasar',
                'featured_image' => 'images/destinations/bali.jpg',
                'banner_image' => 'images/destinations/bali-banner.jpg',
                'starting_price' => 165000,
                'latitude' => -8.670458,
                'longitude' => 115.212631,
                'best_time_to_visit' => 'April to October',
            ],
            [
                'name' => 'Hunza',
                'tagline' => 'Heaven on Earth',
                'country' => 'Pakistan',
                'city' => 'Hunza',
                'featured_image' => 'images/destinations/hunza.jpg',
                'banner_image' => 'images/destinations/hunza-banner.jpg',
                'starting_price' => 35000,
                'latitude' => 36.316667,
                'longitude' => 74.650000,
                'best_time_to_visit' => 'May to October',
            ],
            [
                'name' => 'Paris',
                'tagline' => 'City of Love',
                'country' => 'France',
                'city' => 'Paris',
                'featured_image' => 'images/destinations/paris.jpg',
                'banner_image' => 'images/destinations/paris-banner.jpg',
                'starting_price' => 285000,
                'latitude' => 48.856613,
                'longitude' => 2.352222,
                'best_time_to_visit' => 'April to June',
            ],
            [
                'name' => 'Istanbul',
                'tagline' => 'Where East Meets West',
                'country' => 'Turkey',
                'city' => 'Istanbul',
                'featured_image' => 'images/destinations/istanbul.jpg',
                'banner_image' => 'images/destinations/istanbul-banner.jpg',
                'starting_price' => 155000,
                'latitude' => 41.008240,
                'longitude' => 28.978359,
                'best_time_to_visit' => 'April to May',
            ],
        ];

        $destination = fake()->randomElement($destinations);
        $country = Country::where('name', $destination['country'])->first();
        $city = City::where('name', $destination['city'])->first();
        $state = $city?->state;

        return [
            'country_id' => $country?->id,
            'state_id' => $state?->id,
            'city_id' => $city?->id,
            'name' => $destination['name'],
            'slug' => Str::slug($destination['name']),
            'tagline' => $destination['tagline'],
            'short_description' => fake()->paragraph(),
            'description' => fake()->paragraphs(5, true),
            'featured_image' => $destination['featured_image'],
            'banner_image' => $destination['banner_image'],
            'starting_price' => $destination['starting_price'],
            'latitude' => $destination['latitude'],
            'longitude' => $destination['longitude'],
            'best_time_to_visit' => $destination['best_time_to_visit'],
            'is_featured' => fake()->boolean(70),
            'is_popular' => fake()->boolean(80),
            'sort_order' => fake()->numberBetween(1, 100),
            'status' => true,
            'meta_title' => $destination['name'].' Travel Packages',
            'meta_description' => 'Book best tour packages for '.$destination['name'].' at affordable prices.',
        ];
    }

    public function featured()
    {
        return $this->state(fn () => [
            'is_featured' => true,
        ]);
    }

    public function popular()
    {
        return $this->state(fn () => [
            'is_popular' => true,
        ]);
    }

    public function inactive()
    {
        return $this->state(fn () => [
            'status' => false,
        ]);
    }
}
