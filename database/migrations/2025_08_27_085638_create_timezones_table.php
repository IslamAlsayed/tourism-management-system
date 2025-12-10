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
        Schema::create('timezones', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name')->unique()->comment('e.g., America/New_York');
            $table->string('name_ar')->nullable()->comment('Arabic name');
            $table->string('abbreviation')->nullable()->comment('e.g., EST, PST');
            $table->string('abbreviation_dst')->nullable()->comment('Daylight Saving abbreviation');
            $table->integer('offset')->comment('Offset in seconds from UTC');
            $table->integer('offset_dst')->nullable()->comment('DST offset in seconds');
            $table->string('country_code', 2)->nullable()->comment('ISO 2 country code');
            $table->string('gmt_offset_name')->nullable()->comment('e.g., UTC+02:00');
            $table->string('gmt_offset_name_dst')->nullable()->comment('DST GMT offset name');
            $table->boolean('supports_dst')->default(false)->comment('Does it support daylight saving time?');
            $table->string('region')->nullable()->comment('Continent/Region');
            $table->string('city')->nullable()->comment('Main city');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index('name');
            $table->index('country_code');
            $table->index('offset');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timezones');
    }
};