<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('field_definitions', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('code', 20)->unique();
            $table->string('name');
            $table->string('name_ar')->nullable();
            $table->string('module_name');               // tour_guides, accommodations, restaurants, tourists, transportation
            $table->string('entity_type');                // TourGuide, Accommodation, Restaurant, TouristSite, TouristService, Company, etc.
            $table->string('field_type', 50);             // text, number, email, tel, url, date, textarea, select, checkbox, file
            $table->json('options')->nullable();           // For select: ["Option A", "Option B"]
            $table->string('placeholder')->nullable();
            $table->string('placeholder_ar')->nullable();
            $table->string('section_label')->nullable();  // Group label (e.g., "Contact Info")
            $table->string('section_label_ar')->nullable();
            $table->boolean('is_required')->default(false);
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['module_name', 'entity_type', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('field_definitions');
    }
};
