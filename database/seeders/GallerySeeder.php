<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Country;
use App\Models\Gallery;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $galleries = [
            [
                'country' => 'Indonesia',
                'title' => 'Bali Sunset Paradise',
                'category' => 'Beach',
                'image' => 'gallery1.jpg',
                'caption' => 'Tropical evenings over the Indian Ocean',
                'short_description' => 'Golden sunsets and serene shores in the Island of the Gods.',
                'description' => "Witness breathtaking sunsets over Bali's emerald rice terraces and pristine beaches — a photographer's dream, a traveller's paradise.",
                'sort_order' => 1,
                'featured' => true,
                'status' => true,
            ],
            [
                'country' => 'United Arab Emirates',
                'title' => 'Dubai Skyline Glow',
                'category' => 'City',
                'image' => 'gallery2.jpg',
                'caption' => 'A futuristic metropolis shimmering after dark',
                'short_description' => 'Iconic towers and desert luxury at dusk.',
                'description' => 'From the Burj Khalifa to the Dubai Marina, the city dazzles with record-breaking architecture, gold souks and desert adventures.',
                'sort_order' => 2,
                'featured' => true,
                'status' => true,
            ],
            [
                'country' => 'France',
                'title' => 'Parisian Elegance',
                'category' => 'City',
                'image' => 'gallery3.jpg',
                'caption' => 'Timeless romance beneath the Eiffel Tower',
                'short_description' => 'Cafés, art and iconic landmarks in the City of Light.',
                'description' => 'Stroll along the Seine, explore the Louvre and marvel at the Eiffel Tower — Paris is where every corner tells a story of art and amour.',
                'sort_order' => 3,
                'featured' => true,
                'status' => true,
            ],
            [
                'country' => 'Turkey',
                'title' => 'Istanbul Grand Bazaar',
                'category' => 'Heritage',
                'image' => 'gallery4.jpg',
                'caption' => 'A maze of colour, spice and history',
                'short_description' => 'Two continents meet in an ancient trading crossroads.',
                'description' => 'Haggle in lantern-lit bazaars, sip Turkish tea under the Blue Mosque and sail the Bosphorus where Europe greets Asia.',
                'sort_order' => 4,
                'featured' => true,
                'status' => true,
            ],
            [
                'country' => 'Thailand',
                'title' => 'Bangkok Temple Trail',
                'category' => 'Heritage',
                'image' => 'gallery5.jpg',
                'caption' => 'Gilded spires and vibrant street life',
                'short_description' => 'Golden temples blended with electric night markets.',
                'description' => 'Explore the Grand Palace, cruise the Chao Phraya and taste world-famous street food in the bustling heart of Thailand.',
                'sort_order' => 5,
                'featured' => false,
                'status' => true,
            ],
            [
                'country' => 'Maldives',
                'title' => 'Maldives Overwater Oasis',
                'category' => 'Beach',
                'image' => '1783540415_0_6a4eaabf0cf23.jpg',
                'caption' => 'Turquoise lagoons and floating villas',
                'short_description' => 'Utter serenity on a private island hideaway.',
                'description' => 'Wake to lagoon views, snorkel among vibrant reefs and dine under the stars — the Maldives is the definition of overwater bliss.',
                'sort_order' => 6,
                'featured' => false,
                'status' => true,
            ],
            [
                'country' => 'Switzerland',
                'title' => 'Zurich Alpine Charm',
                'category' => 'Nature',
                'image' => '1783540415_1_6a4eaabf1c3b6.png',
                'caption' => 'Glaciers, lakes and old-world streets',
                'short_description' => 'Swiss precision meets soaring alpine beauty.',
                'description' => "From Lake Zurich's promenades to nearby snow-capped peaks, experience picture-perfect Swiss landscapes year-round.",
                'sort_order' => 7,
                'featured' => false,
                'status' => true,
            ],
            [
                'country' => 'Pakistan',
                'title' => 'Verdant Hunza Valleys',
                'category' => 'Nature',
                'image' => '1783540415_3_6a4eaabf1e271.webp',
                'caption' => 'Where the Karakoram kisses the clouds',
                'short_description' => 'Ancient forts and towering peaks in northern Pakistan.',
                'description' => 'Wander apricot orchards, explore Baltit Fort and stand beneath Rakaposhi in the legendary Hunza Valley.',
                'sort_order' => 8,
                'featured' => false,
                'status' => true,
            ],
            [
                'country' => 'Pakistan',
                'title' => 'Skardu Mountain King',
                'category' => 'Adventure',
                'image' => '1783540415_4_6a4eaabf1eef8.webp',
                'caption' => 'Gateway to the legendary K2',
                'short_description' => 'Startling peaks, crystal lakes and raw adventure.',
                'description' => 'Meet highest peaks on earth, from K2 base camps to the mirror-still Shangrila resort lake of Skardu.',
                'sort_order' => 9,
                'featured' => false,
                'status' => true,
            ],
        ];

        foreach ($galleries as $gallery) {
            $countryId = Country::where('name', $gallery['country'])->value('id');

            Gallery::updateOrCreate(
                [
                    'slug' => Str::slug($gallery['title']),
                ],
                [
                    'country_id' => $countryId,
                    'title' => $gallery['title'],
                    'slug' => Str::slug($gallery['title']),
                    'category' => $gallery['category'],
                    'image' => $gallery['image'],
                    'caption' => $gallery['caption'],
                    'short_description' => $gallery['short_description'],
                    'description' => $gallery['description'],
                    'sort_order' => $gallery['sort_order'],
                    'featured' => $gallery['featured'],
                    'status' => $gallery['status'],
                ]
            );
        }
    }
}