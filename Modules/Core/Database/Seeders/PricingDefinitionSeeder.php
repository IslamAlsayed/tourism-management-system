<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Core\Entities\PricingDefinition;

class PricingDefinitionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $definitions = [
            [
                'key' => 'per_person',
                'name' => 'Per Person',
                'name_ar' => 'لكل شخص',
                'category' => 'pricing_unit',
            ],
            [
                'key' => 'per_day',
                'name' => 'Per Day',
                'name_ar' => 'لكل يوم',
                'category' => 'pricing_unit',
            ],
            [
                'key' => 'fixed',
                'name' => 'Fixed Price',
                'name_ar' => 'سعر ثابت',
                'category' => 'pricing_type',
            ],
            [
                'key' => 'per_group',
                'name' => 'Per Group',
                'name_ar' => 'لكل مجموعة',
                'category' => 'pricing_unit',
            ],
            [
                'key' => 'per_trip',
                'name' => 'Per Trip',
                'name_ar' => 'لكل رحلة',
                'category' => 'pricing_unit',
            ],
            [
                'key' => 'per_km',
                'name' => 'Per KM',
                'name_ar' => 'لكل كيلومتر',
                'category' => 'pricing_unit',
            ],
            // Site Types
            [
                'key' => 'natural',
                'name' => 'Natural',
                'name_ar' => 'طبيعي',
                'category' => 'site_type',
            ],
            [
                'key' => 'historical',
                'name' => 'Historical',
                'name_ar' => 'تاريخي',
                'category' => 'site_type',
            ],
            [
                'key' => 'cultural',
                'name' => 'Cultural',
                'name_ar' => 'ثقافي',
                'category' => 'site_type',
            ],
            // Site Categories
            [
                'key' => 'landmark',
                'name' => 'Landmark',
                'name_ar' => 'معلم سياحي',
                'category' => 'site_category',
            ],
            [
                'key' => 'museum',
                'name' => 'Museum',
                'name_ar' => 'متحف',
                'category' => 'site_category',
            ],
            [
                'key' => 'park',
                'name' => 'Park',
                'name_ar' => 'منتزه',
                'category' => 'site_category',
            ],
            // Supplier Types
            [
                'key' => 'government',
                'name' => 'Government',
                'name_ar' => 'حكومي',
                'category' => 'supplier_type',
            ],
            [
                'key' => 'private',
                'name' => 'Private',
                'name_ar' => 'خاص',
                'category' => 'supplier_type',
            ],
            // Themes
            [
                'key' => 'romance',
                'name' => 'Romance',
                'name_ar' => 'رومانسي',
                'category' => 'site_theme',
            ],
            [
                'key' => 'family',
                'name' => 'Family',
                'name_ar' => 'عائلي',
                'category' => 'site_theme',
            ],
        ];

        foreach ($definitions as $def) {
            PricingDefinition::updateOrCreate(
                ['key' => $def['key']],
                array_merge($def, [
                    'uuid' => (string) Str::uuid(),
                    'is_active' => true,
                ])
            );
        }
    }
}
