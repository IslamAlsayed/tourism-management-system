<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\User;
use App\Models\State;
use App\Models\Region;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Subregion;
use App\Models\TouristService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TouristService>
 */
class TouristServiceFactory extends Factory
{
    protected $model = TouristService::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Location information
            'currency_id' => Currency::inRandomOrder()->first()?->id,
            'region_id' => Region::inRandomOrder()->first()?->id,
            'subregion_id' => Subregion::inRandomOrder()->first()?->id,
            'country_id' => Country::inRandomOrder()->first()?->id,
            'state_id' => State::inRandomOrder()->first()?->id,
            'city_id' => City::inRandomOrder()->first()?->id,

            // Basic Information
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
                'Nature Conservation Area'
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
                'منطقة المحافظة على الطبيعة'
            ]),
            'description' => $this->faker->paragraphs(3, true),
            'site_type' => $this->faker->randomElement(['historical', 'natural', 'cultural', 'religious', 'recreational', 'archaeological', 'museum', 'park', 'other']),
            'category' => $this->faker->randomElement(['monument', 'landmark', 'attraction', 'site', 'facility']),

            // Geographical Details
            'address' => $this->faker->address(),
            'latitude' => $this->faker->latitude(20, 35),
            'longitude' => $this->faker->longitude(25, 55),
            'postal_code' => $this->faker->optional(0.6)->postcode(),

            // Entry Information
            'entry_fee_adult' => $this->faker->randomFloat(2, 0, 50),
            'entry_fee_child' => $this->faker->randomFloat(2, 0, 25),
            'entry_fee_student' => $this->faker->randomFloat(2, 0, 35),
            'entry_fee_senior' => $this->faker->randomFloat(2, 0, 40),
            'entry_fee_group' => $this->faker->randomFloat(2, 0, 200),
            'is_free_entry' => $this->faker->boolean(30),

            // Operating Hours
            'opening_time' => $this->faker->time('H:i', '10:00'),
            'closing_time' => $this->faker->time('H:i', '20:00'),
            'operating_days' => $this->faker->randomElements([1, 2, 3, 4, 5, 6, 7], $this->faker->numberBetween(3, 7)),
            'special_hours' => $this->faker->optional(0.3)->randomElement([
                [['holiday' => 'Ramadan', 'hours' => '14:00-22:00']],
                [['holiday' => 'Eid', 'hours' => 'Closed']],
                [['holiday' => 'National Day', 'hours' => '08:00-24:00']]
            ]),
            'is_24_hours' => $this->faker->boolean(5), // 5% chance of being 24 hours

            // Contact Information
            'phone' => $this->faker->optional(0.8)->phoneNumber(),
            'mobile' => $this->faker->optional(0.6)->phoneNumber(),
            'email' => $this->faker->optional(0.7)->safeEmail(),
            'website_url' => $this->faker->optional(0.6)->url(),
            'facebook_url' => $this->faker->optional(0.4)->url(),
            'instagram_url' => $this->faker->optional(0.3)->url(),
            'twitter_url' => $this->faker->optional(0.2)->url(),

            // Facilities
            'wheelchair_accessible' => $this->faker->boolean(70),
            'free_wifi' => $this->faker->boolean(70),
            'parking' => $this->faker->boolean(70),
            'restrooms' => $this->faker->boolean(70),
            'restaurants' => $this->faker->boolean(70),
            'gift_shop' => $this->faker->boolean(70),
            'guided_tours' => $this->faker->boolean(70),
            'audio_guide' => $this->faker->boolean(70),

            // Activities
            'photography' => $this->faker->boolean(70),
            'hiking' => $this->faker->boolean(70),
            'swimming' => $this->faker->boolean(70),
            'camping' => $this->faker->boolean(70),
            'shopping' => $this->faker->boolean(70),
            'dining' => $this->faker->boolean(70),
            'entertainment' => $this->faker->boolean(70),
            'educational_tours' => $this->faker->boolean(70),

            // Services
            'translation' => $this->faker->boolean(70),
            'special_events' => $this->faker->boolean(70),
            'group_bookings' => $this->faker->boolean(70),
            'online_booking' => $this->faker->boolean(70),
            'mobile_app' => $this->faker->boolean(70),
            'virtual_tours' => $this->faker->boolean(70),

            // Accessibility & Amenities
            'has_parking' => $this->faker->boolean(70),
            'has_restaurant' => $this->faker->boolean(50),
            'has_gift_shop' => $this->faker->boolean(60),
            'has_restrooms' => $this->faker->boolean(90),

            // Media & Resources
            'main_image' => $this->faker->optional(0.8)->imageUrl(800, 600, 'nature'),
            'gallery_images' => $this->faker->optional(0.6)->randomElements([
                $this->faker->imageUrl(600, 400, 'nature'),
                $this->faker->imageUrl(600, 400, 'architecture'),
                $this->faker->imageUrl(600, 400, 'people'),
                $this->faker->imageUrl(600, 400, 'city'),
                $this->faker->imageUrl(600, 400, 'business'),
                $this->faker->imageUrl(600, 400, 'abstract')
            ], $this->faker->numberBetween(2, 5)),
            'video_url' => $this->faker->optional(0.2)->url(),
            'virtual_tour_url' => $this->faker->optional(0.1)->url(),

            // Ratings & Reviews
            'rating' => $this->faker->randomFloat(2, 2.5, 5.0),
            'total_reviews' => $this->faker->numberBetween(5, 500),
            'popularity_score' => $this->faker->numberBetween(1, 100),

            // Visitor Information
            'estimated_visit_duration' => $this->faker->numberBetween(30, 360), // 30 minutes to 6 hours
            'difficulty_level' => $this->faker->randomElement(['easy', 'moderate', 'challenging', 'extreme']),
            'age_restrictions' => $this->faker->optional(0.2)->randomElement([['min_age' => 12], ['max_age' => 65], ['requires_guardian' => true]]),
            'best_visit_time' => $this->faker->randomElements(['spring', 'summer', 'autumn', 'winter', 'morning', 'afternoon', 'evening'], $this->faker->numberBetween(1, 4)),

            // Administrative
            'status' => $this->faker->randomElement(['active', 'inactive', 'maintenance', 'permanently_closed']),
            'is_featured' => $this->faker->boolean(20), // 20% chance of being featured
            'is_verified' => $this->faker->boolean(80), // 80% chance of being verified
            'notes' => $this->faker->optional(0.4)->paragraph(),
            'tags' => $this->faker->randomElements(['family-friendly', 'historical', 'cultural', 'adventure', 'educational', 'romantic', 'photography', 'architecture', 'nature', 'spiritual', 'art', 'science', 'technology', 'traditional', 'modern'], $this->faker->numberBetween(2, 5)),

            // Tracking
            'created_by' => User::inRandomOrder()->first()?->id ?? 1,
            'updated_by' => 2,
            'created_at' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'updated_at' => now(),
        ];
    }

    /**
     * Indicate that the tourist site is active.
     */
    public function active(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'active',
        ]);
    }

    /**
     * Indicate that the tourist site is featured.
     */
    public function featured(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_featured' => true,
        ]);
    }

    /**
     * Indicate that the tourist site has free entry.
     */
    public function freeEntry(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_free_entry' => true,
            'entry_fee_adult' => 0,
            'entry_fee_child' => 0,
            'entry_fee_student' => 0,
            'entry_fee_senior' => 0,
            'entry_fee_group' => 0,
        ]);
    }

    /**
     * Indicate that the tourist site is historical site_type.
     */
    public function historical(): static
    {
        return $this->state(fn(array $attributes) => [
            'site_type' => 'historical',
            'category' => 'monument',
        ]);
    }

    /**
     * Indicate that the tourist site is natural site_type.
     */
    public function natural(): static
    {
        return $this->state(fn(array $attributes) => [
            'site_type' => 'natural',
            'category' => 'attraction',
        ]);
    }

    /**
     * Indicate that the tourist site is a museum.
     */
    public function museum(): static
    {
        return $this->state(fn(array $attributes) => [
            'site_type' => 'museum',
            'category' => 'facility',
            'has_gift_shop' => true,
            'wheelchair_accessible' => true,
        ]);
    }
}