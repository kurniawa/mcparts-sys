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
        Schema::create('work_order_invoice_delivery_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wo_id')->nullable()->constrained('work_orders')->onDelete('CASCADE');
            $table->foreignId('invoice_id')->nullable()->constrained()->onDelete('CASCADE');
            $table->foreignId('delivery_id')->nullable()->constrained('delivery_notes')->onDelete('set null'); // Boleh null karena invoice dibuat terlebih dahulu sebelum ada surat jalan
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
        Schema::dropIfExists('work_order_invoice_delivery_notes');
    }
};
