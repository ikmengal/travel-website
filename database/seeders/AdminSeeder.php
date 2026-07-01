<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $admin = User::firstOrCreate(
            [
                'email' => 'admin@travelbook.com',
            ],
            [
                'slug' => Str::slug('Super Admin'). '_' .Str::random(10),
                'name' => 'Super Admin',
                'username' => 'superadmin',
                'phone' => '03001234567',
                'password' => Hash::make('Admin@123'),
                'gender' => "Male",
                'status' => true,
                'email_verified_at' => now(),
            ]
        );

        $admin->assignRole('Super Admin');
    }
}
