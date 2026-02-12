<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('states')) {
            return;
        }
        Schema::create('states', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->uuid('uuid')->unique();
            $table->string('name')->nullable();
            $table->string('name_ar')->nullable();
            $table->foreignId('country_id')->nullable();
            $table->string('iso2')->nullable();
            $table->string('iso3')->nullable();
            $table->string('fips_code')->nullable();
            $table->string('type')->nullable();
            $table->integer('level')->nullable();
            $table->decimal('latitude', 10, 6)->nullable();
            $table->decimal('longitude', 10, 6)->nullable();
            $table->string('photo')->nullable();
            $table->boolean('is_independent')->nullable()->default(false);
            $table->boolean('is_developed')->nullable()->default(false);
            $table->boolean('is_landlocked')->nullable()->default(false);
            $table->boolean('is_active')->nullable()->default(true);
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['name', 'name_ar']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('states');
    }
};