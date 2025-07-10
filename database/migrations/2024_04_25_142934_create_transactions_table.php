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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // user_id juga di perulukan, apabila semisal untuk entry pengeluaran yang tidak ada kaitannya dengan pembelian pelanggan
            $table->bigInteger('time_key'); // pada saat sorting dan filter, sulit apabila hanya mengandalkan surat_pembelian_id saja, karena mungkin saja terjadi penjualan pada surat_id terkait, sehingga sulit membentuk collection nya pada halaman index neraca.
            $table->string('accounting_code'); // Untuk mengidentifikasi Accounting yang terkait dengan cashflow ini
            $table->string('reference_table', 50)->nullable(); // invoice, purchases
            $table->foreignId('reference_id')->nullable(); // nullable karena pemasukan bisa jadi belum tentu dari pembelian item perhiasan
            $table->enum('type', ['income', 'expenses']);
            $table->string('transaction_method', 20)->nullable(); // bank transfer
            $table->string('transaction_type', 20)->nullable(); // tunai, non-tunai
            $table->string('wallet_type', 20)->nullable(); // tunai, bank, e-wallet
            $table->string('wallet_name', 20)->nullable(); // tunai, bca, bri, bni, mandiri, ovo, gopay, dana, dll.
            $table->decimal('amount', 15, 2); // maks 999 Triliun
            $table->decimal('initial_balance', 15, 2)->default(0);
            $table->decimal('current_balance', 15, 2)->default(0);
            $table->string('notes')->nullable();
            $table->date('transaction_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
