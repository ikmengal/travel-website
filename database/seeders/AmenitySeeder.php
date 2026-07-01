<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Amenity;

class AmenitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('amenities')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $amenities = [
            ['Free WiFi','wifi'],
            ['Parking','car'],
            ['Swimming Pool','pool'],
            ['Gym','barbell'],
            ['Spa','massage'],
            ['Restaurant','tools-kitchen-2'],
            ['Breakfast','coffee'],
            ['Room Service','bell'],
            ['Laundry','shirt'],
            ['Airport Shuttle','bus'],
            ['Family Rooms','users'],
            ['Non Smoking Rooms','ban'],
            ['Air Conditioning','snowflake'],
            ['Pet Friendly','paw'],
            ['Bar','glass-full'],
            ['24 Hours Front Desk','clock'],
            ['Elevator','elevator'],
            ['Wheelchair Access','accessible'],
            ['Conference Room','presentation'],
            ['Business Center','briefcase'],
        ];

        foreach ($amenities as $index => $item) {
            Amenity::create([
                'name' => $item[0],
                'slug' => Str::slug($item[0]). '_' .Str::random(5),
                'icon' => 'ti ti-'.$item[1],
                'sort_order' => $index + 1,
                'is_active' => true,
            ]);
        }
    }
}
