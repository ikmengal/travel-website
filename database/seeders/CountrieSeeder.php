<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CountrieSeeder extends Seeder
{
   public function run(): void
    {
        $json = json_decode(
            file_get_contents(database_path('data/countries+states+cities.json')),
            true
        );

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('countries')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $countries = [];

        foreach ($json as $country) {
            $countries[] = [
                'id' => $country['id'],
                'slug' => Str::slug($country['name']).'_'.Str::random(6),
                'name' => $country['name'],
                'iso2' => $country['iso2'],
                'iso3' => $country['iso3'],
                'phone_code' => $country['phonecode'] ?? null,
                'numeric_code' => $country['numeric_code'] ?? null,
                'currency' => $country['currency'] ?? null,
                'currency_symbol' => $country['currency_symbol'] ?? null,
                'currency_name' => $country['currency_name'] ?? null,
                'capital' => $country['capital'] ?? null,
                'region' => $country['region'] ?? null,
                'latitude' => $country['latitude'] ?? null,
                'longitude' => $country['longitude'] ?? null,
                'flag' => $country['emoji'] ?? null,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('countries')->insert($countries);
    }
}
