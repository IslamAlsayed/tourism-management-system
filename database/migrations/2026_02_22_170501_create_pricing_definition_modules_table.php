<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pricing_definition_modules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pricing_definition_id');
            $table->string('module_name');       // e.g. tourists, hotels, transportation, restaurants
            $table->string('field_name')->nullable(); // e.g. local_guide_price_unit, room_price_unit
            $table->string('section_label')->nullable(); // Human-readable: "Additional Pricing", "Room Rates"
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('pricing_definition_id')
                  ->references('id')
                  ->on('pricing_definitions')
                  ->onDelete('cascade');

            $table->unique(['pricing_definition_id', 'module_name', 'field_name'], 'pdm_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pricing_definition_modules');
    }
};
