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
        Schema::create('tour_guide_types', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->uuid('uuid')->unique();
            $table->string('type')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->foreignId('currency_id')->nullable();
            $table->foreignId('country_id')->nullable();
            $table->boolean('all_states')->nullable()->default(false);
            $table->boolean('all_cities')->nullable()->default(false);
            $table->boolean('is_active')->nullable();
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_guide_types');
    }
};
