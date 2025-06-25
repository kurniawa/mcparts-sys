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
        Schema::create('product_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('supplier_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('customer_id')->nullable()->constrained()->onDelete('set null'); // Untuk harga khusus customer tertentu.
            $table->foreignId('reseller_id')->nullable()->constrained('customers')->onDelete('set null'); // Untuk customer yang memiliki reseller.
            $table->string('product_name', 100)->nullable();
            $table->string('product_invoice_name', 100)->nullable();
            $table->string('supplier_name', 100)->nullable();
            $table->string('customer_name', 100)->nullable();
            $table->string('reseller_name', 100)->nullable();
            $table->decimal('basic_price', 15, 2);
            $table->decimal('customer_price', 15, 2)->nullable(); // Harga khusus untuk customer tertentu.
            $table->smallinteger('discount_percentage')->nullable();
            $table->decimal('discount_price', 15, 2)->nullable();
            $table->string('price_type', 50)->nullable(); // e.g., 'retail', 'wholesale', 'reseller', etc.
            $table->string('price_status', 50)->nullable(); // e.g., 'active', 'inactive', 'archived'
            $table->string('price_category', 50)->nullable(); // e.g., 'default', 'new', 'old', etc. Untuk menandai kategori harga.
            $table->string('price_order', 50)->nullable(); // Order of the price, e.g., '1' for primary, '2' for secondary, etc.
            
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
        Schema::dropIfExists('product_prices');
    }
};
