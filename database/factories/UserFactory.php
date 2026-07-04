<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\User;

/**
 * @extends Factory<User>
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password = null;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $firstName = fake()->firstName();
        $lastName = fake()->lastName();

        $name = $firstName . ' ' . $lastName;

        return [
            'name' => $name,
            'slug' => Str::slug($name) . '-' . fake()->unique()->numberBetween(1000, 9999),
            'username' => fake()->unique()->userName(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => '03'.fake()->numerify('#########'),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => fake()->regexify('[A-Za-z0-9]{10}'),
            'avatar' => null,
            'country_id' => Country::inRandomOrder()->value('id'),
            'state_id' => State::inRandomOrder()->value('id'),
            'city_id' => City::inRandomOrder()->value('id'),
            'gender' => fake()->randomElement([
                'Male',
                'Female',
                'Other'
            ]),
            'date_of_birth' => fake()->date(),
            'address' => fake()->address(),
            'bio' => fake()->paragraph(),
            'status' => 'Active',
        ];
    }

    public function owner(): static
    {
        return $this->state(fn () => [
            'status' => 'Active',
        ]);
    }

    public function customer(): static
    {
        return $this->state(fn () => [
            'status' => 'Active',
        ]);
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
