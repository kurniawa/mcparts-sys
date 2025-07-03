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
        Schema::create('delivery_notes', function (Blueprint $table) {
            $table->id();
            $table->string('delivery_number')->nullable()->unique();
            // Customer Information
            $table->foreignId('customer_id')->nullable()->constrained()->onDelete('SET NULL');
            $table->string('customer_name',100)->nullable();
            $table->foreignId('customer_address_id')->nullable()->constrained()->onDelete('SET NULL'); // penting kalo sewaktu-waktu alamat utama pelanggan di edit.
            $table->string('customer_full_address')->nullable();
            $table->string('customer_short_address')->nullable();
            $table->foreignId('customer_contact_number_id')->nullable()->constrained('contact_numbers')->onDelete('SET NULL');
            $table->string('customer_contact_number')->nullable();
            // Reseller Information
            $table->foreignId('reseller_id')->nullable()->constrained('customers')->onDelete('set null');
            $table->string('reseller_nama',100)->nullable();
            $table->foreignId('reseller_address_id')->nullable()->constrained('addresses')->onDelete('SET NULL'); // penting kalo sewaktu-waktu alamat utama pelanggan di edit.
            $table->string('reseller_full_address')->nullable();
            $table->string('reseller_short_address')->nullable();
            $table->foreignId('reseller_contact_number_id')->nullable()->constrained('contact_numbers')->onDelete('SET NULL');
            $table->string('reseller_contact_number')->nullable();

            $table->string('status', 50)->nullable(); // e.g., 'draft', 'issued', 'shipping', 'sent', 'completed'
            // $table->smallInteger('jumlah')->nullable(); tidak perlu ada detail jumlah disini, karena sudah ada di spk_produk_nota_srjalan
            $table->string('item_type',30)->nullable()->default('Sarung Jok Motor');
            $table->string('packing_type',30)->nullable(); // e.g., 'box', 'bag', 'roll', 'piece', 'colly', 'dus
            $table->smallInteger('amount')->nullable();
            // Data ketika selesai
            // Keterangan Lain
            $table->string('description')->nullable();
            
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamp('finished_at')->nullable();
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
        Schema::dropIfExists('delivery_notes');
    }
};
