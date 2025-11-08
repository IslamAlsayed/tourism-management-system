<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add indexes to countries table
        Schema::table('countries', function (Blueprint $table) {
            $table->index(['name', 'name_ar', 'timezone']);
        });

        // Add indexes to states table
        Schema::table('states', function (Blueprint $table) {
            $table->index(['name', 'name_ar', 'country_id']);
        });

        // Add indexes to users table
        Schema::table('users', function (Blueprint $table) {
            $table->index(['name', 'email', 'phone']);
        });

        // Add indexes to currencies table
        Schema::table('currencies', function (Blueprint $table) {
            $table->index(['name', 'code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->dropIndex(['name', 'name_ar']);
        });

        Schema::table('states', function (Blueprint $table) {
            $table->dropIndex(['name', 'name_ar', 'country_id']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['name', 'email', 'phone']);
        });

        Schema::table('currencies', function (Blueprint $table) {
            $table->dropIndex(['name', 'code']);
        });
    }
};