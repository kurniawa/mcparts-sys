<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\WorkOrder;
use App\Models\WorkOrderProduct;
use DB;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class FixDataAfterFreshSeeding extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fix-data-after-fresh-seeding';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // /**
        //  * @var mixed
        //  * Menambahkan $product_price->product_name dan $product_price->product_invoice_name
        //  * Berdasarkan data yang ada di tabel products.
        //  */
        // $product_prices = \App\Models\ProductPrice::all();
        // foreach ($product_prices as $product_price) {
        //     $product = \App\Models\Product::find($product_price->product_id);
        //     if ($product) {
        //         $product_price->product_name = $product->name;
        //         $product_price->product_invoice_name = $product->invoice_name;
        //         $product_price->save();
        //     }
        // }

        // /**
        //  * Migrasi data work_orders pada database baru dari data spk pada database lama
        //  */
        // // Ambil semua data spk dari database lama
        // // $this->info("Jumlah SPK yang ditemukan: " . DB::connection('mysql_old')->table('spks')->count());
        // DB::connection('mysql_old')->table('spks')->orderBy('id')->chunk(500, function ($spks) {
        //     // $this->info("Mulai migrasi work_orders...");
        //     foreach ($spks as $spk) {
        //         try {
        //             WorkOrder::create([
        //                 'id' => $spk->id,
        //                 'wo_number' => $spk->no_spk,
        //                 'customer_id' => $spk->pelanggan_id,
        //                 'reseller_id' => $spk->reseller_id,
        //                 'status' => $spk->status,
        //                 'invoice_status' => $spk->status_nota,
        //                 'delivery_note_status' => $spk->status_srjalan,
        //                 'copy' => 1,
        //                 'title' => $spk->keterangan,
        //                 'completed_amount' => $spk->jumlah_selesai,
        //                 'total_amount' => $spk->jumlah_total,
        //                 'total_price' => $spk->harga_total,
        //                 'amount_in_invoice' => $spk->jumlah_sudah_nota,
        //                 'amount_in_delivery_note' => $spk->jumlah_sudah_srjalan,
        //                 'customer_name' => $spk->pelanggan_nama,
        //                 'customer_short_address' => $spk->cust_short,
        //                 'reseller_name' => $spk->reseller_nama,
        //                 'reseller_short_address' => $spk->reseller_short,
        //                 'created_by' => $spk->created_by,
        //                 'updated_by' => $spk->updated_by,
        //                 'finished_at' => $spk->finished_at,
        //                 'created_at' => $spk->created_at,
        //                 'updated_at' => $spk->updated_at,
        //             ]);
        //             // $this->info("Memproses SPK ID: {$spk->id}");
        //         } catch (\Exception $e) {
        //             Log::error("Gagal migrasi SPK ID {$spk->id}: " . $e->getMessage());
        //         }
        //     }
        // });

        // DB::connection('mysql_old')->table('spk_produks')->orderBy('id')->chunk(500, function ($spk_produks) {
        //     foreach ($spk_produks as $spk_produk) {
        //         $product = Product::find($spk_produk->produk_id);
        //         try {
        //             WorkOrderProduct::create([
        //                 'id' => $spk_produk->id,
        //                 'wo_id' => $spk_produk->spk_id,
        //                 'product_id' => $spk_produk->produk_id,
        //                 'product_name' => $product->name,
        //                 'description' => $spk_produk->keterangan,
        //                 'amount' => $spk_produk->jumlah,
        //                 'deviation_amount' => $spk_produk->jumlah_deviasi,
        //                 'total_amount' => $spk_produk->jumlah_total,
        //                 'completed_amount' => $spk_produk->jumlah_selesai,
        //                 'amount_on_invoice' => $spk_produk->jumlah_sudah_nota,
        //                 'amount_on_delivery_note' => $spk_produk->jumlah_sudah_srjalan,
        //                 'actual_price' => $spk_produk->koreksi_harga,
        //                 // 'customer_price' => $spk_produk->harga_khusus_pelanggan,
        //                 // 'discount_percentage' => $spk_produk->persen_diskon,
        //                 // 'discount_price' => $spk_produk->harga_diskon,
        //                 // 'price_type' => $spk_produk->jenis_harga,
        //                 'status' => $spk_produk->status,
        //                 // 'product_price_id' => $spk_produk->harga_produk_id,
        //                 // 'created_by' => $spk_produk->created_by,
        //                 // 'updated_by' => $spk_produk->updated_by,
        //                 // 'finished_at' => $spk_produk->finished_at,
        //                 'created_at' => $spk_produk->created_at,
        //                 'updated_at' => $spk_produk->updated_at,
        //             ]);
        //             // $this->info("Memproses SPK ID: {$spk->id}");
        //         } catch (\Exception $e) {
        //             Log::error("Gagal migrasi SPK ID {$spk_produk->id}: " . $e->getMessage());
        //         }
        //     }
        // });

        // test create WorkOrderProduct
        WorkOrderProduct::create([
            'wo_id' => 1,
            'product_id' => 1,
            'product_name' => 'Contoh Produk',
            'description' => 'Deskripsi produk contoh',
            'amount' => 10,
            'deviation_amount' => 0,
            'total_amount' => 10,
            'completed_amount' => 10,
            'amount_on_invoice' => 10,
            'amount_on_delivery_note' => 10,
            'actual_price' => null,
            // 'customer_price' => null,
            // 'discount_percentage' => null,
            // 'discount_price' => null,
            // 'price_type' => null,
            // 'product_price_id' => null,
            // 'status' => null,
        ]);

        $this->info('Data telah diperbaiki dan migrasi SPK selesai.');
    }
}
