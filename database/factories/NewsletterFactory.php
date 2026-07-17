<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Newsletter;

/**
 * @extends Factory<Newsletter>
 */
class NewsletterFactory extends Factory
{
    protected $model = Newsletter::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $verified = fake()->boolean(80);

        return [
            'email'                => fake()->unique()->safeEmail(),
            'token'                => Str::random(64),
            'subscribed_at'        => fake()->dateTimeBetween('-1 year', 'now'),
            'verified_at'          => $verified ? fake()->dateTimeBetween('-1 year', 'now') : null,
            'unsubscribed_at'      => null,
            'unsubscribe_reason'   => null,
            'ip_address'           => fake()->ipv4(),
            'user_agent'           => fake()->userAgent(),
            'status'               => $verified,
            'deleted_at'           => null,
        ];
    }

    /**
     * Verified Subscriber
     */
    public function verified(): static
    {
        return $this->state(fn () => [
            'status' => true,
            'verified_at' => now(),
        ]);
    }

    /**
     * Unverified Subscriber
     */
    public function unverified(): static
    {
        return $this->state(fn () => [
            'status' => false,
            'verified_at' => null,
        ]);
    }

    /**
     * Unsubscribed
     */
    public function unsubscribed(): static
    {
        return $this->state(fn () => [
            'status' => false,
            'unsubscribed_at' => now(),
            'unsubscribe_reason' => fake()->sentence(),
        ]);
    }
}
