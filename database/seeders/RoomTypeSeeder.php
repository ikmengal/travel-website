<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\RoomType;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('hotel_types')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $types = [
            ['Standard Room','bed'],
            ['Deluxe Room','bed'],
            ['Superior Room','bed'],
            ['Executive Room','building'],
            ['Junior Suite','home'],
            ['Family Room','users'],
            ['Luxury Suite','star'],
            ['Presidential Suite','crown'],
        ];

        foreach ($types as $index => $type){
            RoomType::create([
                'name' => $type[0],
                'slug' => Str::slug($type[0]). '_' .Str::random(5),
                'icon' => 'ti ti-'.$type[1],
                'sort_order' => $index + 1,
                'is_active' => true,
            ]);
        }
    }
}
