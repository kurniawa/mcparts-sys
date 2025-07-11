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
        Schema::create('work_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wo_id')->constrained('work_orders')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('SET NULL');
            $table->string('product_name')->nullable(); // nama produk nullable mungkin karena tadinya memang tidak perlu diisi, tetapi nanti ke depannya untuk database aslinya diubah tidak nullable
            $table->string('description',1000)->nullable(); // Deskripsi produk atau item yang dikerjakan
            $table->smallInteger('amount');
            $table->smallInteger('deviation_amount')->nullable();
            $table->smallInteger('total_amount')->nullable();
            $table->smallInteger('completed_amount')->nullable();
            $table->smallInteger('amount_on_invoice')->nullable();
            $table->smallInteger('amount_on_delivery_note')->nullable();
            $table->decimal('initial_price', 15, 2)->nullable(); // Harga dasar produk, bisa diambil dari tabel product_prices
            $table->decimal('actual_price', 15, 2)->nullable();
            $table->smallinteger('discount_value')->nullable();
            $table->decimal('discounted_price', 15, 2)->nullable();
            $table->string('price_type', 50)->nullable(); // e.g. "standar-price", "discounted-price", "customer-price".
            $table->foreignId('product_price_id')->nullable()->constrained('product_prices')->onDelete('SET NULL');
            $table->string('status', 20)->nullable(); // Status yang berkaitan dengan sudah selesai di produksi atau belum
            // $table->string('data_selesai')->nullable();
            // $table->string('data_nota')->nullable();
            // $table->string('data_srjalan')->nullable();
            // $table->string('status_nota')->nullable()->default('BELUM');
            // $table->string('status_srjalan')->nullable()->default('BELUM');
            // Ketika SPK Selesai: tanggal, nama_produk
            $table->string('created_by', 50)->nullable();
            $table->string('updated_by', 50)->nullable();
            $table->timestamp('deleted_at')->nullable(); // Soft delete
            $table->string('deleted_by', 50)->nullable(); // User who deleted the record, if applicable
            $table->string('deleted_reason', 255)->nullable(); // Reason for deletion, if applicable
            $table->timestamp('finished_at')->nullable();
            $table->timestamps();
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_order_items');
    }
};
