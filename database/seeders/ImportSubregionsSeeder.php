<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Geography\Entities\Subregion;

class ImportSubregionsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['id' => 1, 'name' => 'Australia and New Zealand', 'name_ar' => 'أستراليا ونيوزيلندا', 'region_id' => 5, 'wiki_data_id' => 'Q45256'],
            ['id' => 2, 'name' => 'Caribbean', 'name_ar' => 'الكاريبي', 'region_id' => 2, 'wiki_data_id' => 'Q664609'],
            ['id' => 3, 'name' => 'Central America', 'name_ar' => 'أمريكا الوسطى', 'region_id' => 2, 'wiki_data_id' => 'Q27611'],
            ['id' => 4, 'name' => 'Central Asia', 'name_ar' => 'آسيا الوسطى', 'region_id' => 3, 'wiki_data_id' => 'Q27275'],
            ['id' => 5, 'name' => 'Eastern Africa', 'name_ar' => 'شرق أفريقيا', 'region_id' => 1, 'wiki_data_id' => 'Q27407'],
            ['id' => 6, 'name' => 'Eastern Asia', 'name_ar' => 'شرق آسيا', 'region_id' => 3, 'wiki_data_id' => 'Q27231'],
            ['id' => 7, 'name' => 'Eastern Europe', 'name_ar' => 'شرق أوروبا', 'region_id' => 4, 'wiki_data_id' => 'Q27468'],
            ['id' => 8, 'name' => 'Melanesia', 'name_ar' => 'ميلانيزيا', 'region_id' => 5, 'wiki_data_id' => 'Q37394'],
            ['id' => 9, 'name' => 'Micronesia', 'name_ar' => 'ميكرونيزيا', 'region_id' => 5, 'wiki_data_id' => 'Q3359409'],
            ['id' => 10, 'name' => 'Middle Africa', 'name_ar' => 'وسط أفريقيا', 'region_id' => 1, 'wiki_data_id' => 'Q27433'],
            ['id' => 11, 'name' => 'Northern Africa', 'name_ar' => 'شمال أفريقيا', 'region_id' => 1, 'wiki_data_id' => 'Q27381'],
            ['id' => 12, 'name' => 'Northern America', 'name_ar' => 'أمريكا الشمالية', 'region_id' => 2, 'wiki_data_id' => 'Q2017699'],
            ['id' => 13, 'name' => 'Northern Europe', 'name_ar' => 'شمال أوروبا', 'region_id' => 4, 'wiki_data_id' => 'Q27479'],
            ['id' => 14, 'name' => 'Polynesia', 'name_ar' => 'بولينيزيا', 'region_id' => 5, 'wiki_data_id' => 'Q35942'],
            ['id' => 15, 'name' => 'South America', 'name_ar' => 'أمريكا الجنوبية', 'region_id' => 2, 'wiki_data_id' => 'Q18'],
            ['id' => 16, 'name' => 'South-Eastern Asia', 'name_ar' => 'جنوب شرق آسيا', 'region_id' => 3, 'wiki_data_id' => 'Q11708'],
            ['id' => 17, 'name' => 'Southern Africa', 'name_ar' => 'جنوب أفريقيا', 'region_id' => 1, 'wiki_data_id' => 'Q27394'],
            ['id' => 18, 'name' => 'Southern Asia', 'name_ar' => 'جنوب آسيا', 'region_id' => 3, 'wiki_data_id' => 'Q771405'],
            ['id' => 19, 'name' => 'Southern Europe', 'name_ar' => 'جنوب أوروبا', 'region_id' => 4, 'wiki_data_id' => 'Q27449'],
            ['id' => 20, 'name' => 'Western Africa', 'name_ar' => 'غرب أفريقيا', 'region_id' => 1, 'wiki_data_id' => 'Q4412'],
            ['id' => 21, 'name' => 'Western Asia', 'name_ar' => 'غرب آسيا', 'region_id' => 3, 'wiki_data_id' => 'Q27293'],
            ['id' => 22, 'name' => 'Western Europe', 'name_ar' => 'غرب أوروبا', 'region_id' => 4, 'wiki_data_id' => 'Q27496'],
            ['id' => 23, 'name' => 'Middle East', 'name_ar' => 'الشرق الأوسط', 'region_id' => 3, 'wiki_data_id' => 'Q7204'],
        ];

        foreach ($data as $item) {
            Subregion::updateOrCreate(
                ['id' => $item['id']],
                $item
            );
        }
    }
}
