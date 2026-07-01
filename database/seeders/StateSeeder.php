<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateSeeder extends Seeder
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

        DB::table('states')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $states = [];

        foreach ($json as $country) {

            if (!isset($country['states'])) {
                continue;
            }

            foreach ($country['states'] as $state) {

                $states[] = [
                    'id' => $state['id'],
                    'country_id' => $country['id'],
                    'name' => $state['name'],
                    'state_code' => $state['iso3166_2'],
                    'latitude' => $state['latitude'] ?? null,
                    'longitude' => $state['longitude'] ?? null,
                    'type' => $state['type'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        foreach (array_chunk($states, 1000) as $chunk) {
            DB::table('states')->insert($chunk);
        }
    }
}
