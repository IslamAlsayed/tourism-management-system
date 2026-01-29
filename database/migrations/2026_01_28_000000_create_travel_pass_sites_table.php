<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('travel_pass_sites', function (Blueprint $table) {
            $table->id();

            // Foreign Keys
            $table->foreignId('travel_pass_id')->nullable();
            $table->foreignId('tourist_site_id')->nullable();

            // Additional pivot columns
            $table->boolean('is_included')->default(true);
            $table->integer('visit_limit')->nullable();
            $table->text('special_conditions')->nullable();

            // Timestamps
            $table->timestamps();

            // Unique constraint - each site can only be attached once per pass
            $table->unique(['travel_pass_id', 'tourist_site_id']);

            // Indexes
            $table->index(['travel_pass_id']);
            $table->index(['tourist_site_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('travel_pass_sites');
    }
};
