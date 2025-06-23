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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstname', 50)->nullable();
            $table->string('lastname', 50)->nullable();
            $table->string('fullname')->nullable();
            $table->string('id_type', 20)->nullable(); // KTP, SIM, Passport, dll
            $table->string('id_number')->nullable()->unique();
            $table->string('contact_type')->nullable(); // WA, SMS, Email, dll
            $table->string('contact_number')->nullable()->unique();
            $table->string('username', 50)->unique();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->string('role', 20)->default('customer'); // ['developer', 'superadmin', 'admin', 'user', 'client', 'customer']
            $table->tinyInteger('clearance_level')->default(1);
            $table->tinyInteger('access_level')->nullable()->default(1);
            $table->string('type', 20)->nullable(); // ["reseller", "dropshipper", "seller", "buyer"]
            $table->string('account_type', 20)->nullable();
            $table->string('gender', 20)->nullable(); // pria atau wanita
            $table->string('profile_photo_path')->nullable();
            $table->string('created_by', 50)->nullable();
            $table->string('updated_by', 50)->nullable();
            $table->timestamp('deleted_at')->nullable(); // Soft delete
            $table->string('deleted_by', 50)->nullable(); // User who deleted the record, if applicable
            $table->string('deleted_reason', 255)->nullable(); // Reason for deletion, if applicable

            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
