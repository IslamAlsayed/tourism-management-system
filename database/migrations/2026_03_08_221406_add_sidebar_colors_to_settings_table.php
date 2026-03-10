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
            $table->string('app_theme_color_sidebar_bg')->nullable()->after('app_theme_color_dark');
            $table->string('app_theme_color_sidebar_text')->nullable()->after('app_theme_color_sidebar_bg');
            $table->string('app_theme_color_sidebar_active')->nullable()->after('app_theme_color_sidebar_text');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'app_theme_color_sidebar_bg',
                'app_theme_color_sidebar_text',
                'app_theme_color_sidebar_active',
            ]);
        });
    }
};
