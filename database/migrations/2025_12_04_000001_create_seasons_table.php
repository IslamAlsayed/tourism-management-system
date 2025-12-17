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
        Schema::create('seasons', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->nullable();
            $table->string('name'); // e.g., Winter, Summer, High Season, Low Season
            $table->string('name_ar')->nullable();
            $table->date('season_from');
            $table->date('season_to');
            $table->boolean('is_active')->default(true);
            $table->foreignId('accommodation_id')->nullable()->constrained('accommodations')->onDelete('set null');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['season_from', 'season_to']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seasons');
    }
};