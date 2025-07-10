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
        Schema::create('accountings', function (Blueprint $table) {
            $table->id();
            $table->string('accounting_code'); // Untuk Identifikasi ke Cashflow yang mana yang terkait dengan entry accounting ini
            $table->string('reference_table', 50)->nullable();
            $table->foreignId('reference_id')->nullable()->constrained()->onDelete('cascade')->onUpdate('cascade'); // identifikasi surat atau item yang terkait
            $table->string('name')->nullable(); // identifikasi nama barang dan untuk mempermudah sorting, apabila diperlukan
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null')->onUpdate('cascade');
            $table->string('username', 50)->nullable();
            $table->foreignId('supplier_id')->nullable()->constrained()->onDelete('set null');
            $table->string('supplier_name')->nullable();
            $table->enum('transaction_type', ['income', 'expenses']);
            $table->foreignId('category_id')->nullable()->constrained('category_trees');
            $table->string('category_name', 50)->nullable();
            $table->string('notes')->nullable();
            $table->decimal('amount', 15, 2);
            $table->timestamps();
            $table->timestamp('accounting_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accountings');
    }
};
