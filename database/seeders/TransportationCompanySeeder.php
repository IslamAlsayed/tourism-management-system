<?php

namespace Database\Seeders;

use App\Models\Season;
use App\Models\RichText;
use App\Models\Supplement;
use Illuminate\Database\Seeder;
use App\Models\PricingDefinition;
use App\Models\TransportationCompany;
use App\Models\TransportationCompanyContact;
use App\Models\TransportationPricing;
use Illuminate\Support\Facades\Schema;
use App\Models\TransportationVehicleType;

class TransportationCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // حذف بيانات شركات المواصلات القديمة
        Schema::disableForeignKeyConstraints();
        PricingDefinition::truncate();
        RichText::where('record_type', PricingDefinition::class)->delete();
        TransportationCompany::truncate();
        RichText::where('record_type', TransportationCompany::class)->delete();
        TransportationCompanyContact::truncate();
        RichText::where('record_type', TransportationCompanyContact::class)->delete();
        TransportationVehicleType::truncate();
        RichText::where('record_type', TransportationVehicleType::class)->delete();
        TransportationPricing::truncate();
        RichText::where('record_type', TransportationPricing::class)->delete();
        Schema::enableForeignKeyConstraints();

        // تعريفات التسعير
        $pricingDefinitions = [
            ['key' => 'per_person', 'name' => 'Per Person', 'name_ar' => 'لكل فرد', 'category' => 'pricing_unit', 'is_active' => true],
            ['key' => 'per_vehicle', 'name' => 'Per Vehicle', 'name_ar' => 'لكل مركبة', 'category' => 'pricing_unit', 'is_active' => true],
            ['key' => 'per_day', 'name' => 'Per Day', 'name_ar' => 'لكل يوم', 'category' => 'pricing_unit', 'is_active' => true],
            ['key' => 'per_trip', 'name' => 'Per Trip', 'name_ar' => 'لكل رحلة', 'category' => 'pricing_unit', 'is_active' => true],
            ['key' => 'per_distance', 'name' => 'Per Distance', 'name_ar' => 'لكل مسافة', 'category' => 'pricing_unit', 'is_active' => true],
            ['key' => 'per_program', 'name' => 'Per Program', 'name_ar' => 'لكل برنامج', 'category' => 'pricing_unit', 'is_active' => true],
        ];
        foreach ($pricingDefinitions as $def) {
            PricingDefinition::create($def);
        }

        // شركات المواصلات المصرية والأردنية
        $companies = [
            ['name' => 'Egypt Transport Company', 'name_ar' => 'شركة مصر للنقل السياحي', 'country_id' => 1, 'phone' => '+20212345678', 'email' => 'info@egypt-transport.com'],
            ['name' => 'Jordan Transport Company', 'name_ar' => 'شركة الأردن للنقل السياحي', 'country_id' => 2, 'phone' => '+96212345678', 'email' => 'info@jordan-transport.com'],
            ['name' => 'Nile Transport Company', 'name_ar' => 'شركة النيل للنقل السياحي', 'country_id' => 1, 'phone' => '+20287654321', 'email' => 'info@nile-transport.com'],
            ['name' => 'Cairo Transport Company', 'name_ar' => 'شركة القاهرة للنقل السياحي', 'country_id' => 1, 'phone' => '+20211223344', 'email' => 'info@cairo-transport.com'],
            ['name' => 'Amman Transport Company', 'name_ar' => 'شركة عمان للنقل السياحي', 'country_id' => 2, 'phone' => '+96287654321', 'email' => 'info@amman-transport.com'],
            ['name' => 'Petra Transport Company', 'name_ar' => 'شركة البتراء للنقل السياحي', 'country_id' => 2, 'phone' => '+96211223344', 'email' => 'info@petra-transport.com'],
            ['name' => 'Alexandria Transport Company', 'name_ar' => 'شركة الإسكندرية للنقل السياحي', 'country_id' => 1, 'phone' => '+20233445566', 'email' => 'info@alex-transport.com'],
        ];
        foreach ($companies as $company) {
            TransportationCompany::factory()->create($company);
        }

        // جهات اتصال شركات المواصلات
        $contacts = [
            ['company_id' => TransportationCompany::inRandomOrder()->first()?->id, 'contact_person' => fake()->name(), 'email' => fake()->unique()->safeEmail(), 'phone' => fake()->phoneNumber(), 'mobile' => fake()->phoneNumber(), 'fax' => fake()->phoneNumber()],
            ['company_id' => TransportationCompany::inRandomOrder()->first()?->id, 'contact_person' => fake()->name(), 'email' => fake()->unique()->safeEmail(), 'phone' => fake()->phoneNumber(), 'mobile' => fake()->phoneNumber(), 'fax' => fake()->phoneNumber()],
            ['company_id' => TransportationCompany::inRandomOrder()->first()?->id, 'contact_person' => fake()->name(), 'email' => fake()->unique()->safeEmail(), 'phone' => fake()->phoneNumber(), 'mobile' => fake()->phoneNumber(), 'fax' => fake()->phoneNumber()],
            ['company_id' => TransportationCompany::inRandomOrder()->first()?->id, 'contact_person' => fake()->name(), 'email' => fake()->unique()->safeEmail(), 'phone' => fake()->phoneNumber(), 'mobile' => fake()->phoneNumber(), 'fax' => fake()->phoneNumber()],
            ['company_id' => TransportationCompany::inRandomOrder()->first()?->id, 'contact_person' => fake()->name(), 'email' => fake()->unique()->safeEmail(), 'phone' => fake()->phoneNumber(), 'mobile' => fake()->phoneNumber(), 'fax' => fake()->phoneNumber()],
            ['company_id' => TransportationCompany::inRandomOrder()->first()?->id, 'contact_person' => fake()->name(), 'email' => fake()->unique()->safeEmail(), 'phone' => fake()->phoneNumber(), 'mobile' => fake()->phoneNumber(), 'fax' => fake()->phoneNumber()],
            ['company_id' => TransportationCompany::inRandomOrder()->first()?->id, 'contact_person' => fake()->name(), 'email' => fake()->unique()->safeEmail(), 'phone' => fake()->phoneNumber(), 'mobile' => fake()->phoneNumber(), 'fax' => fake()->phoneNumber()],
            ['company_id' => TransportationCompany::inRandomOrder()->first()?->id, 'contact_person' => fake()->name(), 'email' => fake()->unique()->safeEmail(), 'phone' => fake()->phoneNumber(), 'mobile' => fake()->phoneNumber(), 'fax' => fake()->phoneNumber()],
            ['company_id' => TransportationCompany::inRandomOrder()->first()?->id, 'contact_person' => fake()->name(), 'email' => fake()->unique()->safeEmail(), 'phone' => fake()->phoneNumber(), 'mobile' => fake()->phoneNumber(), 'fax' => fake()->phoneNumber()],
        ];
        foreach ($contacts as $contact) {
            $contact['department'] = fake()->randomElement(['commercial manager', 'general manager', 'reservation department', 'Accounting manager', 'reservation DEP', 'reservation - sales', 'operation manager', 'Sales reservation', 'reservation manager', 'reservation mange']);
            TransportationCompanyContact::factory()->create($contact);
        }

        // أنواع المركبات المصرية والأردنية
        $vehicleTypes = [
            ['name' => 'Tourist Bus', 'name_ar' => 'اتوبيس سياحي', 'min_capacity' => 20, 'max_capacity' => 50, 'has_luggage' => fake()->boolean(70), 'is_air_conditioning' => fake()->boolean(80), 'is_active' => true, 'company_id' => TransportationCompany::inRandomOrder()->first()?->id],
            ['name' => 'Microbus', 'name_ar' => 'ميكروباص', 'min_capacity' => 8, 'max_capacity' => 14, 'has_luggage' => fake()->boolean(70), 'is_air_conditioning' => fake()->boolean(80), 'is_active' => true, 'company_id' => TransportationCompany::inRandomOrder()->first()?->id],
            ['name' => 'Limousine', 'name_ar' => 'ليموزين', 'min_capacity' => 2, 'max_capacity' => 4, 'has_luggage' => fake()->boolean(70), 'is_air_conditioning' => fake()->boolean(80), 'is_active' => true, 'company_id' => TransportationCompany::inRandomOrder()->first()?->id],
            ['name' => 'Tourist Coach', 'name_ar' => 'حافلة سياحية', 'min_capacity' => 30, 'max_capacity' => 55, 'has_luggage' => fake()->boolean(70), 'is_air_conditioning' => fake()->boolean(80), 'is_active' => true, 'company_id' => TransportationCompany::inRandomOrder()->first()?->id],
            ['name' => 'Van', 'name_ar' => 'سيارة فان', 'min_capacity' => 6, 'max_capacity' => 12, 'has_luggage' => fake()->boolean(70), 'is_air_conditioning' => fake()->boolean(80), 'is_active' => true, 'company_id' => TransportationCompany::inRandomOrder()->first()?->id],
            ['name' => 'Limousine', 'name_ar' => 'ليموزين', 'min_capacity' => 2, 'max_capacity' => 4, 'has_luggage' => fake()->boolean(70), 'is_air_conditioning' => fake()->boolean(80), 'is_active' => true, 'company_id' => TransportationCompany::inRandomOrder()->first()?->id],
        ];
        foreach ($vehicleTypes as $type) {
            TransportationVehicleType::create($type);
        }

        // For each transportation company, create its related data
        $transportationCompany = TransportationCompany::all();
        foreach ($transportationCompany as $company) {
            // Create 2-3 seasons for this transportation company
            $seasonNames = [
                ['name' => 'Spring Season', 'name_ar' => 'موسم الربيع', 'from' => '2025-03-01', 'to' => '2025-05-31'],
                ['name' => 'Autumn Season', 'name_ar' => 'موسم الخريف', 'from' => '2025-09-01', 'to' => '2025-11-30'],
                ['name' => 'Ramadan Season', 'name_ar' => 'موسم رمضان', 'from' => '2025-03-28', 'to' => '2025-04-27'],
                ['name' => 'Hajj Season', 'name_ar' => 'موسم الحج', 'from' => '2025-06-25', 'to' => '2025-07-05'],
                ['name' => 'New Year Season', 'name_ar' => 'موسم رأس السنة', 'from' => '2025-12-28', 'to' => '2026-01-03'],
                ['name' => 'Back to School Season', 'name_ar' => 'موسم العودة للمدارس', 'from' => '2025-08-20', 'to' => '2025-09-10'],
                ['name' => 'Mid-Year Season', 'name_ar' => 'موسم منتصف العام', 'from' => '2025-01-15', 'to' => '2025-01-30'],
            ];
            $selectedSeasons = collect($seasonNames)->random(rand(3, 5));
            foreach ($selectedSeasons as $seasonData) {
                Season::create([
                    'name' => $seasonData['name'],
                    'name_ar' => $seasonData['name_ar'],
                    'season_from' => $seasonData['from'],
                    'season_to' => $seasonData['to'],
                    'is_active' => true,
                    'notes' => 'Applicable for ' . $company->name,
                    'model_id' => $company->id,
                    'model_type' => get_class($company),
                ]);
            }


            // Create 2-3 supplements for this transportation company
            $supplementNames = [
                ['name' => 'Sea View Upgrade', 'name_ar' => 'ترقية إطلالة على البحر'],
                ['name' => 'Extra Luggage', 'name_ar' => 'أمتعة إضافية'],
                ['name' => 'Priority Boarding', 'name_ar' => 'الصعود الأولوية'],
                ['name' => 'In-Vehicle WiFi', 'name_ar' => 'واي فاي داخل المركبة'],
                ['name' => 'Child Seat', 'name_ar' => 'مقعد طفل'],
                ['name' => 'Luxury Package', 'name_ar' => 'حزمة فاخرة'],
                ['name' => 'Guided Tour', 'name_ar' => 'جولة مع مرشد'],
            ];
            $selectedSupplements = collect($supplementNames)->random(rand(3, 5));
            foreach ($selectedSupplements as $supplementData) {
                Supplement::create([
                    'name' => $supplementData['name'],
                    'name_ar' => $supplementData['name_ar'],
                    'price' => rand(10, 200),
                    'price_type' => fake()->randomElement(['per_person', 'per_room', 'per_night', 'one_time']),
                    'is_mandatory' => rand(0, 1) == 1,
                    'is_active' => true,
                    'notes' => 'Supplement for ' . $company->name,
                    'model_id' => $company->id,
                    'model_type' => get_class($company),
                ]);
            }

            // أسعار شركات المواصلات
            $vehicleType = TransportationVehicleType::where('company_id', $company->id)->inRandomOrder()->first()
                ?? TransportationVehicleType::inRandomOrder()->first();

            if ($vehicleType) {
                TransportationPricing::factory()->create([
                    'price' => fake()->numberBetween(900, 4000),
                    'company_id' => $company->id,
                    'vehicle_type_id' => $vehicleType->id,
                    'season_id' => Season::where('model_type', 'like', '%ransportation%')->where('model_id', $company->id)->first()?->id ?? null,
                    'pricing_unit_id' => PricingDefinition::inRandomOrder()->first()?->id ?? PricingDefinition::factory(),
                ]);
            }
        }
    }
}