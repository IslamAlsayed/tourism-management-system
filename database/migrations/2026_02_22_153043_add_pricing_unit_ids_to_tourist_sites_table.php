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
            $table->foreignId('local_guide_price_unit_id')->nullable()->after('local_guide_price')->constrained('pricing_definitions')->nullOnDelete();
            $table->foreignId('club_car_price_unit_id')->nullable()->after('club_car_price')->constrained('pricing_definitions')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tourist_sites', function (Blueprint $table) {
            $table->dropForeign(['local_guide_price_unit_id']);
            $table->dropForeign(['club_car_price_unit_id']);
            $table->dropColumn(['local_guide_price_unit_id', 'club_car_price_unit_id']);
        });
    }
};
