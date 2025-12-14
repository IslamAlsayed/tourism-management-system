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
        Schema::table('users', function (Blueprint $table) {
            $table->string('bio')->nullable();
            $table->string('phone')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('address')->nullable();
            $table->string('user_code')->nullable();
            $table->string('employee_id')->nullable();
            $table->date('birth_date')->nullable();
            $table->date('hire_date')->nullable();
            $table->string('department')->nullable();
            $table->string('position')->nullable();
            $table->string('preferred_language', 5)->nullable()->default('en');
            $table->unsignedBigInteger('timezone_id')->nullable();
            $table->string('preferences')->nullable();
            $table->string('photo')->nullable();
            $table->string('user_status')->nullable()->default('offline');
            $table->boolean('is_admin')->default(false);
            $table->boolean('is_active')->nullable()->default(true);
            $table->boolean('is_verified')->default(false);
            $table->timestamp('password_changed_at')->nullable();
            $table->boolean('force_password_change')->default(false);
            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip')->nullable();
            $table->enum('button_display_mode', ['icon', 'text'])->default('text');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable()->default(2);

            $table->index('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'bio',
                'phone',
                'first_name',
                'last_name',
                'mobile',
                'address',
                'user_code',
                'employee_id',
                'birth_date',
                'hire_date',
                'department',
                'position',
                'preferred_language',
                'timezone_id',
                'preferences',
                'is_admin',
                'photo',
                'is_active',
                'is_verified',
                'force_password_change',
                'last_login_at',
                'last_login_ip',
                'notes'
            ]);
        });
    }
};