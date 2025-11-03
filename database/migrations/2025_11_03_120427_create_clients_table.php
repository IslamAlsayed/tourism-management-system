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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('photo')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('phone')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('mobile')->nullable();
            $table->text('address')->nullable();
            $table->string('client_code')->unique()->nullable();

            // Company information (for corporate clients)
            $table->string('company_name')->nullable();
            $table->text('company_address')->nullable();
            $table->string('tax_number')->nullable();
            $table->string('commercial_registration')->nullable();

            // Personal information
            $table->foreignId('nationality_id')->nullable()->constrained('nationalities')->onDelete('set null');
            $table->string('passport_number')->nullable();
            $table->string('id_number')->nullable();
            $table->date('birth_date')->nullable();

            // Preferences
            $table->string('preferred_language')->default('en');
            $table->string('timezone')->default('UTC');
            $table->json('preferences')->nullable();

            // Client classification
            $table->enum('client_type', ['individual', 'corporate'])->default('individual');
            $table->enum('client_status', ['active', 'inactive', 'blacklisted'])->default('active');

            // Financial settings
            $table->decimal('credit_limit', 10, 2)->default(0);
            $table->integer('payment_terms')->default(30); // days
            $table->decimal('discount_rate', 5, 2)->default(0); // percentage

            // Status flags
            $table->boolean('is_active')->default(true);
            $table->boolean('is_verified')->default(false);

            // Additional information
            $table->text('notes')->nullable();

            // Tracking
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');

            $table->timestamps();

            // Indexes
            $table->index('email');
            $table->index('client_code');
            $table->index('client_type');
            $table->index('client_status');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
