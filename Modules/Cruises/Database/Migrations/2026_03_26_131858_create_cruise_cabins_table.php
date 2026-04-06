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
        Schema::create('cruise_cabins', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('company_id')->index(); // Tenant ID
            $table->foreignId('cruise_id')->constrained('cruises')->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('cruise_cabin_categories')->nullOnDelete();
            $table->string('name')->nullable(); // Cabin number or specific name
            $table->string('name_ar')->nullable();
            $table->string('bed_type')->nullable(); // Twin, Double, King
            $table->unsignedTinyInteger('max_adults')->default(2);
            $table->unsignedTinyInteger('max_children')->default(0);
            $table->unsignedInteger('base_count')->default(0); // Total number of this type
            $table->decimal('size_sqm', 8, 2)->nullable();
            $table->string('deck_number')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cruise_cabins');
    }
};
