<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Restaurant>
 */
class RestaurantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'name_ar' => $this->faker->company,
            'type_id' => \App\Models\Type::where('name', 'restaurant')->first()->id ?? 7,
            'currency_id' => \App\Models\Currency::inRandomOrder()->first()?->id,
            'region_id' => \App\Models\Region::inRandomOrder()->first()?->id,
            'subregion_id' => \App\Models\Subregion::inRandomOrder()->first()?->id,
            'country_id' => \App\Models\Country::inRandomOrder()->first()?->id,
            'state_id' => \App\Models\State::inRandomOrder()->first()?->id,
            'city_id' => \App\Models\City::inRandomOrder()->first()?->id,
            'rating' => $this->faker->randomFloat(1, 1, 5),
            'company_name' => $this->faker->company,
            'specialty' => $this->faker->word,
            'phone_01' => $this->faker->phoneNumber,
            'phone_02' => $this->faker->optional()->phoneNumber,
            'fax' => $this->faker->optional()->phoneNumber,
            'contact_person' => $this->faker->name,
            'email_01' => $this->faker->unique()->safeEmail,
            'email_02' => $this->faker->optional()->safeEmail,
            'box' => $this->faker->optional()->postcode,
            'postal_code' => $this->faker->postcode,
            'street' => $this->faker->streetAddress,
            'mobile' => $this->faker->phoneNumber,
            'website' => $this->faker->optional()->url,
            'photo' => "https://picsum.photos/seed/" . rand(1, 1000) . "/300/300",
            'is_active' => $this->faker->boolean,
            'wheelchair_accessible' => $this->faker->boolean,
            'free_wifi' => $this->faker->boolean,
            'parking' => $this->faker->boolean,
            'swimming_pool' => $this->faker->boolean,
            'gym' => $this->faker->boolean,
            'indoor' => $this->faker->boolean,
            'outdoor' => $this->faker->boolean,
            'spa' => $this->faker->boolean,
            'description' => $this->faker->paragraph,
            'notes' => $this->faker->optional()->sentence,
        ];
    }
}