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
            $table->string('type')->default('form_field')->after('field_key')->comment('form_field or sidebar_menu');
            $table->string('color_light')->nullable()->after('icon_class');
            $table->string('color_dark')->nullable()->after('color_light');
            $table->string('weight')->default('solid')->after('color_dark')->comment('solid, regular, light, duotone');
            $table->string('size')->nullable()->after('weight');
            $table->boolean('is_active')->default(true)->after('size');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ui_icons', function (Blueprint $table) {
            $table->dropColumn(['type', 'color_light', 'color_dark', 'weight', 'size', 'is_active']);
        });
    }
};
