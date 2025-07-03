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
        Schema::create('work_order_item_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wo_id')->nullable()->constrained('work_orders')->onDelete('CASCADE');
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('SET NULL');
            $table->foreignId('work_order_item_id')->nullable()->constrained()->onDelete('SET NULL');
            $table->foreignId('invoice_id')->nullable()->constrained()->onDelete('CASCADE');
            $table->foreignId('customer_id')->nullable()->constrained()->onDelete('set null');
            $table->string('customer_name', 100)->nullable();
            $table->smallInteger('amount');
            $table->foreignId('product_price_id')->nullable()->constrained()->onDelete('SET NULL'); // Ini perlu untuk acuan dalam pengeditan harga nantinya
            // $table->foreignId('pelanggan_produk_id')->nullable()->constrained()->onDelete('SET NULL');
            $table->foreignId('product_name')->nullable();
            // Nota Selesai: Acuan nya ternyata sudah harga dan harga_t dibawah ini:
            $table->string('product_invoice_name')->nullable();
            $table->decimal('unit_price', 15, 2);
            $table->decimal('total_price', 15, 2);
            $table->string('description')->nullable();
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
        Schema::dropIfExists('work_order_item_invoices');
    }
};
