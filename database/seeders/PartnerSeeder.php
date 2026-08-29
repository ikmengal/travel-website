<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Partner;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $partners = [
            [
                'name' => 'Emirates Airlines',
                'website' => 'https://www.emirates.com',
                'logo' => '1784665192_6a5fd468972a1.png',
                'sort_order' => 1,
                'featured' => true,
                'status' => true,
            ],
            [
                'name' => 'Qatar Airways',
                'website' => 'https://www.qatarairways.com',
                'logo' => '1784666360_6a5fd8f8608ca.png',
                'sort_order' => 2,
                'featured' => true,
                'status' => true,
            ],
            [
                'name' => 'Marriott International',
                'website' => 'https://www.marriott.com',
                'logo' => '1784666382_6a5fd90e563e5.png',
                'sort_order' => 3,
                'featured' => true,
                'status' => true,
            ],
            [
                'name' => 'Hilton Hotels & Resorts',
                'website' => 'https://www.hilton.com',
                'logo' => '1784666394_6a5fd91a24d09.png',
                'sort_order' => 4,
                'featured' => true,
                'status' => true,
            ],
            [
                'name' => 'Expedia',
                'website' => 'https://www.expedia.com',
                'logo' => '1784666408_6a5fd9283d7ac.png',
                'sort_order' => 5,
                'featured' => true,
                'status' => true,
            ],
            [
                'name' => 'Booking.com',
                'website' => 'https://www.booking.com',
                'logo' => '1784666419_6a5fd933cc751.png',
                'sort_order' => 6,
                'featured' => true,
                'status' => true,
            ],
            [
                'name' => 'TripAdvisor',
                'website' => 'https://www.tripadvisor.com',
                'logo' => '1784666431_6a5fd93f3e94e.png',
                'sort_order' => 7,
                'featured' => true,
                'status' => true,
            ],
            [
                'name' => 'Airbnb',
                'website' => 'https://www.airbnb.com',
                'logo' => '1784666543_6a5fd9afc27ef.png',
                'sort_order' => 8,
                'featured' => true,
                'status' => true,
            ],
        ];

        foreach ($partners as $partner) {
            Partner::updateOrCreate(
                [
                    'name' => $partner['name'],
                ],
                $partner
            );
        }
    }
}