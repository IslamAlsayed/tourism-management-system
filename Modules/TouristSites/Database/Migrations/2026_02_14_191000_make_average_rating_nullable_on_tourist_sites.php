<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tourist_sites', function (Blueprint $table) {
            $table->decimal('average_rating', 3, 2)->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tourist_sites', function (Blueprint $table) {
            // We cannot easily revert to NOT NULL without data loss if there are nulls, 
            // but we can revert the default if needed. 
            // For now, we will just leave it as is or revert to no default if strictness is required.
            $table->decimal('average_rating', 3, 2)->change(); 
        });
    }
};
