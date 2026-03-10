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
        $tables = ['regions', 'states', 'cities', 'countries', 'nationalities', 'restaurants'];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                // SQLite compatible way to check/add unique index
                $sm = Schema::getConnection();
                
                // If it's SQLite, we just attempt it or ignore if it fails
                try {
                    $table->unique('name', $tableName . '_name_unique');
                } catch (\Exception $e) {
                    // Ignore if it already exists
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = ['regions', 'states', 'cities', 'countries', 'nationalities', 'restaurants'];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                 $table->dropUnique([$tableName . '_name_unique']);
            });
        }
    }
};
