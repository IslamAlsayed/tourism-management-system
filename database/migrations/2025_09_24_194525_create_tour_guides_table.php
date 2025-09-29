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
        Schema::create('tour_guides', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('name_ar')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile_01')->nullable();
            $table->string('mobile_02')->nullable();
            $table->string('home_city')->nullable();
            $table->year('birth_year')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->unsignedBigInteger('national_guide_id')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->string('guide_type')->nullable();
            $table->string('tourism_ministry_code')->nullable();
            $table->decimal('fd_day_fees', 10, 2)->nullable(); // Full day
            $table->decimal('hd_day_fees', 10, 2)->nullable(); // Half day
            $table->decimal('extra_fees_1', 10, 2)->nullable();
            $table->decimal('extra_fees_2', 10, 2)->nullable();
            $table->string('status')->nullable(); // بدل guide_sts
            $table->text('notes')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_guides');
    }
};