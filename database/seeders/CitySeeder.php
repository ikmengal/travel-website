<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = json_decode(
            file_get_contents(database_path('data/countries+states+cities.json')),
            true
        );

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('cities')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $cities = [];

        foreach ($json as $country) {

            if (!isset($country['states'])) {
                continue;
            }

            foreach ($country['states'] as $state) {

                if (!isset($state['cities'])) {
                    continue;
                }

                foreach ($state['cities'] as $city) {

                    $cities[] = [
                        'id' => $city['id'],
                        'country_id' => $country['id'],
                        'state_id' => $state['id'],
                        'slug' => Str::slug($city['name']). '_' . Str::random(5),
                        'name' => $city['name'],
                        'latitude' => $city['latitude'] ?? null,
                        'longitude' => $city['longitude'] ?? null,
                        'status' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        foreach (array_chunk($cities, 1000) as $chunk) {
            DB::table('cities')->insert($chunk);
        }
    }
}
