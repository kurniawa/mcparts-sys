<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId("owner_id");
            $table->string("owner_type"); // user, customer, supplier, etc.
            $table->string("owner_name", 100)->nullable(); // Name of the person or entity associated with the address.
            $table->string("address_type", 50)->nullable(); // e.g., home, office, billing, shipping, etc.
            $table->string("address_status", 50)->nullable(); // e.g., active, inactive, etc.
            $table->string("address_order", 50)->nullable(); // Order of the address, e.g., 1 for primary, 2 for secondary, etc.
            $table->string("building_name", 100)->nullable();
            $table->string("floor", 10)->nullable();
            $table->string("housing_complex", 100)->nullable();
            $table->string("street",100)->nullable();
            $table->string("house_number",20)->nullable();
            $table->string("block_number",20)->nullable();
            $table->string("rt", 5)->nullable();
            $table->string("rw", 5)->nullable();
            $table->string("rural_village", 50)->nullable(); // desa is the rural village, often used in rural areas.
            $table->string("urban_village", 50)->nullable(); // keluarahan is the same as desa, but sometimes used in urban areas.
            $table->string("district", 50)->nullable();
            $table->string("city", 50)->nullable();
            $table->string("postal_code", 50)->nullable();
            $table->string("regency", 50)->nullable(); // kabupaten
            $table->string("province", 50)->nullable();
            $table->string("country", 50)->nullable();
            $table->string("short", 50)->nullable();
            $table->string("full")->nullable(); // yang di Jakarta/Tangerang ada yang tidak pakai keterangan alamat. Ini bisa diisi dengan nama perumahan atau nama ruko, dll.
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
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
};
