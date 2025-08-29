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
            $table->string('name_ar');
            $table->string('iso2');
            $table->string('iso3');
            $table->integer('numeric_code')->nullable();
            $table->string('phone_code');
            $table->string('capital')->nullable();
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->string('tld')->nullable();
            $table->string('native')->nullable();
            $table->string('region')->nullable();
            $table->unsignedBigInteger('region_id')->nullable();
            $table->string('subregion')->nullable();
            $table->unsignedBigInteger('subregion_id')->nullable();
            $table->string('nationality')->nullable();
            $table->text('timezone');
            $table->decimal('latitude', 10, 6);
            $table->decimal('longitude', 10, 6);
            $table->string('emoji')->nullable();
            $table->string('emojiU')->nullable();
            $table->bigInteger('population');
            $table->string('flag_url')->nullable();
            $table->string('flag_emoji', 8)->nullable();
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