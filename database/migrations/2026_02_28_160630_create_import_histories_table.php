<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('import_histories', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('model_type')->index();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->integer('record_count')->default(0);
            $table->string('source')->comment('file, google_drive');
            $table->string('status')->default('queued')->comment('queued, processing, completed, failed');
            $table->text('error_message')->nullable();
            $table->text('file_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('import_histories');
    }
};
