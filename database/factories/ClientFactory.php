<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Nationality;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    protected $model = Client::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $clientType = $this->faker->randomElement(['individual', 'corporate']);
        $firstName = $this->faker->firstName();
        $lastName = $this->faker->lastName();
        $name = $firstName . ' ' . $lastName;

        return [
            'client_code' => 'CL-' . $this->faker->unique()->numerify('######'),
            'name' => $name,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'mobile' => $this->faker->phoneNumber(),
            'whatsapp' => $this->faker->optional(0.7)->phoneNumber(),
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'country' => $this->faker->country(),
            'postal_code' => $this->faker->optional()->postcode(),

            // Company Information (only for corporate clients)
            'company_name' => $clientType === 'corporate' ? $this->faker->company() : null,
            'company_address' => $clientType === 'corporate' ? $this->faker->address() : null,
            'tax_number' => $clientType === 'corporate' ? $this->faker->optional()->numerify('TAX-##########') : null,
            'commercial_registration' => $clientType === 'corporate' ? $this->faker->optional()->numerify('CR-##########') : null,
            'company_phone' => $clientType === 'corporate' ? $this->faker->optional()->phoneNumber() : null,
            'company_email' => $clientType === 'corporate' ? $this->faker->optional()->companyEmail() : null,

            // Personal Information
            'nationality_id' => Nationality::inRandomOrder()->first()?->id,
            'passport_number' => $this->faker->optional(0.6)->bothify('??######'),
            'id_number' => $this->faker->optional(0.7)->numerify('##########'),
            'birth_date' => $this->faker->optional(0.8)->date('Y-m-d', '-25 years'),
            'gender' => $this->faker->randomElement(['male', 'female']),

            // Client Classification
            'client_type' => $clientType,
            'client_status' => $this->faker->randomElement(['active', 'inactive', 'blacklisted']),

            // Financial Information
            'credit_limit' => $this->faker->randomFloat(2, 5000, 100000),
            'payment_terms' => $this->faker->randomElement([0, 7, 15, 30, 45, 60, 90]),
            'discount_rate' => $this->faker->randomFloat(2, 0, 25),
            'currency' => $this->faker->randomElement(['USD', 'EUR', 'SAR', 'AED', 'JOD']),

            // Additional Fields
            'preferred_language' => $this->faker->randomElement(['en', 'ar']),
            'notes' => $this->faker->optional(0.4)->paragraph(),
            'is_active' => $this->faker->boolean(85), // 85% active
            'is_verified' => $this->faker->boolean(70), // 70% verified

            // Audit Fields
            'created_by' => User::inRandomOrder()->first()?->id ?? 1,
            'updated_by' => null,
            'created_at' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'updated_at' => now(),
        ];
    }

    /**
     * Indicate that the client is individual type.
     */
    public function individual(): static
    {
        return $this->state(fn(array $attributes) => [
            'client_type' => 'individual',
            'company_name' => null,
            'company_address' => null,
            'tax_number' => null,
            'commercial_registration' => null,
            'company_phone' => null,
            'company_email' => null,
        ]);
    }

    /**
     * Indicate that the client is corporate type.
     */
    public function corporate(): static
    {
        return $this->state(fn(array $attributes) => [
            'client_type' => 'corporate',
            'company_name' => $this->faker->company(),
            'company_address' => $this->faker->address(),
            'tax_number' => $this->faker->numerify('TAX-##########'),
            'commercial_registration' => $this->faker->numerify('CR-##########'),
            'company_phone' => $this->faker->phoneNumber(),
            'company_email' => $this->faker->companyEmail(),
        ]);
    }

    /**
     * Indicate that the client is active.
     */
    public function active(): static
    {
        return $this->state(fn(array $attributes) => [
            'client_status' => 'active',
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the client is verified.
     */
    public function verified(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_verified' => true,
        ]);
    }
}
