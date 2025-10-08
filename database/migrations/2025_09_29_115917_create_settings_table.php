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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            // General Settings
            $table->string('app_name')->default('laravel');
            $table->string('app_url')->default('http://localhost');
            $table->string('app_timezone')->default('Africa/Cairo');
            $table->string('app_language')->default('en');
            $table->string('app_version')->default(env('APP_VERSION', '4.4.0'));
            $table->string('app_php_version')->default('8.2.28');
            $table->string('app_light_photo')->nullable();
            $table->string('app_dark_photo')->nullable();
            $table->string('app_mini_photo')->nullable();
            $table->boolean('app_status')->default(true);

            // Security Settings
            $table->string('app_password_length')->default(8);
            $table->string('app_session_lifetime')->default(120);
            $table->boolean('app_password_confirmation')->default(true);
            $table->boolean('app_two_factor_authentication')->default(false);
            $table->enum('app_backup_frequency', ['daily', 'weekly', 'monthly'])->default('weekly');
            $table->boolean('app_auto_backup')->default(false);

            // Notification Settings
            $table->boolean('app_email_notifications')->default(false);
            $table->boolean('app_sms_notifications')->default(false);
            $table->boolean('app_push_notifications')->default(false);

            // Notification Types
            $table->boolean('app_notifications_new_user')->default(false);
            $table->boolean('app_notifications_data_update')->default(false);
            $table->boolean('app_notifications_system_report')->default(false);
            $table->boolean('app_notifications_security_update')->default(false);
            $table->integer('app_paginate_count')->default(25);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};