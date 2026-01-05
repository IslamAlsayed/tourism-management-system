<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name')->nullable();
            $table->string('name_ar')->nullable();
            $table->unsignedBigInteger('timezone_id')->nullable();
            $table->unsignedBigInteger('region_id')->nullable();
            $table->unsignedBigInteger('subregion_id')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->boolean('all_cities')->nullable()->default(false);
            $table->string('iso2')->nullable();
            $table->string('iso3')->nullable();
            $table->string('fips_code')->nullable();
            $table->string('type')->nullable();
            $table->integer('level')->nullable();
            $table->decimal('latitude', 10, 6)->nullable();
            $table->decimal('longitude', 10, 6)->nullable();
            $table->boolean('is_independent')->nullable()->default(false);
            $table->boolean('is_developed')->nullable()->default(false);
            $table->boolean('is_landlocked')->nullable()->default(false);
            $table->boolean('is_active')->nullable()->default(true);
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['name', 'name_ar']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('states');
    }
};