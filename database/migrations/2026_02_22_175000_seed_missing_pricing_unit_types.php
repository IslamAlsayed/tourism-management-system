<?php

use Illuminate\Database\Migrations\Migration;
use Modules\Core\Entities\PricingDefinition;

return new class extends Migration
{
    /**
     * Add missing pricing unit types that exist in Tourist Service
     * but not yet in the central pricing_definitions table.
     */
    public function up(): void
    {
        $missingTypes = [
            ['key' => 'per_meal', 'name' => 'Per Meal', 'name_ar' => 'لكل وجبة', 'category' => 'pricing_unit', 'is_active' => true],
            ['key' => 'per_extra_hour_per_vehicle', 'name' => 'Per Extra Hour Per Vehicle', 'name_ar' => 'لكل ساعة إضافية لكل مركبة', 'category' => 'pricing_unit', 'is_active' => true],
            ['key' => 'per_extra_hour_per_child', 'name' => 'Per Extra Hour Per Child', 'name_ar' => 'لكل ساعة إضافية لكل طفل', 'category' => 'pricing_unit', 'is_active' => true],
        ];

        foreach ($missingTypes as $type) {
            // Only create if the key doesn't already exist
            PricingDefinition::firstOrCreate(
                ['key' => $type['key']],
                $type
            );
        }

        // Also ensure the following types exist (from Tourist Service hardcoded list)
        $allServiceTypes = [
            ['key' => 'per_person', 'name' => 'Per Person', 'name_ar' => 'لكل فرد', 'category' => 'pricing_unit', 'is_active' => true],
            ['key' => 'per_group', 'name' => 'Per Group', 'name_ar' => 'لكل مجموعة', 'category' => 'pricing_unit', 'is_active' => true],
            ['key' => 'per_vehicle', 'name' => 'Per Vehicle', 'name_ar' => 'لكل مركبة', 'category' => 'pricing_unit', 'is_active' => true],
            ['key' => 'per_trip', 'name' => 'Per Trip', 'name_ar' => 'لكل رحلة', 'category' => 'pricing_unit', 'is_active' => true],
            ['key' => 'per_person_per_day', 'name' => 'Per Person Per Day', 'name_ar' => 'لكل فرد لكل يوم', 'category' => 'pricing_unit', 'is_active' => true],
            ['key' => 'per_group_per_day', 'name' => 'Per Group Per Day', 'name_ar' => 'لكل مجموعة لكل يوم', 'category' => 'pricing_unit', 'is_active' => true],
            ['key' => 'per_person_per_night', 'name' => 'Per Person Per Night', 'name_ar' => 'لكل فرد لكل ليلة', 'category' => 'pricing_unit', 'is_active' => true],
            ['key' => 'per_group_per_night', 'name' => 'Per Group Per Night', 'name_ar' => 'لكل مجموعة لكل ليلة', 'category' => 'pricing_unit', 'is_active' => true],
            ['key' => 'per_day', 'name' => 'Per Day', 'name_ar' => 'لكل يوم', 'category' => 'pricing_unit', 'is_active' => true],
            ['key' => 'per_night', 'name' => 'Per Night', 'name_ar' => 'لكل ليلة', 'category' => 'pricing_unit', 'is_active' => true],
            ['key' => 'per_unit', 'name' => 'Per Unit', 'name_ar' => 'لكل وحدة', 'category' => 'pricing_unit', 'is_active' => true],
            ['key' => 'per_extra_hour_per_person', 'name' => 'Per Extra Hour Per Person', 'name_ar' => 'لكل ساعة إضافية لكل فرد', 'category' => 'pricing_unit', 'is_active' => true],
            ['key' => 'per_extra_hour_per_group', 'name' => 'Per Extra Hour Per Group', 'name_ar' => 'لكل ساعة إضافية لكل مجموعة', 'category' => 'pricing_unit', 'is_active' => true],
            ['key' => 'per_child', 'name' => 'Per Child', 'name_ar' => 'لكل طفل', 'category' => 'pricing_unit', 'is_active' => true],
            ['key' => 'per_child_per_day', 'name' => 'Per Child Per Day', 'name_ar' => 'لكل طفل لكل يوم', 'category' => 'pricing_unit', 'is_active' => true],
            ['key' => 'per_child_per_night', 'name' => 'Per Child Per Night', 'name_ar' => 'لكل طفل لكل ليلة', 'category' => 'pricing_unit', 'is_active' => true],
        ];

        foreach ($allServiceTypes as $type) {
            PricingDefinition::firstOrCreate(
                ['key' => $type['key']],
                $type
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        PricingDefinition::whereIn('key', [
            'per_meal',
            'per_extra_hour_per_vehicle',
            'per_extra_hour_per_child',
        ])->delete();
    }
};
