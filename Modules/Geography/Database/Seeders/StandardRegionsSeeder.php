<?php

namespace Modules\Geography\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Geography\Entities\Region;

class StandardRegionsSeeder extends Seeder
{
    public function run()
    {
        $regions = [
            ['id' => 1, 'name' => 'Africa', 'name_ar' => 'أفريقيا', 'is_active' => true],
            ['id' => 2, 'name' => 'Americas', 'name_ar' => 'الأمريكتان', 'is_active' => true],
            ['id' => 3, 'name' => 'Asia', 'name_ar' => 'آسيا', 'is_active' => true],
            ['id' => 4, 'name' => 'Europe', 'name_ar' => 'أوروبا', 'is_active' => true],
            ['id' => 5, 'name' => 'Oceania', 'name_ar' => 'أوقيانوسيا', 'is_active' => true],
        ];

        foreach ($regions as $regionData) {
            Region::updateOrCreate(
                ['id' => $regionData['id']],
                $regionData
            );
        }
    }
}
