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
        Schema::create('contact_numbers', function (Blueprint $table) {
            $table->id();
            $table->foreignId("owner_id");
            $table->string("owner_type"); // user, customer, supplier, etc.
            $table->string("owner_name", 100)->nullable(); // Name of the person or entity associated with the address.
            $table->string("contact_type", 20)->nullable(); // e.g., mobile, home, office, fax, etc.
            $table->string("contact_status", 20)->nullable(); // e.g., active, inactive, etc.
            $table->string("contact_order", 20)->nullable(); // Order of the contact, e.g., 1 for primary, 2 for secondary, etc.
            $table->string("country_code", 10)->nullable(); // Country code for the phone number, e.g., +62 for Indonesia.
            $table->string("area_code", 10)->nullable(); // Area code for the phone number, e.g., 21 for Jakarta.
            $table->string("number", 20)->nullable(); // The actual phone number.
            $table->string("extension", 10)->nullable(); // Extension number for office or PBX systems.
            $table->string("description")->nullable(); // Additional description or notes about the contact number.
            $table->string('created_by', 50)->nullable();
            $table->string('updated_by', 50)->nullable();
            $table->timestamp('deleted_at')->nullable(); // Soft delete
            $table->string('deleted_by', 50)->nullable(); // User who deleted the record, if applicable
            $table->string('deleted_reason', 255)->nullable(); // Reason for deletion, if applicable
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_numbers');
    }
};
