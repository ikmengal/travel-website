<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $blogs = [
            [
                'category' => 'Destination Guides',
                'title' => 'Top 10 Beaches in Bali',
                'category_slug' => 'destination-guides',
                'featured_image' => 'images/destinations/bali.jpg',
                'short_description' => 'Discover the most breathtaking beaches on the Island of the Gods, from hidden coves to lively surfer hotspots.',
                'description' => '<p>Bali is world-famous for its stunning coastlines, and choosing the perfect beach can make or break your tropical escape. From the golden sands of Kuta to the serene waters of Nusa Dua, this guide highlights the ten beaches every traveler should visit.</p><p>Whether you are seeking world-class surf, quiet sunset spots or family-friendly shorelines, Bali has something for everyone. We have handpicked these beaches based on scenery, accessibility and local charm.</p><p>Plan your route, pack your sunscreen and get ready to experience some of the most beautiful beaches in Southeast Asia on your next holiday.</p>',
                'author' => 'TravelBook Editorial',
                'days_ago' => 12,
                'views' => 1240,
            ],
            [
                'category' => 'Travel Tips',
                'title' => 'Budget Travel Guide to Istanbul',
                'category_slug' => 'travel-tips',
                'featured_image' => 'images/destinations/istanbul.jpg',
                'short_description' => 'Explore the historic heart of Turkey without breaking the bank with our smart money-saving strategies.',
                'description' => '<p>Istanbul is a city where East meets West, offering incredible history, vibrant markets and unforgettable food. The good news is that you can experience it all on a budget with a little planning.</p><p>This guide covers affordable accommodation, cheap street food, free attractions and the best times to visit to keep your costs low while maximizing your experience.</p><p>Follow our tips and you will enjoy a rich, memorable Istanbul adventure without overspending on your dream trip.</p>',
                'author' => 'TravelBook Editorial',
                'days_ago' => 18,
                'views' => 980,
            ],
            [
                'category' => 'Destination Guides',
                'title' => 'Best Time to Visit the Maldives',
                'category_slug' => 'destination-guides',
                'featured_image' => 'images/destinations/maldives.jpg',
                'short_description' => 'Learn the perfect season for crystal-clear skies, calm seas and the best deals in this tropical paradise.',
                'description' => '<p>The Maldives is the ultimate tropical getaway, with shimmering turquoise lagoons and overwater villas. But choosing the right time to visit makes all the difference to your experience and budget.</p><p>We break down the dry and wet seasons, temperature trends, monsoon patterns and the best months for scuba diving, snorkeling and romantic stays.</p><p>With our guidance you can plan the perfect Maldives escape at a time that matches your preferences and your wallet.</p>',
                'author' => 'TravelBook Editorial',
                'days_ago' => 25,
                'views' => 1560,
            ],
            [
                'category' => 'Destination Guides',
                'title' => 'Hunza Valley Travel Guide',
                'category_slug' => 'destination-guides',
                'featured_image' => 'images/destinations/hunza.jpg',
                'short_description' => 'Journey through the majestic mountains, ancient forts and turquoise lakes of Pakistan\'s crown jewel.',
                'description' => '<p>Hunza Valley is a breathtaking region nestled in the Karakoram mountain range, famous for its towering peaks, charming villages and crystal-clear lakes like Attabad.</p><p>From the iconic Passu Cones to the historical Baltit Fort and spectacular views at Eagle Nest, this guide takes you through the must-see highlights and local culture.</p><p>Discover the best travel seasons, how to reach the valley, and the unforgettable experiences that make Hunza a true heaven on earth.</p>',
                'author' => 'TravelBook Editorial',
                'days_ago' => 32,
                'views' => 2100,
            ],
            [
                'category' => 'Destination Guides',
                'title' => 'Luxury Honeymoon Destinations',
                'category_slug' => 'destination-guides',
                'featured_image' => 'images/destinations/paris.jpg',
                'short_description' => 'Romantic escapes in Paris, the Maldives and beyond for couples seeking an unforgettable start to married life.',
                'description' => '<p>Your honeymoon should be nothing short of magical, and the right destination sets the tone for a lifetime of beautiful memories together.</p><p>We showcase the world\'s most romantic destinations, from candlelit dinners in Paris to overwater villas in the Maldives and serene retreats in Bali.</p><p>Each option includes exclusive resorts, private experiences and romantic touches designed to make your honeymoon truly unforgettable.</p>',
                'author' => 'TravelBook Editorial',
                'days_ago' => 40,
                'views' => 1880,
            ],
            [
                'category' => 'Travel Tips',
                'title' => 'How to Plan a Trip to Dubai',
                'category_slug' => 'travel-tips',
                'featured_image' => 'images/destinations/dubai.jpg',
                'short_description' => 'A step-by-step guide to organizing a seamless Dubai vacation, from visas and flights to attractions and dining.',
                'description' => '<p>Dubai is a dazzling city of futuristic skylines, luxury shopping and thrilling desert adventures. Planning your trip properly ensures you make the most of this energetic metropolis.</p><p>This guide walks you through visa requirements, the best time to visit, must-see attractions like the Burj Khalifa and Palm Jumeirah, plus dining and budget tips.</p><p>Follow our roadmap and enjoy a smooth, unforgettable journey through the heart of the United Arab Emirates.</p>',
                'author' => 'TravelBook Editorial',
                'days_ago' => 48,
                'views' => 1730,
            ],
        ];

        foreach ($blogs as $item) {
            $categoryId = BlogCategory::where('slug', $item['category_slug'])->value('id');

            Blog::updateOrCreate(
                ['slug' => Str::slug($item['title'])],
                [
                    'blog_category_id' => $categoryId,
                    'title' => $item['title'],
                    'slug' => Str::slug($item['title']),
                    'short_description' => $item['short_description'],
                    'description' => $item['description'],
                    'featured_image' => $item['featured_image'],
                    'author' => $item['author'],
                    'published_at' => now()->subDays($item['days_ago']),
                    'views' => $item['views'],
                    'featured' => true,
                    'status' => true,
                    'meta_title' => $item['title'].' | TravelBook Blog',
                    'meta_description' => $item['short_description'],
                ]
            );
        }
    }
}
