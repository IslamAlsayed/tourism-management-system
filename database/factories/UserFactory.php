<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '12345678',
            'remember_token' => Str::random(10),
            'bio' => fake()->paragraph(),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'phone' => fake()->phoneNumber(),
            'mobile' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'user_code' => fake()->unique()->bothify('USER###??'),
            'employee_id' => fake()->unique()->bothify('EMP###??'),
            'birth_date' => fake()->date(),
            'hire_date' => fake()->date(),
            'department' => fake()->word(),
            'position' => fake()->jobTitle(),
            'preferred_language' => fake()->randomElement(['en', 'es', 'fr', 'de', 'it', 'pt', 'ar']),
            'timezone' => fake()->timezone(),
            'preferences' => '',
            'is_admin' => true,
            'photo' => null,
            'user_status' => false,
            'is_active' => true,
            'is_verified' => true,
            'force_password_change' => false,
            'last_login_at' => null,
            'last_login_ip' => null,
            'notes' => null,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}