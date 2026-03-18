<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class MixjoFixDatabase extends Command
{
    protected $signature = 'mixjo:fix-db';
    protected $description = 'Safely creates missing tables and columns without breaking existing data.';

    public function handle()
    {
        $this->info("🛠️ Scanning and Fixing Missing Database Structures...");

        // 1. Fix CRM Clients "role"
        if (Schema::hasTable('clients') && !Schema::hasColumn('clients', 'role')) {
            Schema::table('clients', function (Blueprint $table) {
                $table->string('role')->default('client');
            });
            $this->info("✅ Added 'role' column to 'clients'");
        }

        // 2. Fix Core Users "role"
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('admin');
            });
            $this->info("✅ Added 'role' column to 'users'");
        }

        // 3. Create missing 'companies' table for Transportation Module
        if (!Schema::hasTable('companies')) {
            Schema::create('companies', function (Blueprint $table) {
                $table->id();
                $table->uuid('uuid')->unique();
                $table->string('name_en');
                $table->string('name_ar')->nullable();
                $table->string('email')->nullable();
                $table->string('phone')->nullable();
                $table->string('website')->nullable();
                
                // Geography foreign keys
                $table->foreignId('country_id')->nullable()->constrained('countries')->nullOnDelete();
                $table->foreignId('state_id')->nullable()->constrained('states')->nullOnDelete();
                $table->foreignId('city_id')->nullable()->constrained('cities')->nullOnDelete();
                
                $table->text('address')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
                $table->softDeletes();
            });
            $this->info("✅ Created missing 'companies' table.");
        }

        // 4. Create missing 'site_holidays' table
        if (!Schema::hasTable('site_holidays')) {
            Schema::create('site_holidays', function (Blueprint $table) {
                $table->id();
                $table->foreignId('tourist_site_id')->constrained()->cascadeOnDelete();
                $table->date('holiday_date');
                $table->string('name')->nullable();
                $table->timestamps();
            });
            $this->info("✅ Created missing 'site_holidays' table.");
        }
        
        // 5. Create missing 'jobs' table
        if (!Schema::hasTable('jobs')) {
            Schema::create('jobs', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('queue')->index();
                $table->longText('payload');
                $table->unsignedTinyInteger('attempts');
                $table->unsignedInteger('reserved_at')->nullable();
                $table->unsignedInteger('available_at');
                $table->unsignedInteger('created_at');
            });
            $this->info("✅ Created missing 'jobs' table.");
        }

        // 6. Create missing 'facilities' table for TouristSites
        if (!Schema::hasTable('facilities')) {
            Schema::create('facilities', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('name_ar')->nullable();
                $table->string('icon')->nullable();
                $table->boolean('is_active')->default(true);
                $table->integer('sort_order')->default(0);
                $table->timestamps();
            });
            $this->info("✅ Created missing 'facilities' table.");
        }

        // 7. Create missing 'vehicle_types' table for Transportation
        if (!Schema::hasTable('vehicle_types')) {
            Schema::create('vehicle_types', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('name_ar')->nullable();
                $table->foreignId('company_id')->nullable()->constrained('companies')->nullOnDelete();
                $table->integer('capacity')->nullable();
                $table->text('description')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
                $table->softDeletes();
            });
            $this->info("✅ Created missing 'vehicle_types' table.");
        }

        // 8. Create missing 'routes' table for Transportation
        if (!Schema::hasTable('routes')) {
            Schema::create('routes', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('name_ar')->nullable();
                $table->foreignId('origin_city_id')->nullable()->constrained('cities')->nullOnDelete();
                $table->foreignId('destination_city_id')->nullable()->constrained('cities')->nullOnDelete();
                $table->decimal('distance_km', 10, 2)->nullable();
                $table->integer('duration_minutes')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
                $table->softDeletes();
            });
            $this->info("✅ Created missing 'routes' table.");
        }

        // 9. Create missing 'route_assignments' table for Transportation
        if (!Schema::hasTable('route_assignments')) {
            Schema::create('route_assignments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('route_id')->nullable()->constrained('routes')->cascadeOnDelete();
                $table->foreignId('company_id')->nullable()->constrained('companies')->nullOnDelete();
                $table->foreignId('vehicle_type_id')->nullable()->constrained('vehicle_types')->nullOnDelete();
                $table->time('departure_time')->nullable();
                $table->time('arrival_time')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
                $table->softDeletes();
            });
            $this->info("✅ Created missing 'route_assignments' table.");
        }

        // 10. Add 'name' column to companies if missing (some queries use 'name' not 'name_en')
        if (Schema::hasTable('companies') && !Schema::hasColumn('companies', 'name')) {
            Schema::table('companies', function (Blueprint $table) {
                $table->string('name')->nullable();
            });
            $this->info("✅ Added 'name' column to 'companies'.");
        }

        // 11. Add 'code' column to companies if missing
        if (Schema::hasTable('companies') && !Schema::hasColumn('companies', 'code')) {
            Schema::table('companies', function (Blueprint $table) {
                $table->string('code')->nullable();
            });
            $this->info("✅ Added 'code' column to 'companies'.");
        }

        $this->info("🚀 Database Fix Completed Successfully.");
        return Command::SUCCESS;
    }
}
