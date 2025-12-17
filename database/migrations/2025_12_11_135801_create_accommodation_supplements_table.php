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
        Schema::create('accommodation_supplements', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->nullable();
            $table->string('name');
            $table->string('name_ar')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('price_type')->default('per_person')->comment('per_person, per_room, per_night, one_time');
            $table->boolean('is_mandatory')->default(false);
            $table->date('applicable_date')->nullable();
            $table->foreignId('accommodation_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accommodation_supplements');
    }
};