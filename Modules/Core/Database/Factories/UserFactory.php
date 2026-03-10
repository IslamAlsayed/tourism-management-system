<?php

namespace Modules\Core\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Core\Entities\User>
 */
class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Core\Entities\User::class;

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
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '12345678',
            'remember_token' => Str::random(10),
            'bio' => $this->faker->paragraph(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'phone' => $this->faker->phoneNumber(),
            'mobile' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'user_code' => $this->faker->unique()->bothify('USER###??'),
            'employee_id' => $this->faker->unique()->bothify('EMP###??'),
            'birth_date' => $this->faker->date(),
            'hire_date' => $this->faker->date(),
            'department' => $this->faker->word(),
            'position' => $this->faker->jobTitle(),
            // 'preferred_language' => $this->faker->randomElement(array_keys(config('languages.system_languages'))),
            'preferred_language' => 'en',
            'timezone_id' => \Modules\Localization\Entities\Timezone::inRandomOrder()->first()?->id ?? 1,
            'preferences' => '',
            'photo' => null,
            'role' => 'user',
            'is_active' => false,
            'is_verified' => true,
            'force_password_change' => false,
            'last_login_at' => null,
            'last_login_ip' => null,
            'notes' => null,
            'created_by' => getActiveUserId() ?? 2,
            'updated_by' => getActiveUserId() ?? null,
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
