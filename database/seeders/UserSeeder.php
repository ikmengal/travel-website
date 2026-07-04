<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Hotel Owners
        |--------------------------------------------------------------------------
        */
        $owners = User::factory(5)->owner()->create();
        foreach ($owners as $owner) {
            $owner->assignRole('Hotel Owner');
        }

        /*
        |--------------------------------------------------------------------------
        | Customers
        |--------------------------------------------------------------------------
        */
        $customers = User::factory(30)->customer()->create();
        foreach ($customers as $customer) {
            $customer->assignRole('Customer');
        }
    }
}
