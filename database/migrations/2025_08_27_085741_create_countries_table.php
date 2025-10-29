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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('name_ar')->nullable();
            $table->unsignedBigInteger('language_id')->nullable();
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->unsignedBigInteger('region_id')->nullable();
            $table->unsignedBigInteger('subregion_id')->nullable();
            $table->text('state_id')->nullable();
            $table->text('city_id')->nullable();
            $table->string('iso2', 2)->nullable();
            $table->string('iso3', 3)->nullable();
            $table->integer('numeric_code')->nullable();
            $table->string('phone_code')->nullable();
            $table->string('capital')->nullable();
            $table->string('tld')->nullable();
            $table->string('native')->nullable();
            $table->json('timezone')->nullable();
            $table->decimal('latitude', 10, 6)->nullable();
            $table->decimal('longitude', 10, 6)->nullable();
            $table->bigInteger('population')->nullable();
            $table->string('photo')->nullable();
            $table->string('continent')->nullable();
            $table->float('area')->nullable();
            $table->boolean('is_active')->nullable()->default(true);
            $table->boolean('is_independent')->nullable()->default(true);
            $table->boolean('is_developed')->nullable()->default(true);
            $table->boolean('is_landlocked')->nullable()->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};