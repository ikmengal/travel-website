<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Testimonial;
use App\Models\Country;
use App\Models\City;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'country' => 'United States',
                'city' => 'New York',
                'name' => 'Sarah Johnson',
                'designation' => 'Marketing Manager',
                'company' => 'Brightline Media',
                'rating' => 5,
                'review' => 'Our trip to the Maldives was absolutely magical. Every detail was handled seamlessly and we never had to worry about a thing.',
                'featured' => true,
            ],
            [
                'country' => 'Canada',
                'city' => 'Toronto',
                'name' => 'Michael Chen',
                'designation' => 'Software Engineer',
                'company' => 'TechNova',
                'rating' => 5,
                'review' => 'The Bali honeymoon package exceeded all our expectations. Beautiful resorts, smooth transfers and amazing value for money.',
                'featured' => true,
            ],
            [
                'country' => 'United Kingdom',
                'city' => 'London',
                'name' => 'Emma Williams',
                'designation' => 'Travel Blogger',
                'company' => 'Wanderlust Diaries',
                'rating' => 4,
                'review' => 'Booking was incredibly easy and the customer support team was always available. A truly stress-free travel experience.',
                'featured' => true,
            ],
            [
                'country' => 'Australia',
                'city' => 'Sydney',
                'name' => 'Sophie Moore',
                'designation' => 'Accountant',
                'company' => 'Moore & Co',
                'rating' => 5,
                'review' => 'We explored the stunning Hunza Valley and it was a once in a lifetime experience. Highly recommend their guided tours.',
                'featured' => true,
            ],
            [
                'country' => 'Canada',
                'city' => 'Vancouver',
                'name' => 'David Miller',
                'designation' => 'Business Owner',
                'company' => 'Miller Industries',
                'rating' => 4,
                'review' => 'From visas to hotels and everything in between, they took care of the entire journey. Great attention to detail throughout.',
                'featured' => true,
            ],
            [
                'country' => 'Pakistan',
                'city' => 'Karachi',
                'name' => 'Ayesha Khan',
                'designation' => 'Doctor',
                'company' => 'City Care Hospital',
                'rating' => 5,
                'review' => 'A fantastic family vacation to Istanbul. Transparent pricing and excellent coordination made our holiday truly memorable.',
                'featured' => true,
            ],
        ];

        foreach ($testimonials as $index => $item) {
            $countryId = Country::where('name', $item['country'])->value('id');
            $cityId = City::where('name', $item['city'])->value('id');

            Testimonial::updateOrCreate(
                ['name' => $item['name']],
                [
                    'country_id' => $countryId,
                    'state_id' => null,
                    'city_id' => $cityId,
                    'name' => $item['name'],
                    'designation' => $item['designation'],
                    'company' => $item['company'],
                    'image' => '',
                    'rating' => $item['rating'],
                    'review' => $item['review'],
                    'featured' => $item['featured'],
                    'status' => true,
                    'sort_order' => $index + 1,
                    'meta_title' => $item['name'].' Travel Testimonial',
                    'meta_description' => 'Read the travel experience of '.$item['name'].' with TravelBook.',
                ]
            );
        }
    }
}
