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
        Schema::table('page_banners', function (Blueprint $table) {
            $table->string('route_name')->nullable()->change();
            $table->string('image_path')->nullable()->change();
            
            $table->enum('apply_to', ['route', 'module'])->default('route')->after('id');
            $table->string('module_name')->nullable()->after('apply_to');
            $table->enum('banner_type', ['image', 'text_color'])->default('image')->after('title');
            
            // Text Mode Fields
            $table->string('bg_color', 20)->nullable()->after('image_path')->comment('e.g., #ffffff');
            $table->text('text_content')->nullable()->after('bg_color');
            $table->string('text_color', 20)->nullable()->after('text_content');
            $table->string('font_family')->nullable()->after('text_color');
            $table->string('font_size', 20)->nullable()->after('font_family');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('page_banners', function (Blueprint $table) {
            $table->string('route_name')->nullable(false)->change();
            $table->string('image_path')->nullable(false)->change();
            
            $table->dropColumn([
                'apply_to',
                'module_name',
                'banner_type',
                'bg_color',
                'text_content',
                'text_color',
                'font_family',
                'font_size'
            ]);
        });
    }
};
