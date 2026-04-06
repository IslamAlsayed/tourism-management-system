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
        Schema::create('cruise_prices', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('company_id')->index(); // Tenant ID
            $table->foreignId('cruise_id')->constrained('cruises')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('cruise_cabin_categories')->cascadeOnDelete();
            $table->foreignId('season_id')->constrained('cruise_seasons')->cascadeOnDelete();
            
            // Pricing details
            $table->decimal('buy_price', 12, 2)->default(0);
            $table->string('buy_currency', 3)->default('USD');
            
            $table->decimal('sell_price', 12, 2)->default(0);
            $table->string('sell_currency', 3)->default('USD');
            
            $table->decimal('charter_price', 12, 2)->nullable()->comment('Full charter price for the vessel');
            $table->string('charter_currency', 3)->default('USD');
            
            // Tax and additional settings
            $table->boolean('is_tax_included')->default(false);
            $table->json('extra_fees')->nullable()->comment('Additional fees like port taxes, etc.');
            
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
        Schema::dropIfExists('cruise_prices');
    }
};
