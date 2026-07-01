<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\HotelType;

class HotelTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('hotel_types')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $hoteltypes = [
            [
                'name' => 'Hotel',
                'slug' => 'hotel',
                'sort_order' => 1,
            ],
            [
                'name' => 'Resort',
                'slug' => 'resort',
                'sort_order' => 2,
            ],
            [
                'name' => 'Villa',
                'slug' => 'villa',
                'sort_order' => 3,
            ],
            [
                'name' => 'Apartment',
                'slug' => 'apartment',
                'sort_order' => 4,
            ],
            [
                'name' => 'Guest House',
                'slug' => 'guest-house',
                'sort_order' => 5,
            ],
            [
                'name' => 'Hostel',
                'slug' => 'hostel',
                'sort_order' => 6,
            ],
        ];

        foreach ($hoteltypes as $key => $hoteltype) {
            HotelType::restoreOrCreate([
                'name' => $hoteltype['name'],
                'slug' => $hoteltype['slug']. '_' .Str::random(5),
                'sort_order' => $hoteltype['sort_order'],
            ]);
        }
    }
}
