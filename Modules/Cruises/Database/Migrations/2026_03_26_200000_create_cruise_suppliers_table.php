<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cruise_suppliers', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('company_id')->index(); // Tenant isolation

            $table->string('name');
            $table->string('name_ar')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();

            // Geographic
            $table->unsignedBigInteger('region_id')->nullable()->index();
            $table->unsignedBigInteger('subregion_id')->nullable()->index();
            $table->unsignedBigInteger('country_id')->nullable()->index();
            $table->unsignedBigInteger('state_id')->nullable()->index();
            $table->unsignedBigInteger('city_id')->nullable()->index();
            
            // Operational Bounds
            $table->unsignedBigInteger('main_start_point_id')->nullable()->index()->comment('Origin/Start Point (e.g., City or Port)');
            $table->unsignedBigInteger('main_end_point_id')->nullable()->index()->comment('Destination/End Point');
            
            $table->text('address')->nullable();

            // Business type
            $table->enum('type', ['ship_owner', 'broker', 'agency', 'operator'])->default('ship_owner');

            // Commercial terms
            $table->decimal('default_commission_rate', 5, 2)->nullable()->comment('Default commission % from supplier');
            $table->text('payment_terms')->nullable();
            $table->date('contract_start_date')->nullable();
            $table->date('contract_end_date')->nullable();

            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cruise_suppliers');
    }
};
