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
            // Drop old single color columns if they exist
            if (Schema::hasColumn('ui_icons', 'color_light')) {
                $table->dropColumn(['color_light', 'color_dark']);
            }
            
            // Add dual color columns for light theme
            $table->string('primary_color_light')->nullable()->after('icon_class');
            $table->string('secondary_color_light')->nullable()->after('primary_color_light');
            
            // Add dual color columns for dark theme
            $table->string('primary_color_dark')->nullable()->after('secondary_color_light');
            $table->string('secondary_color_dark')->nullable()->after('primary_color_dark');
            
            // Add custom CSS/Styles
            $table->string('custom_css')->nullable()->after('size');
            $table->text('custom_styles')->nullable()->after('custom_css');
            
            // Update type to be more descriptive
            $table->string('type')->default('form_field')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ui_icons', function (Blueprint $table) {
            $table->dropColumn([
                'primary_color_light', 'secondary_color_light',
                'primary_color_dark', 'secondary_color_dark',
                'custom_css', 'custom_styles'
            ]);
            $table->string('color_light')->nullable();
            $table->string('color_dark')->nullable();
        });
    }
};
