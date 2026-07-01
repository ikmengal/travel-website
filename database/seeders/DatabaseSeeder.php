<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CountrieSeeder::class,
            StateSeeder::class,
            CitySeeder::class,

            RoleSeeder::class,
            PermissionSeeder::class,
            AdminSeeder::class,

            AssignPermissionSeeder::class,

            HotelTypeSeeder::class,
            AmenitySeeder::class,
            RoomTypeSeeder::class,
        ]);
    }
}
