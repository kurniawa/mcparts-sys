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
        if (!Schema::hasTable('notas')) {
            Schema::create('notas', function (Blueprint $table) {
                $table->id();
                $table->string('no_nota', 20)->nullable();
                // Data Customer
                $table->foreignId('pelanggan_id')->nullable()->constrained('pelanggans')->onDelete('SET NULL');
                $table->foreignId('alamat_id')->nullable()->constrained()->onDelete('SET NULL');
                $table->foreignId('kontak_id')->nullable()->constrained('pelanggan_kontaks')->onDelete('SET NULL');
                $table->string('pelanggan_nama',100)->nullable();
                $table->string('cust_long')->nullable();
                $table->string('cust_short')->nullable();
                $table->string('cust_kontak')->nullable();
                // Data Reseller
                $table->foreignId('reseller_id')->nullable()->constrained('pelanggans')->onDelete('SET NULL');
                $table->foreignId('alamat_reseller_id')->nullable()->constrained('alamats')->onDelete('SET NULL');
                $table->foreignId('kontak_reseller_id')->nullable()->constrained('pelanggan_kontaks')->onDelete('SET NULL');
                $table->string('reseller_nama',100)->nullable();
                $table->string('reseller_long')->nullable();
                $table->string('reseller_short')->nullable();
                $table->string('reseller_kontak')->nullable();
    
                $table->mediumInteger('jumlah_total')->nullable();
                $table->bigInteger('harga_total')->nullable();
                $table->bigInteger('sisa_bayar');
                $table->string('keterangan')->nullable();
                $table->string('status_bayar', 20)->default('BELUM-LUNAS'); // BELUM-LUNAS, LUNAS-SEBAGIAN, LUNAS
                // $table->string('status_sj', 50)->default('BELUM');// Keliatannya sih tidak diperlukan
                // $table->integer('jumlah_sj')->nullable()->default(0);
                $table->string('created_by');
                $table->string('updated_by');
                $table->timestamp('tanggal_lunas')->nullable();
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
        Schema::dropIfExists('notas');
    }
};
