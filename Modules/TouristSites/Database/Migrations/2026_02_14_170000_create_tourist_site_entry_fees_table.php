<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('tourist_site_entry_fees')) {
            return;
        }
        Schema::create('tourist_site_entry_fees', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('tourist_site_id')->constrained('tourist_sites')->cascadeOnDelete();
            $table->foreignId('nationality_id')->constrained('nationalities')->cascadeOnDelete();
            $table->decimal('adult_price', 10, 2)->nullable();
            $table->decimal('child_price', 10, 2)->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['tourist_site_id', 'nationality_id']);
            $table->index('tourist_site_id');
            $table->index('nationality_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tourist_site_entry_fees');
    }
};
