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
        Schema::table('ui_icons', function (Blueprint $table) {
            $table->string('shape')->default('none')->after('size')->comment('none, circle, square, rounded, squircle');
            $table->string('bg_color_light')->nullable()->after('shape');
            $table->string('bg_color_dark')->nullable()->after('bg_color_light');
            $table->string('border_color_light')->nullable()->after('bg_color_dark');
            $table->string('border_color_dark')->nullable()->after('border_color_light');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ui_icons', function (Blueprint $table) {
            $table->dropColumn(['shape', 'bg_color_light', 'bg_color_dark', 'border_color_light', 'border_color_dark']);
        });
    }
};
