<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\TouristSite;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TouristSite>
 */
class TouristSiteFactory extends Factory
{
    protected $model = TouristSite::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Location
            'city_id' => City::inRandomOrder()->first()?->id ?? 1,

            // Site Information
            'name' => $this->faker->randomElement([
                'Ancient Temple of Serenity',
                'Crystal Falls National Park',
                'Historic Downtown Museum',
                'Sunset Beach Resort',
                'Mountain View Observatory',
                'Cultural Heritage Center',
                'Royal Palace Gardens',
                'Adventure Sports Complex',
                'Archaeological Discovery Site',
                'Nature Conservation Area',
                'Egyptian Museum',
                'Great Pyramids of Giza',
                'Temple of Karnak',
                'Valley of the Kings',
                'Abu Simbel Temples',
            ]),
            'name_ar' => $this->faker->randomElement([
                'معبد الهدوء الأثري',
                'منتزه شلالات الكريستال الوطني',
                'متحف وسط المدينة التاريخي',
                'منتجع شاطئ غروب الشمس',
                'مرصد إطلالة الجبل',
                'مركز التراث الثقافي',
                'حدائق القصر الملكي',
                'مجمع الرياضات المغامرة',
                'موقع الاكتشاف الأثري',
                'منطقة المحافظة على الطبيعة',
                'المتحف المصري',
                'أهرام الجيزة العظيمة',
                'معبد الكرنك',
                'وادي الملوك',
                'معابد أبو سمبل',
            ]),
            'site_type' => $this->faker->randomElement(['historical', 'natural', 'cultural', 'religious', 'archaeological', 'museum', 'park', 'beach', 'mountain', 'monument']),
            'unesco_site' => $this->faker->boolean(20), // 20% chance
            'supplier_type' => $this->faker->randomElement(['Government', 'Private', 'NGO', 'International', 'Community']),
            'supplier_name' => $this->faker->randomElement([
                'Ministry of Tourism and Antiquities',
                'Egyptian Heritage Foundation',
                'Private Tourism Company',
                'National Park Service',
                'UNESCO Heritage Organization',
            ]),
            'sites_theme' => $this->faker->randomElement([
                'Ancient History',
                'Art & Culture',
                'Natural Wonders',
                'Modern Architecture',
                'Religious Sites',
                'Archaeological',
                'Biodiversity',
                'Traditional Arts',
                'Underwater Wonders',
                'Desert Landscapes',
            ]),

            // Coordinates (Random coordinates within Egypt/World)
            'latitude' => $this->faker->latitude(20, 35),
            'longitude' => $this->faker->longitude(25, 40),

            // Descriptions
            'description' => $this->faker->paragraphs(3, true),
            'nearby_attractions' => $this->faker->randomElement([
                'Ancient temples, museums, and cultural centers nearby',
                'Beautiful beaches and water sports facilities',
                'Mountain hiking trails and scenic viewpoints',
                'Local markets, restaurants, and shopping centers',
                'Archaeological sites and historical monuments',
                'Wildlife sanctuaries and nature reserves',
            ]),
            'notes' => $this->faker->paragraphs(3, true),

            // Photos (Media file IDs)
            'main_image' => "https://picsum.photos/seed/" . rand(1, 1000) . "/300/300",
            'gallery_images' => array_map(fn() => "https://picsum.photos/seed/" . rand(1, 1000) . "/300/300", range(1, rand(1, rand(1, 15)))),

            // Status
            'sort_order' => $this->faker->numberBetween(0, 100),
            'is_active' => $this->faker->boolean(85), // 85% active

            'created_at' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'updated_at' => now(),
        ];
    }

    /**
     * Indicate that the site is active.
     */
    public function active(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_active' => true,
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Indicate that the site is a UNESCO site.
     */
    public function unesco(): static
    {
        return $this->state(fn(array $attributes) => [
            'unesco_site' => true,
        ]);
    }

    /**
     * Indicate that the site is historical.
     */
    public function historical(): static
    {
        return $this->state(fn(array $attributes) => [
            'site_type' => 'historical',
            'sites_theme' => 'Ancient History',
        ]);
    }

    /**
     * Indicate that the site is natural.
     */
    public function natural(): static
    {
        return $this->state(fn(array $attributes) => [
            'site_type' => 'natural',
            'sites_theme' => 'Natural Wonders',
        ]);
    }

    /**
     * Indicate that the site is a museum.
     */
    public function museum(): static
    {
        return $this->state(fn(array $attributes) => [
            'site_type' => 'museum',
            'sites_theme' => 'Art & Culture',
        ]);
    }
}
