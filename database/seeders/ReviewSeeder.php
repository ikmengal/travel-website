<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\User;
use App\Models\Tour;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::whereHas('roles', fn ($q) => $q->where('name', 'Customer'))
            ->take(6)
            ->get();

        $tours = Tour::where('featured', true)
            ->take(6)
            ->get();

        if ($users->isEmpty() || $tours->isEmpty()) {
            return;
        }

        $reviews = [
            [
                'rating' => 5,
                'title' => 'Unforgettable honeymoon experience!',
                'review' => 'This tour exceeded all our expectations. The itinerary was perfect, hotels were luxurious and every transfer was smooth and on time.',
                'pros' => 'Excellent hotels, great itinerary, professional guides.',
                'cons' => 'None, everything was flawless.',
            ],
            [
                'rating' => 5,
                'title' => 'Best travel value for money',
                'review' => 'The entire booking process was effortless and the package was extremely well organized. Highly recommended for any traveler.',
                'pros' => 'Great value, friendly staff, well planned activities.',
                'cons' => 'Wish the trip was longer!',
            ],
            [
                'rating' => 4,
                'title' => 'Amazing adventure, highly memorable',
                'review' => 'Beautiful destinations and fantastic local experiences. The support team was responsive and helpful throughout our journey.',
                'pros' => 'Breathtaking scenery, smooth coordination, delicious food.',
                'cons' => 'Some transfers were a little late.',
            ],
            [
                'rating' => 5,
                'title' => 'Seamless booking and flawless trip',
                'review' => 'From visa assistance to airport transfers, everything was arranged perfectly. We traveled stress-free and made wonderful memories.',
                'pros' => 'Attention to detail, great accommodations, reliable service.',
                'cons' => 'No complaints at all.',
            ],
            [
                'rating' => 5,
                'title' => 'A trip of a lifetime',
                'review' => 'The itinerary was carefully curated with just the right balance of sightseeing and relaxation. Our family loved every single day.',
                'pros' => 'Family friendly, superb guides, beautiful locations.',
                'cons' => 'Could use a couple more free days.',
            ],
            [
                'rating' => 4,
                'title' => 'Well organized and great support',
                'review' => 'Everything went according to plan and the team kept us informed at every step. A very reliable way to book your dream vacation.',
                'pros' => 'Clear communication, comfortable transport, excellent hotels.',
                'cons' => 'Slightly higher than budget options.',
            ],
        ];

        foreach ($reviews as $index => $item) {
            $user = $users->get($index % $users->count());
            $tour = $tours->get($index % $tours->count());

            Review::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'reviewable_type' => 'App\Models\Tour',
                    'reviewable_id' => $tour->id,
                ],
                [
                    'booking_id' => null,
                    'reviewable_type' => 'App\Models\Tour',
                    'reviewable_id' => $tour->id,
                    'rating' => $item['rating'],
                    'title' => $item['title'],
                    'review' => $item['review'],
                    'pros' => $item['pros'],
                    'cons' => $item['cons'],
                    'is_verified' => true,
                    'is_featured' => true,
                    'status' => true,
                    'approved_at' => now(),
                ]
            );
        }
    }
}
