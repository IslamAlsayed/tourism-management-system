<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('type')->nullable();
            $table->string('cat')->nullable();
            $table->string('resturants_name_arabic')->nullable();
            $table->string('resturants_name_english')->nullable();
            $table->string('company_name_ar')->nullable();
            $table->string('specialty')->nullable();
            $table->string('phone_01')->nullable();
            $table->string('fax')->nullable();
            $table->string('phone_02')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('email_01')->nullable();
            $table->string('email_02')->nullable();
            $table->string('box')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('street')->nullable();
            $table->string('mobile')->nullable();
            $table->string('website')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurants');
    }
}