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
        Schema::table('tour_guides', function (Blueprint $table) {
            $table->dropColumn('birth_year');
            $table->date('birth_date')->nullable()->after('home_city');
            $table->unsignedInteger('age')->nullable()->after('birth_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tour_guides', function (Blueprint $table) {
            $table->dropColumn(['birth_date', 'age']);
            $table->year('birth_year')->nullable()->after('home_city');
        });
    }
};
