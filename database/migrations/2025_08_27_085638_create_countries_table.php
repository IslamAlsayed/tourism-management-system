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
            $table->string('name');
            $table->string('iso3');
            $table->string('iso2');
            $table->integer('numeric_code');
            $table->string('phone_code');
            $table->string('capital');
            $table->string('currency');
            $table->string('currency_name');
            $table->string('currency_symbol');
            $table->string('tld');
            $table->string('native');
            $table->string('region');
            $table->unsignedBigInteger('region_id');
            $table->string('subregion');
            $table->unsignedBigInteger('subregion_id');
            $table->string('nationality');
            $table->text('timezones');
            $table->decimal('latitude', 10, 6);
            $table->decimal('longitude', 10, 6);
            $table->string('emoji');
            $table->string('emojiU');
            $table->bigInteger('population');
            $table->string('flag_url')->nullable();
            $table->string('flag_emoji', 8)->nullable();
            $table->string('currency_code', 10)->nullable();
            $table->string('continent')->nullable();
            $table->float('area')->nullable();
            $table->boolean('is_active')->default(true);
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