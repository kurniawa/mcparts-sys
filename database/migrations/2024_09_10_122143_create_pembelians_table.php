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
        if (!Schema::hasTable('pembelians')) {
            Schema::create('pembelians', function (Blueprint $table) {
                $table->id();
                $table->string('nomor_nota', 20)->nullable();
                // Data Customer
                $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->onDelete('SET NULL');
                $table->foreignId('supplier_alamat_id')->nullable()->constrained()->onDelete('SET NULL');
                $table->foreignId('supplier_kontak_id')->nullable()->constrained('supplier_kontaks')->onDelete('SET NULL');
                $table->string('supplier_nama',100)->nullable();
                $table->string('supplier_long')->nullable();
                $table->string('supplier_short')->nullable();
                $table->string('supplier_kontak')->nullable();
    
                $table->string('isi')->nullable();
                $table->string('keterangan')->nullable();
    
                $table->bigInteger('harga_total')->nullable();
                $table->bigInteger('sisa_bayar');
                $table->string('status_bayar', 20)->default('BELUM-LUNAS'); // BELUM-LUNAS, LUNAS-SEBAGIAN, LUNAS
                $table->string('keterangan_bayar')->nullable();
                // $table->string('status_sj', 50)->default('BELUM');// Keliatannya sih tidak diperlukan
                // $table->integer('jumlah_sj')->nullable()->default(0);
                $table->timestamp('tanggal_lunas')->nullable();
                $table->timestamps();
                $table->string('created_by');
                $table->string('updated_by');
                // Data ketika selesai
                
                // Keterangan Lain
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelians');
    }
};
