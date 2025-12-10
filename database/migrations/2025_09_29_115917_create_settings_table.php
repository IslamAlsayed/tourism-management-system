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
            $table->uuid('uuid')->unique();

            // General Settings
            $table->string('app_name')->default('laravel');
            $table->string('app_url')->default('http://localhost');
            $table->string('app_timezone')->default('Africa/Cairo');
            $table->string('app_language')->default('en');
            $table->string('app_version')->default(env('APP_VERSION', '4.4.0'));
            $table->string('app_php_version')->default('8.2.28');
            $table->string('app_columns_length')->default(config('app.app_columns_length', env('APP_COLUMNS_LENGTH', 5)));
            $table->string('app_light_photo')->nullable();
            $table->string('app_dark_photo')->nullable();
            $table->string('app_mini_photo')->nullable();
            $table->boolean('app_status')->default(true);

            // Security Settings
            $table->string('app_minimum_password_length')->default(8);
            $table->string('app_session_lifetime')->default(120);
            $table->boolean('app_password_confirmation')->default(true);
            $table->boolean('app_two_factor_authentication')->default(false);
            $table->enum('app_backup_frequency', ['daily', 'weekly', 'monthly'])->default('weekly');
            $table->boolean('app_auto_backup')->default(false);

            // Ably Settings
            $table->string('app_ably_key')->nullable();
            // Notification Settings
            $table->boolean('app_email_notifications')->default(false);
            $table->boolean('app_sms_notifications')->default(false);
            $table->boolean('app_push_notifications')->default(false);

            // Notification Types
            $table->boolean('app_notifications_new_record')->default(true);
            $table->boolean('app_notifications_data_updates')->default(false);
            $table->boolean('app_notifications_data_deletes')->default(false);
            $table->boolean('app_notifications_system_reports')->default(false);
            $table->boolean('app_notifications_security_updates')->default(false);
            $table->integer('app_paginate_count')->default(25);

            // Booking Settings
            $table->integer('app_free_cancellation_days')->default(7);
            $table->integer('app_min_advance_booking_days')->default(1);
            $table->string('app_default_currency', 10)->default('SAR');
            $table->decimal('app_default_tax_rate', 5, 2)->default(15.00);
            $table->decimal('app_service_fee_percentage', 5, 2)->default(5.00);

            // Payment Settings
            $table->decimal('app_minimum_deposit_percentage', 5, 2)->default(30.00);
            $table->integer('app_payment_grace_period_days')->default(3);

            // Search & Display Settings
            $table->integer('app_new_deals_duration_days')->default(7);
            $table->boolean('app_smart_search_enabled')->default(true);

            // Security Settings (additional)
            $table->integer('app_max_login_attempts')->default(5);
            $table->integer('app_ip_ban_duration_minutes')->default(30);

            // Activity Log Settings
            $table->boolean('app_activity_log_enabled')->default(true);
            $table->integer('app_activity_log_retention_days')->default(90);

            // Maintenance Mode
            $table->boolean('app_maintenance_mode')->default(false);
            $table->text('app_maintenance_message')->nullable();

            // Google Maps Settings
            $table->string('app_google_maps_key')->nullable();
            // SMTP Settings
            $table->string('app_smtp_host')->nullable();
            $table->integer('app_smtp_port')->nullable();
            $table->string('app_smtp_username')->nullable();
            $table->string('app_smtp_password')->nullable();
            $table->integer('app_sidebar_width')->nullable()->default(310);
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