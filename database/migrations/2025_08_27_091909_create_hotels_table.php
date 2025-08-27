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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('country');
            $table->string('city');
            $table->string('street')->nullable();
            $table->string('cat')->nullable();
            $table->string('type')->nullable();
            $table->string('trade_name');
            $table->string('arabic_name');
            $table->string('general_mobile')->nullable();
            $table->string('general_email')->nullable();
            $table->string('website')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone_ext')->nullable();
            $table->string('fax')->nullable();
            $table->string('box')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('sales_man')->nullable();
            $table->string('sales_phone')->nullable();
            $table->string('sales_mail')->nullable();
            $table->string('resv_man')->nullable();
            $table->string('resv_phone')->nullable();
            $table->string('resvr_mail')->nullable();
            $table->string('accounting_person')->nullable();
            $table->string('acc_mail')->nullable();
            $table->string('acc_phone')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};