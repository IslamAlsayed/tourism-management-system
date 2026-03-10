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
        Schema::table('settings', function (Blueprint $table) {
            $table->string('app_theme_color_primary')->nullable()->default('#181C32');
            $table->string('app_theme_color_secondary')->nullable()->default('#212122');
            $table->string('app_theme_color_success')->nullable()->default('#17c653');
            $table->string('app_theme_color_info')->nullable()->default('#7239ea');
            $table->string('app_theme_color_warning')->nullable()->default('#f6c000');
            $table->string('app_theme_color_danger')->nullable()->default('#f8285a');
            $table->string('app_theme_color_dark')->nullable()->default('#1E2129');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'app_theme_color_primary',
                'app_theme_color_secondary',
                'app_theme_color_success',
                'app_theme_color_info',
                'app_theme_color_warning',
                'app_theme_color_danger',
                'app_theme_color_dark',
            ]);
        });
    }
};
