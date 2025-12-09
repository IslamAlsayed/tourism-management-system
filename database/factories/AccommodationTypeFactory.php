<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AccommodationType>
 */
class AccommodationTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['Hotel', 'Resort', 'Aparthotel', 'Apartment', 'Villa', 'Guest houses', 'Condominium resort', 'Chalet', 'Private vacation home', 'Houseboat', 'Hostel', 'Camping', 'Luxury tents', 'Safari stays', 'Country house', 'Motel', 'Farm', 'Pension', 'Private holiday home', 'Cruise', 'Lodge', 'Bedouin camps', 'Nile Floating hotels/boats', 'Heritage House'];
        $typesAr = ['فندق', 'منتجع', 'شقة فندقية', 'شقة سياحية', 'فيلا', 'دار الضيافة', 'كومباوند منتجع', 'شاليه', 'منزل خاص', 'قارب سكني', 'هوستل', 'مخيم/كامب', 'خيمة فاخرة', 'إقامة سفاري', 'بيت ريفي', 'موتيل', 'إقامة مزرعة', 'بنسيون', 'منزل عطلة خاص', 'مركب بحرية', 'نُزُل ', 'المخيمات البدوية', 'المنتجعات العائمة', 'بيت شعبي تراثي'];

        $index = fake()->unique()->numberBetween(0, count($types) - 1);

        return [
            'name' => $types[$index],
            'name_ar' => $typesAr[$index],
            'description' => fake()->paragraph(3),
            'is_active' => fake()->boolean(90),
        ];
    }
}