<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Wishlist;
use App\Models\User;
use App\Models\Tour;
use App\Models\Destination;

class WishlistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::whereHas('roles', fn ($q) => $q->where('name', 'Customer'))
            ->take(4)
            ->get();

        if ($users->isEmpty()) {
            return;
        }

        $tours = Tour::where('featured', true)->take(4)->get();
        $destinations = Destination::where('is_featured', true)->take(4)->get();

        $entries = [];

        foreach ($tours as $i => $tour) {
            $user = $users->get($i % $users->count());
            $entries[] = [
                'user_id' => $user->id,
                'wishlistable_type' => 'App\Models\Tour',
                'wishlistable_id' => $tour->id,
            ];
        }

        foreach ($destinations as $i => $destination) {
            $user = $users->get($i % $users->count());
            $entries[] = [
                'user_id' => $user->id,
                'wishlistable_type' => 'App\Models\Destination',
                'wishlistable_id' => $destination->id,
            ];
        }

        foreach ($entries as $index => $entry) {
            if ($index >= 8) {
                break;
            }

            Wishlist::firstOrCreate(
                $entry
            );
        }
    }
}
