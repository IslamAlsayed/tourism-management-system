<?php

namespace Database\Factories;

use App\Models\Client;
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
        $firstName = $this->faker->firstName();
        $middleName = $this->faker->optional(0.7)->firstName();
        $lastName = $this->faker->lastName();

        return [
            // Location information
            'region_id' => \App\Models\Region::inRandomOrder()->first()?->id,
            'subregion_id' => \App\Models\Subregion::inRandomOrder()->first()?->id,
            'country_id' => \App\Models\Country::inRandomOrder()->first()?->id,
            'state_id' => \App\Models\State::inRandomOrder()->first()?->id,
            'city_id' => \App\Models\City::inRandomOrder()->first()?->id,
            'nationality_id' => \App\Models\Nationality::inRandomOrder()->first()?->id,

            // Personal name information
            'first_name' => $firstName,
            'last_name' => $lastName,

            // Personal details
            'gender' => $this->faker->randomElement(['male', 'female']),
            'birth_date' => $this->faker->optional(0.8)->date('Y-m-d', '-25 years'),

            // Passport information
            'passport_number' => $this->faker->optional(0.6)->bothify('??######'),
            'passport_issue_date' => $this->faker->optional(0.6)->date('Y-m-d', '-2 years'),
            'passport_expiry_date' => $this->faker->optional(0.6)->date('Y-m-d', '+8 years'),

            // Email addresses
            'personal_email' => $this->faker->optional(0.7)->safeEmail(),
            'email_primary' => $this->faker->unique()->safeEmail(),
            'work_email' => $this->faker->optional(0.5)->companyEmail(),
            'secondary_email' => $this->faker->optional(0.3)->safeEmail(),

            // Phone numbers
            'primary_phone' => $this->faker->phoneNumber(),
            'secondary_phone' => $this->faker->optional(0.6)->phoneNumber(),
            'mobile' => $this->faker->optional(0.8)->phoneNumber(),
            'home_phone' => $this->faker->optional(0.4)->phoneNumber(),
            'work_phone' => $this->faker->optional(0.5)->phoneNumber(),
            'work_phone_ext' => $this->faker->optional(0.3)->numerify('###'),
            'fax_number' => $this->faker->optional(0.2)->phoneNumber(),
            'whatsapp' => $this->faker->optional(0.7)->phoneNumber(),

            // Company/Business information
            'company_name' => $this->faker->optional(0.4)->company(),
            'company_phone' => $this->faker->optional(0.4)->phoneNumber(),
            'company_email' => $this->faker->optional(0.4)->companyEmail(),
            'job_title' => $this->faker->optional(0.6)->jobTitle(),
            'sector' => $this->faker->optional(0.5)->randomElement(['Tourism', 'Technology', 'Finance', 'Healthcare', 'Education']),
            'department' => $this->faker->optional(0.5)->randomElement(['Sales', 'Marketing', 'IT', 'HR', 'Operations']),
            'business_type' => $this->faker->optional(0.4)->randomElement(['B2B', 'B2C', 'B2G']),
            'business_registration_number' => $this->faker->optional(0.3)->numerify('CR-##########'),
            'tax_id' => $this->faker->optional(0.3)->numerify('TAX-##########'),

            // Address information
            'box' => $this->faker->optional(0.3)->numerify('P.O. Box ####'),
            'postal_code' => $this->faker->optional(0.6)->postcode(),
            'street_address' => $this->faker->optional(0.8)->streetAddress(),
            'address_line_2' => $this->faker->optional(0.3)->secondaryAddress(),

            // Online presence
            'website_url' => $this->faker->optional(0.3)->url(),
            'linkedin_url' => $this->faker->optional(0.2)->url(),

            // Status and preferences
            'client_status' => $this->faker->randomElement(['active', 'inactive', 'pending', 'blacklisted']),
            'currency_id' => \App\Models\Currency::inRandomOrder()->first()?->id,
            'timezone_id' => \App\Models\Timezone::inRandomOrder()->first()?->id,
            'notes' => $this->faker->optional(0.4)->paragraph(),

            // Tracking
            'created_by' => User::inRandomOrder()->first()?->id ?? 1,
            'updated_by' => 2,
            'created_at' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'updated_at' => now(),
        ];
    }

    /**
     * Indicate that the client is active.
     */
    public function active(): static
    {
        return $this->state(fn(array $attributes) => [
            'client_status' => 'active',
        ]);
    }

    /**
     * Indicate that the client is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn(array $attributes) => [
            'client_status' => 'inactive',
        ]);
    }
}