<?php

namespace Modules\Subscriptions\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Subscriptions\Entities\Module;

class ModulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define core modules (always available, cannot be disabled)
        $coreModules = [
            [
                'key' => 'core',
                'name' => 'النظام الأساسي',
                'description' => 'إدارة المستخدمين والأدوار والصلاحيات',
                'icon' => 'fa-solid fa-shield',
                'requires' => null,
                'is_core' => true,
                'is_available' => true,
                'sort_order' => 1,
            ],
            [
                'key' => 'geography',
                'name' => 'الجغرافيا',
                'description' => 'إدارة الدول والمدن والمواقع',
                'icon' => 'fa-solid fa-earth-africa',
                'requires' => null,
                'is_core' => true,
                'is_available' => true,
                'sort_order' => 2,
            ],
            [
                'key' => 'localization',
                'name' => 'اللغات',
                'description' => 'إدارة اللغات والترجمات',
                'icon' => 'fa-solid fa-language',
                'requires' => null,
                'is_core' => true,
                'is_available' => true,
                'sort_order' => 3,
            ],
        ];

        // Get paid modules from config
        $configModules = config('subscriptions.available_modules', []);

        $paidModules = [];
        $sortOrder = 10; // Start paid modules from 10

        foreach ($configModules as $key => $module) {
            $paidModules[] = [
                'key' => $key,
                'name' => $module['name'],
                'description' => $module['description'],
                'icon' => $module['icon'],
                'requires' => !empty($module['requires']) ? $module['requires'] : null,
                'is_core' => false,
                'is_available' => true,
                'sort_order' => $sortOrder++,
            ];
        }

        // Insert all modules
        $allModules = array_merge($coreModules, $paidModules);

        foreach ($allModules as $moduleData) {
            Module::updateOrCreate(
                ['key' => $moduleData['key']],
                $moduleData
            );
        }

        $this->command->info('✅ Modules seeded successfully!');
        $this->command->info('   - Core modules: ' . count($coreModules));
        $this->command->info('   - Paid modules: ' . count($paidModules));
    }
}
