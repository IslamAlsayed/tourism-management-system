<?php

namespace Database\Factories;

use Modules\Geography\Entities\City;
use Modules\Tourists\Entities\TouristSite;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Tourists\Entities\TouristSite>
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
            // ========== Basic Information ==========
            'code' => strtoupper($this->faker->unique()->bothify('TS-##??')),
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
            'category' => $this->faker->randomElement(['Landmark', 'Museum', 'Park', 'Beach', 'Monument', 'Temple', 'Palace', 'Garden']),
            'unesco_site' => $this->faker->boolean(20),
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
            'sort_order' => $this->faker->numberBetween(0, 100),

            // ========== Location Information ==========
            'city_id' => City::inRandomOrder()->first()?->id ?? 1,
            'address' => $this->faker->address(),
            'latitude' => $this->faker->latitude(20, 35),
            'longitude' => $this->faker->longitude(25, 40),
            'postal_code' => $this->faker->postcode(),

            // ========== Entry Fees ==========
            'entry_fee_adult' => $this->faker->randomFloat(2, 5, 50),
            'entry_fee_child' => $this->faker->randomFloat(2, 2, 25),
            'entry_fee_student' => $this->faker->randomFloat(2, 2, 30),
            'entry_fee_senior' => $this->faker->randomFloat(2, 2, 30),
            'entry_fee_group' => $this->faker->randomFloat(2, 10, 100),
            'is_free_entry' => $this->faker->boolean(10),
            'entry_fee_foreigner_adult' => $this->faker->randomFloat(2, 15, 100),
            'entry_fee_foreigner_child' => $this->faker->randomFloat(2, 5, 50),
            'entry_fee_arab_adult' => $this->faker->randomFloat(2, 10, 60),
            'entry_fee_arab_child' => $this->faker->randomFloat(2, 3, 30),
            'entry_fee_local_adult' => $this->faker->randomFloat(2, 3, 15),
            'entry_fee_local_child' => $this->faker->randomFloat(2, 1, 10),
            'entry_fee_resident_adult' => $this->faker->randomFloat(2, 2, 10),
            'entry_fee_resident_child' => $this->faker->randomFloat(2, 1, 5),

            // ========== Operating Hours ==========
            'opening_time' => $this->faker->time('H:i'),
            'closing_time' => $this->faker->time('H:i'),
            'operating_days' => json_encode(['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']),
            'special_hours' => json_encode(['Holiday' => '09:00-14:00']),
            'is_24_7' => $this->faker->boolean(5),

            // ========== Contact Information ==========
            'phone' => $this->faker->phoneNumber(),
            'mobile' => $this->faker->phoneNumber(),
            'email' => $this->faker->safeEmail(),
            'website_url' => $this->faker->url(),
            'facebook_url' => 'https://facebook.com/' . $this->faker->slug(),
            'instagram_url' => 'https://instagram.com/' . $this->faker->slug(),
            'twitter_url' => 'https://twitter.com/' . $this->faker->slug(),
            'fax' => $this->faker->phoneNumber(),
            'contact_person' => $this->faker->name(),

            // ========== Facilities & Services ==========
            'wheelchair_accessible' => $this->faker->boolean(80),
            'free_wifi' => $this->faker->boolean(70),
            'parking' => $this->faker->boolean(85),
            'restrooms' => $this->faker->boolean(90),
            'restaurants' => $this->faker->boolean(60),
            'gift_shop' => $this->faker->boolean(65),
            'guided_tours' => $this->faker->boolean(75),
            'audio_guide' => $this->faker->boolean(50),
            'photography' => $this->faker->boolean(95),
            'hiking' => $this->faker->boolean(40),
            'swimming' => $this->faker->boolean(30),
            'camping' => $this->faker->boolean(25),
            'shopping' => $this->faker->boolean(50),
            'dining' => $this->faker->boolean(60),
            'entertainment' => $this->faker->boolean(55),
            'educational_tours' => $this->faker->boolean(70),
            'translation' => $this->faker->boolean(60),
            'special_events' => $this->faker->boolean(50),
            'group_bookings' => $this->faker->boolean(80),
            'online_booking' => $this->faker->boolean(75),
            'mobile_app' => $this->faker->boolean(40),
            'virtual_tours' => $this->faker->boolean(35),

            // ========== Additional Pricing ==========
            'local_guide_price' => $this->faker->randomFloat(2, 20, 100),
            'club_car_price' => $this->faker->randomFloat(2, 50, 300),
            'has_unified_ticket' => $this->faker->boolean(40),

            // ========== Media & Content ==========
            'photo' => "https://picsum.photos/seed/" . rand(1, 1000) . "/400/300",
            'gallery' => json_encode(array_map(
                fn() => "https://picsum.photos/seed/" . rand(1, 1000) . "/300/300",
                range(1, rand(3, 10))
            )),
            'video_url' => $this->faker->url(),
            'virtual_tour_url' => $this->faker->url(),

            // ========== Visitor Information ==========
            'nearby_attractions' => $this->faker->paragraph(),
            'average_rating' => $this->faker->randomFloat(2, 3.0, 5.0),
            'total_reviews' => $this->faker->numberBetween(0, 1000),
            'popularity_score' => $this->faker->numberBetween(0, 100),
            'estimated_visit_duration' => $this->faker->numberBetween(30, 480),
            'difficulty_level' => $this->faker->randomElement(['easy', 'moderate', 'difficult', 'very difficult']),
            'age_restrictions' => json_encode(['min_age' => 0, 'max_age' => null]),
            'best_visit_time' => json_encode(['months' => ['October', 'November', 'December', 'January', 'February', 'March']]),

            // ========== Status & Metadata ==========
            'status' => $this->faker->randomElement(['active', 'maintenance', 'closed']),
            'is_active' => $this->faker->boolean(85),
            'is_featured' => $this->faker->boolean(20),
            'is_verified' => $this->faker->boolean(70),
            'tags' => json_encode(['tourist', 'historical', 'popular']),

            // ========== Description & Notes ==========
            'description' => $this->faker->paragraphs(3, true),
            'notes' => $this->faker->paragraph(),

            // ========== Timestamps ==========
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
