<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tourist_guides', function (Blueprint $table) {
            $table->id();
            $table->string('country_name');
            $table->string('home_city');
            $table->unsignedBigInteger('national_guide_id');
            $table->unsignedBigInteger('tourism_ministry_id');
            $table->string('guide_name_arabic');
            $table->string('guide_name_english');
            $table->decimal('FD_Day_fees', 10, 2)->nullable();
            $table->decimal('HD_Day_fees', 10, 2)->nullable();
            $table->decimal('extra_fees_1', 10, 2)->nullable();
            $table->decimal('extra_fees_2', 10, 2)->nullable();
            $table->decimal('overnight_fees_2', 10, 2)->nullable();
            $table->string('cat')->nullable();
            $table->string('type')->nullable();
            $table->integer('age')->nullable();
            $table->string('guide_sts')->nullable();
            $table->string('guide_languages')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile_01')->nullable();
            $table->string('mobile_02')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tourist_guides');
    }
};