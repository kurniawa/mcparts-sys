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
        // Chart of Accounts
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique(); // e.g. '1101', '5201'
            $table->string('name', 100);
            $table->string('type', 20);           // e.g. 'asset', 'liability', 'expense', 'income', 'equity'
        });

        // Journal Entries (Header)
        Schema::create('journal_entries', function (Blueprint $table) {
            $table->id();
            $table->date('journal_date');
            $table->string('reference', 100)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Journal Entry Lines (Details)
        Schema::create('journal_entry_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('journal_entry_id')->constrained('journal_entries')->onDelete('cascade');
            $table->foreignId('account_id')->constrained('accounts');
            $table->decimal('debit', 18, 2)->default(0.00);
            $table->decimal('credit', 18, 2)->default(0.00);
            $table->text('memo')->nullable();
        });

        // Purchases (linked optionally to journal)
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers');
            $table->string('invoice_number', 100)->nullable();
            $table->date('purchase_date');
            $table->decimal('total_amount', 18, 2);
            $table->text('description')->nullable();
            $table->foreignId('journal_entry_id')->nullable()->constrained('journal_entries');
            $table->timestamps();
        });

        // Salaries
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->string('employee_name');
            $table->date('salary_date');
            $table->decimal('amount', 18, 2);
            $table->text('description')->nullable();
            $table->foreignId('journal_entry_id')->nullable()->constrained('journal_entries');
            $table->timestamps();
        });

        // General Expenses
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->date('expense_date');
            $table->string('category'); // e.g. utilities, marketing, travel
            $table->decimal('amount', 18, 2);
            $table->string('vendor')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('journal_entry_id')->nullable()->constrained('journal_entries');
            $table->timestamps();
        });

        // Assets
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('acquired_date');
            $table->decimal('value', 18, 2);
            $table->integer('useful_life_months'); // for depreciation
            $table->text('description')->nullable();
            $table->foreignId('journal_entry_id')->nullable()->constrained('journal_entries');
            $table->timestamps();
        });

        // Tax Payments
        Schema::create('tax_payments', function (Blueprint $table) {
            $table->id();
            $table->string('tax_type'); // e.g. PPN, PPh
            $table->date('payment_date');
            $table->decimal('amount', 18, 2);
            $table->text('description')->nullable();
            $table->foreignId('journal_entry_id')->nullable()->constrained('journal_entries');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tax_payments');
        Schema::dropIfExists('assets');
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('salaries');
        Schema::dropIfExists('purchases');
        Schema::dropIfExists('journal_entry_lines');
        Schema::dropIfExists('journal_entries');
        Schema::dropIfExists('accounts');
    }
};
/**
 * Penjelasan Tentang kolom reference
 * | Tujuan            | Format yang umum dipakai      |
 * | ----------------- | ----------------------------- |
 * | Invoice pembelian | `INV-2401`, `PB-2025-001`     |
 * | Penjualan         | `SO-2401`, `INV-SALES-01`     |
 * | Gaji              | `PAY-2025-07`, `SAL-20250701` |
 * | Aset              | `AST-0001`, `MESIN-2025-01`   |
 *
 * Penjelasan tentang tipe akun
 * | Kode | Nama Akun        | Tipe      |
 * | ---- | ---------------- | --------- |
 * | 1101 | Kas              | Asset     |
 * | 1201 | Bank             | Asset     |
 * | 1501 | Mesin Produksi   | Asset     |
 * | 2101 | Utang Usaha      | Liability |
 * | 3101 | Modal Pemilik    | Equity    |
 * | 4101 | Penjualan Produk | Income    |
 * | 5101 | Pembelian Bahan  | Expense   |
 * | 5201 | Gaji Karyawan    | Expense   |
 * | 5301 | Biaya Listrik    | Expense   |
 * | 5401 | Pajak            | Expense   |
 * 
 */

