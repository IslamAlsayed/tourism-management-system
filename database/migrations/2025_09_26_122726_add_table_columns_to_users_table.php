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
        Schema::table('users', function (Blueprint $table) {
            $table->json('table_columns')->nullable()->before('created_at');
        });
        Schema::table('currencies', function (Blueprint $table) {
            $table->json('table_columns')->nullable()->before('created_at');
        });
        Schema::table('regions', function (Blueprint $table) {
            $table->json('table_columns')->nullable()->before('created_at');
        });
        Schema::table('subregions', function (Blueprint $table) {
            $table->json('table_columns')->nullable()->before('created_at');
        });
        Schema::table('countries', function (Blueprint $table) {
            $table->json('table_columns')->nullable()->before('created_at');
        });
        Schema::table('states', function (Blueprint $table) {
            $table->json('table_columns')->nullable()->before('created_at');
        });
        Schema::table('cities', function (Blueprint $table) {
            $table->json('table_columns')->nullable()->before('created_at');
        });
        Schema::table('nationalities', function (Blueprint $table) {
            $table->json('table_columns')->nullable()->before('created_at');
        });
        Schema::table('types', function (Blueprint $table) {
            $table->json('table_columns')->nullable()->before('created_at');
        });
        Schema::table('accommodations', function (Blueprint $table) {
            $table->json('table_columns')->nullable()->before('created_at');
        });
        Schema::table('room_types', function (Blueprint $table) {
            $table->json('table_columns')->nullable()->before('created_at');
        });
        Schema::table('seasons', function (Blueprint $table) {
            $table->json('table_columns')->nullable()->before('created_at');
        });
        Schema::table('rates', function (Blueprint $table) {
            $table->json('table_columns')->nullable()->before('created_at');
        });
        Schema::table('rate_details', function (Blueprint $table) {
            $table->json('table_columns')->nullable()->before('created_at');
        });
        Schema::table('restaurants', function (Blueprint $table) {
            $table->json('table_columns')->nullable()->before('created_at');
        });
        Schema::table('tour_guide_types', function (Blueprint $table) {
            $table->json('table_columns')->nullable()->before('created_at');
        });
        Schema::table('tour_guides', function (Blueprint $table) {
            $table->json('table_columns')->nullable()->before('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('table_columns');
        });
        Schema::table('currencies', function (Blueprint $table) {
            $table->dropColumn('table_columns');
        });
        Schema::table('regions', function (Blueprint $table) {
            $table->dropColumn('table_columns');
        });
        Schema::table('subregions', function (Blueprint $table) {
            $table->dropColumn('table_columns');
        });
        Schema::table('countries', function (Blueprint $table) {
            $table->dropColumn('table_columns');
        });
        Schema::table('states', function (Blueprint $table) {
            $table->dropColumn('table_columns');
        });
        Schema::table('cities', function (Blueprint $table) {
            $table->dropColumn('table_columns');
        });
        Schema::table('nationalities', function (Blueprint $table) {
            $table->dropColumn('table_columns');
        });
        Schema::table('types', function (Blueprint $table) {
            $table->dropColumn('table_columns');
        });
        Schema::table('accommodations', function (Blueprint $table) {
            $table->dropColumn('table_columns');
        });
        Schema::table('room_types', function (Blueprint $table) {
            $table->dropColumn('table_columns');
        });
        Schema::table('seasons', function (Blueprint $table) {
            $table->dropColumn('table_columns');
        });
        Schema::table('rates', function (Blueprint $table) {
            $table->dropColumn('table_columns');
        });
        Schema::table('rate_details', function (Blueprint $table) {
            $table->dropColumn('table_columns');
        });
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropColumn('table_columns');
        });
        Schema::table('tour_guide_types', function (Blueprint $table) {
            $table->dropColumn('table_columns');
        });
        Schema::table('tour_guides', function (Blueprint $table) {
            $table->dropColumn('table_columns');
        });
    }
};