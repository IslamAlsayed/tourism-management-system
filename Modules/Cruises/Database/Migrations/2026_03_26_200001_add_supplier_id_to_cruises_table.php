<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cruises', function (Blueprint $table) {
            // Link cruise to its external supplier
            $table->unsignedBigInteger('supplier_id')->nullable()->after('company_id');
            $table->index('supplier_id');
        });
    }

    public function down(): void
    {
        Schema::table('cruises', function (Blueprint $table) {
            $table->dropIndex(['supplier_id']);
            $table->dropColumn('supplier_id');
        });
    }
};
