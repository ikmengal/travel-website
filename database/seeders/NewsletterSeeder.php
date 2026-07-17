<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Newsletter;

class NewsletterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Newsletter::factory()
            ->count(20)
            ->create();

        Newsletter::factory()
            ->count(10)
            ->verified()
            ->create();

        Newsletter::factory()
            ->count(5)
            ->unverified()
            ->create();

        Newsletter::factory()
            ->count(5)
            ->unsubscribed()
            ->create();
    }
}
