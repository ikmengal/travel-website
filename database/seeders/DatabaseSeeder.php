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
            // ---------- Geography (dependencies for destinations) ----------
            CountrieSeeder::class,
            StateSeeder::class,
            CitySeeder::class,

            // ---------- Auth / RBAC ----------
            RoleSeeder::class,
            PermissionSeeder::class,
            AdminSeeder::class,
            UserSeeder::class,
            AssignPermissionSeeder::class,

            // ---------- Site configuration ----------
            SocialLinkSeeder::class,
            SettingSeeder::class,

            // ---------- Destinations & related media ----------
            DestinationSeeder::class,
            DestinationImageSeeder::class,

            // ---------- Tours (packages) & related data ----------
            TourCategorySeeder::class,
            TourSeeder::class,
            TourImageSeeder::class,
            TourIncludeSeeder::class,
            TourExcludeSeeder::class,
            TourItinerarySeeder::class,
            TourDepartureSeeder::class,

            // ---------- Frontend content sections ----------
            BannerSeeder::class,
            CounterSeeder::class,
            GallerySeeder::class,
            PartnerSeeder::class,
            TeamMemberSeeder::class,
            TestimonialSeeder::class,

            // ---------- CMS pages & blog ----------
            PageSeeder::class,
            FaqSeeder::class,
            ReviewSeeder::class,
            BlogCategorySeeder::class,
            BlogSeeder::class,

            // ---------- Commerce ----------
            CouponSeeder::class,
            WishlistSeeder::class,

            // ---------- Leads / inbox ----------
            NewsletterSeeder::class,
            ContactMessageSeeder::class,
        ]);
    }
}
