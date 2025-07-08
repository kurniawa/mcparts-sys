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
        Schema::create('work_orders', function (Blueprint $table) { // work_orders or SPK (Surat Perintah Kerja)
            $table->id();
            $table->string('wo_number')->nullable()->unique();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onDelete('set null');
            $table->foreignId('reseller_id')->nullable()->constrained('customers')->onDelete('set null');
            $table->string('status', 20)->nullable()->default('progress'); // progress, completed
            $table->string('invoice_status', 20)->nullable(); // issued, paid
            $table->string('delivery_note_status', 20)->nullable(); // issued, shipping, sent
            $table->boolean('copy')->nullable()->default(1); // Untuk menandai pada sistem admin
            $table->string('title')->nullable();
            // $table->text('data_spk_item');
            $table->integer('completed_amount')->nullable()->default(0);
            $table->integer('total_amount')->nullable();
            $table->integer('total_price')->nullable();
            $table->integer('amount_in_invoice')->nullable()->default(0);
            $table->integer('amount_in_delivery_note')->nullable()->default(0);
            // SPK Selesai: tanggal, customer_nama, reseller_nama
            $table->string('customer_name',100)->nullable();
            $table->string('customer_short_address')->nullable();
            $table->string('reseller_name',100)->nullable();
            $table->string('reseller_short_address')->nullable();
            $table->string('description')->nullable();

            $table->string('created_by', 50)->nullable();
            $table->string('updated_by', 50)->nullable();
            $table->timestamp('deleted_at')->nullable(); // Soft delete
            $table->string('deleted_by', 50)->nullable(); // User who deleted the record, if applicable
            $table->string('deleted_reason', 255)->nullable(); // Reason for deletion, if applicable
            $table->timestamp('issued_at')->nullable();
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
        Schema::dropIfExists('work_orders');
    }
};
