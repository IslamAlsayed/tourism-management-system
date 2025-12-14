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
        Schema::create('transportation_company_bus_types', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->nullable();
            $table->unsignedInteger('min_seats')->nullable();
            $table->unsignedInteger('max_seats')->nullable();
            $table->unsignedInteger('seats')->nullable();
            $table->foreignId('company_id')->constrained('transportation_companies')->cascadeOnDelete();
            $table->foreignId('bus_type_id')->constrained('transportation_bus_types')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transportation_company_bus_types');
    }
};