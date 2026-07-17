<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ContactMessage;
use App\Models\User;

/**
 * @extends Factory<ContactMessage>
 */
class ContactMessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->value('id'),
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->numerify('03#########'),
            'subject' => fake()->randomElement([
                'Hotel Booking Inquiry',
                'Tour Package Information',
                'Flight Booking',
                'Refund Request',
                'Payment Issue',
                'General Question',
                'Support Required',
                'Travel Visa Help',
            ]),

            'message' => fake()->paragraphs(rand(2,4), true),
            'ip_address' => fake()->ipv4(),
            'user_agent' => fake()->userAgent(),
            'is_read' => fake()->boolean(),
            'read_at' => fake()->optional()->dateTimeBetween('-20 days'),
            'is_replied' => fake()->boolean(),
            'replied_at' => fake()->optional()->dateTimeBetween('-15 days'),
            'status' => fake()->boolean(90),
            'created_at' => fake()->dateTimeBetween('-30 days'),
            'updated_at' => now(),
        ];
    }
}
