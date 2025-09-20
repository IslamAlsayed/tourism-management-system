<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccommodationSupplementsTable extends Migration
{
    public function up(): void
    {

        Schema::create('accommodation_rate_nationality', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('accommodation_rate_id');
            $table->unsignedBigInteger('nationality_id')->nullable();
            $table->boolean('is_all')->default(false);
            $table->timestamps();

            $table->foreign('accommodation_rate_id')->references('id')->on('accommodation_rates')->onDelete('cascade');
            $table->foreign('nationality_id')->references('id')->on('nationalities')->onDelete('cascade');
        });

        Schema::create('accommodation_supplements', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 10, 2)->nullable();
            $table->boolean('is_per_person')->default(false);
            $table->boolean('is_mandatory')->default(false);
            $table->date('applicable_date')->nullable();
            $table->unsignedBigInteger('accommodation_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accommodation_supplements');
    }
}