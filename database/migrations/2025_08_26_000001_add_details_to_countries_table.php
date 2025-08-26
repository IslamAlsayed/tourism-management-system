<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->string('flag_url')->nullable();
            $table->string('flag_emoji', 8)->nullable();
            $table->string('currency_code', 10)->nullable();
            $table->string('capital')->nullable();
            $table->string('phone_code', 10)->nullable();
            $table->string('continent')->nullable();
            $table->unsignedBigInteger('population')->nullable();
            $table->float('area')->nullable();
            $table->boolean('is_active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->dropColumn([
                'flag_url',
                'flag_emoji',
                'currency_code',
                'capital',
                'phone_code',
                'continent',
                'population',
                'area',
                'is_active',
            ]);
        });
    }
};
