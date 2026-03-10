<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('site_holidays', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('tourist_site_id')->constrained('tourist_sites')->cascadeOnDelete();

            // Type: weekly (recurring every week), annual (specific date each year), one_time (specific date)
            $table->enum('type', ['weekly', 'annual', 'one_time'])->default('one_time');

            // For weekly: day of week (saturday, sunday, etc.)
            $table->string('day_of_week')->nullable();

            // For annual/one_time: specific date
            $table->date('holiday_date')->nullable();

            // Name/reason for the holiday
            $table->string('name')->nullable();
            $table->string('name_ar')->nullable();

            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['tourist_site_id', 'type']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('site_holidays');
    }
};
