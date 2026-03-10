<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('site_seasonal_hours', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('tourist_site_id')->constrained('tourist_sites')->cascadeOnDelete();

            // Season name (e.g. "Ramadan", "Summer", "Winter")
            $table->string('season_name');
            $table->string('season_name_ar')->nullable();

            // Date range for the season
            $table->date('start_date');
            $table->date('end_date');

            // Custom operating hours during this season
            $table->time('opening_time')->nullable();
            $table->time('closing_time')->nullable();

            // If the site is completely closed during this period
            $table->boolean('is_closed')->default(false);

            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['tourist_site_id', 'start_date', 'end_date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('site_seasonal_hours');
    }
};
