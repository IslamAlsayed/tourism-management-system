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
        Schema::create('types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // e.g., hotel, transport, tour, other
            $table->string('name_ar')->nullable(); // e.g., فندق، نقل، جولة، أخرى
            $table->text('description')->nullable();
            $table->boolean('is_active')->nullable()->default(true);
            $table->index('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('types');
    }
};