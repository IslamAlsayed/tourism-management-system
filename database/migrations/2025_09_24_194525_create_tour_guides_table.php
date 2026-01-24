<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tour_guides', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->uuid('uuid')->unique();
            $table->string('name')->nullable();
            $table->string('name_ar')->nullable();
            $table->foreignId('currency_id')->nullable();
            $table->foreignId('guide_type_id')->nullable();
            $table->foreignId('region_id')->nullable();
            $table->foreignId('subregion_id')->nullable();
            $table->foreignId('country_id')->nullable();
            $table->foreignId('state_id')->nullable();
            $table->foreignId('city_id')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile_01')->nullable();
            $table->string('mobile_02')->nullable();
            $table->string('home_city')->nullable();
            $table->year('birth_year')->nullable();
            $table->string('photo')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->unsignedBigInteger('national_guide_id')->nullable();
            $table->string('tourism_ministry_code')->nullable();
            $table->decimal('fd_day_fees', 10, 2)->nullable(); // Full day
            $table->decimal('hd_day_fees', 10, 2)->nullable(); // Half day
            $table->decimal('extra_fees_1', 10, 2)->nullable();
            $table->decimal('extra_fees_2', 10, 2)->nullable();
            $table->boolean('is_active')->nullable();
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('currency_id');
            $table->index('guide_type_id');
            $table->index('region_id');
            $table->index('subregion_id');
            $table->index('country_id');
            $table->index('state_id');
            $table->index('city_id');
            $table->index('email');
            $table->index('mobile_01');
            $table->index('mobile_02');
            $table->index('national_guide_id');
            $table->index('tourism_ministry_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_guides');
    }
};
