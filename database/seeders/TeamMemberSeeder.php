<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\TeamMember;

class TeamMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = [
            [
                'name' => 'Ali Khan',
                'designation' => 'CEO & Founder',
                'image' => '',
                'short_bio' => 'Visionary leader with 15+ years in the travel industry, building journeys that connect people to the world.',
                'email' => 'ali.khan@example.com',
                'phone' => '+92 300 1234567',
                'facebook' => 'https://facebook.com/',
                'instagram' => 'https://instagram.com/',
                'linkedin' => 'https://linkedin.com/',
                'twitter' => 'https://x.com/',
                'youtube' => 'https://youtube.com/',
                'sort_order' => 1,
                'featured' => true,
                'status' => true,
            ],
            [
                'name' => 'Sarah Ahmed',
                'designation' => 'Head of Operations',
                'image' => '',
                'short_bio' => 'Logistics maestro who ensures every trip runs like clockwork, from airport pickup to final farewell.',
                'email' => 'sarah.ahmed@example.com',
                'phone' => '+92 300 2345678',
                'facebook' => 'https://facebook.com/',
                'instagram' => 'https://instagram.com/',
                'linkedin' => 'https://linkedin.com/',
                'twitter' => 'https://x.com/',
                'youtube' => 'https://youtube.com/',
                'sort_order' => 2,
                'featured' => true,
                'status' => true,
            ],
            [
                'name' => 'Emily Carter',
                'designation' => 'Head of Marketing',
                'image' => '',
                'short_bio' => 'Creative storyteller crafting campaigns that inspire wanderlust in travellers across the globe.',
                'email' => 'emily.carter@example.com',
                'phone' => '+44 20 7946 0958',
                'facebook' => 'https://facebook.com/',
                'instagram' => 'https://instagram.com/',
                'linkedin' => 'https://linkedin.com/',
                'twitter' => 'https://x.com/',
                'youtube' => 'https://youtube.com/',
                'sort_order' => 3,
                'featured' => true,
                'status' => true,
            ],
            [
                'name' => 'David Mbeki',
                'designation' => 'Lead Travel Consultant',
                'image' => '',
                'short_bio' => 'Destination expert with first-hand knowledge of 40+ countries and a talent for tailoring dream holidays.',
                'email' => 'david.mbeki@example.com',
                'phone' => '+27 11 555 0199',
                'facebook' => 'https://facebook.com/',
                'instagram' => 'https://instagram.com/',
                'linkedin' => 'https://linkedin.com/',
                'twitter' => 'https://x.com/',
                'youtube' => 'https://youtube.com/',
                'sort_order' => 4,
                'featured' => true,
                'status' => true,
            ],
        ];

        foreach ($members as $member) {
            TeamMember::updateOrCreate(
                [
                    'slug' => Str::slug($member['name']),
                ],
                [
                    'name' => $member['name'],
                    'slug' => Str::slug($member['name']),
                    'designation' => $member['designation'],
                    'image' => $member['image'],
                    'short_bio' => $member['short_bio'],
                    'email' => $member['email'],
                    'phone' => $member['phone'],
                    'facebook' => $member['facebook'],
                    'instagram' => $member['instagram'],
                    'linkedin' => $member['linkedin'],
                    'twitter' => $member['twitter'],
                    'youtube' => $member['youtube'],
                    'sort_order' => $member['sort_order'],
                    'featured' => $member['featured'],
                    'status' => $member['status'],
                ]
            );
        }
    }
}