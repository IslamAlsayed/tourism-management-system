<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('custom_field_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('field_definition_id')->constrained('field_definitions')->cascadeOnDelete();
            $table->string('entity_type');               // Full model class: Modules\TourGuides\Entities\TourGuide
            $table->unsignedBigInteger('entity_id');     // ID of the record
            $table->text('value')->nullable();
            $table->timestamps();

            $table->unique(['field_definition_id', 'entity_type', 'entity_id'], 'cfv_unique');
            $table->index(['entity_type', 'entity_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('custom_field_values');
    }
};
