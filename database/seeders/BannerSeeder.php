<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Banner;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banners = [
            [
                'title' => 'Explore The World',
                'subtitle' => 'Your Journey Starts Here',
                'subtitle_1' => 'Discover Breathtaking Destinations',
                'subtitle_2' => 'Handcrafted Itineraries Just For You',
                'subtitle_3' => 'Book Now & Save Up To 30%',
                'description' => 'From the golden sands of Dubai to the tropical paradise of Bali, experience unforgettable journeys tailored to your dreams with expert guidance every step of the way.',
                'avatars_data' => json_encode(['/images/avatars/1.png', '/images/avatars/2.png', '/images/avatars/3.png']),
                'card_location' => 'Bali, Indonesia',
                'card_para' => '5 Days · 4 Nights from $899',
                'card_reviews' => '4.9 (2,400+ Reviews)',
                'tag_icon' => 'ti ti-plane',
                'tag_heading' => 'Summer Sale 2026',
                'tag_para' => 'Limited time offers on premium tours',
                'button_text' => 'Explore Tours',
                'button_url' => '/tours',
                'image' => 'images/destinations/hero.jpg',
                'featured' => true,
                'status' => true,
                'sort_order' => 1,
                'meta_title' => 'Explore The World - Travel Booking',
                'meta_description' => 'Discover the world with handcrafted travel experiences, exclusive deals and unforgettable adventures.',
            ],
            [
                'title' => 'Luxury Holidays',
                'subtitle' => 'Indulge In The Finest',
                'subtitle_1' => '5-Star Resorts & Private Villas',
                'subtitle_2' => 'All-Inclusive Escapes That Pamper You',
                'subtitle_3' => 'Elevate Your Getaway Today',
                'description' => 'Treat yourself to the ultimate luxury getaway in the Maldives, Paris and beyond — private transfers, ocean-view suites and personalised concierge service included.',
                'avatars_data' => json_encode(['/images/avatars/2.png', '/images/avatars/4.png', '/images/avatars/5.png']),
                'card_location' => 'Maldives',
                'card_para' => '7 Days · All Inclusive from $2,499',
                'card_reviews' => '5.0 (1,800+ Reviews)',
                'tag_icon' => 'ti ti-crown',
                'tag_heading' => 'Luxury Collection',
                'tag_para' => 'Curated premium stays worldwide',
                'button_text' => 'View Luxury Deals',
                'button_url' => '/tours?category=luxury',
                'image' => 'images/destinations/hero.jpg',
                'featured' => true,
                'status' => true,
                'sort_order' => 2,
                'meta_title' => 'Luxury Holidays - Travel Booking',
                'meta_description' => 'Premium 5-star travel experiences with private villas, ocean-view suites and all-inclusive packages.',
            ],
            [
                'title' => 'Adventure Awaits',
                'subtitle' => 'Step Out Of Your Comfort Zone',
                'subtitle_1' => 'Trek The Majestic Hunza & Skardu',
                'subtitle_2' => 'Thrilling Tours For The Bold Explorer',
                'subtitle_3' => 'Unforgettable Memories Guaranteed',
                'description' => 'Scale new heights in the mighty Karakoram, wander ancient Istanbul souks and kayak through emerald valleys — crafted for travellers who chase adrenaline.',
                'avatars_data' => json_encode(['/images/avatars/6.png', '/images/avatars/7.png', '/images/avatars/8.png']),
                'card_location' => 'Hunza, Pakistan',
                'card_para' => '8 Days Guided Trek from $1,299',
                'card_reviews' => '4.8 (950+ Reviews)',
                'tag_icon' => 'ti ti-mountain',
                'tag_heading' => 'Adventure Series',
                'tag_para' => 'Off-the-beaten-path expeditions',
                'button_text' => 'Discover Adventures',
                'button_url' => '/tours?category=adventure',
                'image' => 'images/destinations/hero.jpg',
                'featured' => true,
                'status' => true,
                'sort_order' => 3,
                'meta_title' => 'Adventure Awaits - Travel Booking',
                'meta_description' => 'Thrilling treks and expeditions to Hunza, Skardu and beyond for the bold explorer in you.',
            ],
        ];

        foreach ($banners as $banner) {
            Banner::updateOrCreate(
                [
                    'title' => $banner['title'],
                    'sort_order' => $banner['sort_order'],
                ],
                $banner
            );
        }
    }
}
