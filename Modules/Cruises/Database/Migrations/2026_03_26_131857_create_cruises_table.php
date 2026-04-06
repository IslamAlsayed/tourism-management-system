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
        Schema::create('cruises', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('company_id')->index(); // Tenant ID
            $table->string('name');
            $table->string('name_ar')->nullable();
            $table->string('slug')->unique();
            $table->string('vessel_class')->nullable(); // e.g., 5 Star, 5 Star Deluxe
            $table->string('type')->nullable(); // e.g., Nile Cruise, Dahabiya, Lake Cruise
            $table->unsignedInteger('total_cabins')->nullable();
            $table->unsignedInteger('deck_count')->nullable();
            $table->integer('built_year')->nullable();
            $table->integer('renovated_year')->nullable();
            $table->decimal('length_meters', 8, 2)->nullable();
            $table->decimal('draft_meters', 8, 2)->nullable();
            $table->json('policies')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_chartered')->default(false);
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
        Schema::dropIfExists('cruises');
    }
};
