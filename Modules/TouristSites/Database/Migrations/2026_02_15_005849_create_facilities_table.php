<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name');
            $table->string('name_ar')->nullable();
            $table->string('icon')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('tourist_site_facilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tourist_site_id')->constrained('tourist_sites')->onDelete('cascade');
            $table->foreignId('facility_id')->constrained('facilities')->onDelete('cascade');
            $table->timestamps();
        });

        // Seed default facilities
        $defaultFacilities = [
            'wheelchair_accessible', 'free_wifi', 'parking', 'restrooms', 'restaurants', 
            'gift_shop', 'guided_tours', 'audio_guide', 'photography', 'hiking', 
            'swimming', 'camping', 'shopping', 'dining', 'entertainment', 
            'educational_tours', 'translation', 'special_events', 'group_bookings', 
            'online_booking', 'mobile_app', 'virtual_tours'
        ];

        foreach ($defaultFacilities as $index => $key) {
            \Illuminate\Support\Facades\DB::table('facilities')->insert([
                'uuid' => \Illuminate\Support\Str::uuid(),
                'name' => str_replace('_', ' ', ucfirst($key)), // Fallback name
                'name_ar' => null, // Will be filled later or managed via admin
                'is_active' => true,
                'sort_order' => $index,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facilities');
    }
};
