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
        Schema::table('clients', function (Blueprint $table) {
            $table->string('whatsapp')->nullable()->after('mobile');
            $table->string('city')->nullable()->after('address');
            $table->string('country')->nullable()->after('city');
            $table->string('postal_code')->nullable()->after('country');
            $table->string('company_phone')->nullable()->after('commercial_registration');
            $table->string('company_email')->nullable()->after('company_phone');
            $table->enum('gender', ['male', 'female'])->nullable()->after('birth_date');
            $table->string('currency', 3)->nullable()->after('discount_rate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn([
                'whatsapp',
                'city',
                'country',
                'postal_code',
                'company_phone',
                'company_email',
                'gender',
                'currency'
            ]);
        });
    }
};