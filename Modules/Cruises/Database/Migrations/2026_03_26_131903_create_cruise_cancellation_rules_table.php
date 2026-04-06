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
        Schema::create('cruise_cancellation_rules', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('company_id')->index(); // Tenant ID
            $table->foreignId('cruise_id')->constrained('cruises')->cascadeOnDelete();
            $table->unsignedInteger('days_before')->comment('Days before departure');
            $table->decimal('percentage', 5, 2)->comment('Cancellation fee percentage (0-100)');
            $table->enum('type', ['fee', 'discount'])->default('fee');
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('cruise_cancellation_rules');
    }
};
