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
        Schema::table('import_settings', function (Blueprint $table) {
            $table->unsignedInteger('last_import_count')->nullable()->after('google_drive_url');
            $table->timestamp('last_imported_at')->nullable()->after('last_import_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('import_settings', function (Blueprint $table) {
            $table->dropColumn(['last_import_count', 'last_imported_at']);
        });
    }
};
