<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('provider')->default('custom');
            
            // SMTP (Outgoing)
            $table->string('smtp_host')->nullable();
            $table->integer('smtp_port')->nullable();
            $table->string('smtp_user')->nullable();
            $table->string('smtp_pass')->nullable();
            $table->string('smtp_encryption')->nullable();

            // IMAP/POP3 (Incoming)
            $table->string('incoming_host')->nullable();
            $table->integer('incoming_port')->nullable();
            $table->string('incoming_user')->nullable();
            $table->string('incoming_pass')->nullable();
            $table->string('incoming_encryption')->nullable();
            $table->string('incoming_protocol')->default('imap');

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_accounts');
    }
};
