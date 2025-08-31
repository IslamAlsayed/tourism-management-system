<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->string('country_name');
            $table->string('regions')->nullable();
            $table->string('states')->nullable();
            $table->string('country_code')->nullable();
            $table->string('city')->nullable();
            $table->string('fax')->nullable();
            $table->string('office_category_en')->nullable();
            $table->string('office_category_ar')->nullable();
            $table->string('english_trade_name')->nullable();
            $table->string('arabic_trade_name')->nullable();
            $table->string('english_company_name')->nullable();
            $table->string('arabic_company_name')->nullable();
            $table->string('email_01')->nullable();
            $table->string('email_02')->nullable();
            $table->string('email_03')->nullable();
            $table->string('email_04')->nullable();
            $table->string('email_05')->nullable();
            $table->string('phone_01')->nullable();
            $table->string('phone_02')->nullable();
            $table->string('mobile_01')->nullable();
            $table->string('address_01')->nullable();
            $table->string('address_02')->nullable();
            $table->string('website')->nullable();
            $table->string('establishment_number')->nullable();
            $table->string('office_name_en')->nullable();
            $table->string('gm_name')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};