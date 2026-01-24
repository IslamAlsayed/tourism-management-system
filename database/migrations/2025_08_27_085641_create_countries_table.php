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
            $table->id()->autoIncrement();
            $table->uuid('uuid')->unique();
            $table->foreignId('timezone_id')->nullable();
            $table->foreignId('language_id')->nullable();
            $table->foreignId('currency_id')->nullable();
            $table->foreignId('region_id')->nullable();
            $table->foreignId('subregion_id')->nullable();

            $table->string('name')->nullable();
            $table->string('name_ar')->nullable();
            $table->string('iso2', 2)->nullable();
            $table->string('iso3', 3)->nullable();
            $table->integer('numeric_code')->nullable();
            $table->string('phone_code')->nullable();
            $table->string('capital')->nullable();
            $table->string('tld')->nullable();
            $table->string('native')->nullable();
            $table->decimal('latitude', 10, 6)->nullable();
            $table->decimal('longitude', 10, 6)->nullable();
            $table->bigInteger('population')->nullable();
            $table->string('photo')->nullable();
            $table->float('area')->nullable();
            $table->boolean('is_independent')->nullable()->default(false);
            $table->boolean('is_developed')->nullable()->default(false);
            $table->boolean('is_landlocked')->nullable()->default(false);
            $table->boolean('is_active')->nullable();
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['name', 'name_ar']);
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
