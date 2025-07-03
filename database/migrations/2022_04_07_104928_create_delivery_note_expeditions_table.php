<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('delivery_note_expeditions', function (Blueprint $table) {
            $table->id();
            $table->string('delivery_id')->constrained('delivery_notes'); // This is the foreign key to the delivery_notes table
            // Expedition Information
            $table->string('expedition_type', 20)->nullable(); // e.g., 'transit' or 'non-transit'
            $table->foreignId('expedition_id')->nullable()->constrained()->onDelete('SET NULL');// constrained tetapi ketika ekspedisi dihapus, surat jalan janganlah dihapus
            $table->string('expedition_name',100)->nullable();
            $table->foreignId('address_id')->nullable()->constrained()->onDelete('SET NULL'); // penting kalo sewaktu-waktu alamat utama pelanggan di edit.
            $table->string('full_address')->nullable();
            $table->string('short_address')->nullable();
            $table->foreignId('contact_number_id')->nullable()->constrained()->onDelete('SET NULL');
            $table->string('contact_number')->nullable();
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
        Schema::dropIfExists('delivery_note_expeditions');
    }
};
