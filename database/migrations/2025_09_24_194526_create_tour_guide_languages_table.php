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
        Schema::create('tour_guide_languages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_guide_id')->nullable()->constrained('tour_guides')->cascadeOnDelete();
            $table->foreignId('language_id')->nullable()->constrained('languages')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_guide_languages');
    }
};