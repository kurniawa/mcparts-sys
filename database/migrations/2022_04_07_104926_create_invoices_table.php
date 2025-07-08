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
        if (!Schema::hasTable('invoices')) {
            Schema::create('invoices', function (Blueprint $table) {
                $table->id();
                $table->string('invoice_number')->nullable()->unique();
                // Data Customer
                $table->foreignId('customer_id')->nullable()->constrained()->onDelete('SET NULL');
                $table->foreignId('customer_address_id')->nullable()->constrained('addresses')->onDelete('SET NULL');
                $table->foreignId('customer_contact_number_id')->nullable()->constrained('contact_numbers')->onDelete('SET NULL');
                $table->string('customer_name',100)->nullable();
                $table->string('customer_full_address')->nullable();
                $table->string('customer_short_address')->nullable();
                $table->string('customer_contact_number')->nullable();
                // Data Reseller
                $table->foreignId('reseller_id')->nullable()->constrained('customers')->onDelete('SET NULL');
                $table->foreignId('reseller_address_id')->nullable()->constrained('addresses')->onDelete('SET NULL');
                $table->foreignId('reseller_contact_number_id')->nullable()->constrained('contact_numbers')->onDelete('SET NULL');
                $table->string('reseller_name',100)->nullable();
                $table->string('reseller_full_address')->nullable();
                $table->string('reseller_short_address')->nullable();
                $table->string('reseller_contact_number')->nullable();
    
                $table->mediumInteger('total_amount')->nullable();
                $table->decimal('total_price', 15, 2)->nullable();
                $table->decimal('remaining_payment', 15, 2)->nullable();
                $table->string('description')->nullable();
                $table->string('payment_status', 20)->nullable();  // e.g., 'unpaid', 'paid', 'partial', 'overdue'

                $table->timestamp('paid_off_date')->nullable();
                $table->string('created_by');
                $table->string('updated_by');
                $table->timestamp('deleted_at')->nullable(); // Soft delete
                $table->string('deleted_by', 50)->nullable(); // User who deleted the record, if applicable
                $table->string('deleted_reason', 255)->nullable(); // Reason for deletion, if applicable
                $table->timestamp('issued_at')->nullable();
                $table->timestamp('finished_at')->nullable();
                // Data ketika selesai
                
                // Keterangan Lain
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
};
