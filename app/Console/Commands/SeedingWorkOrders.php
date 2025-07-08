<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\WorkOrder;
use App\Models\WorkOrderItem;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SeedingWorkOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:seeding-work-orders';

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
        /**
         * Migrasi data work_orders pada database baru dari data spk pada database lama
         */
        // Ambil semua data spk dari database lama
        $this->info("Seeding Work Orders ...");
        DB::connection('mysql_old')->table('spks')->orderBy('id')->chunk(500, function ($spks) {
            // $this->info("Mulai migrasi work_orders...");
            foreach ($spks as $spk) {
                try {
                    WorkOrder::create([
                        'id' => $spk->id,
                        'wo_number' => $spk->no_spk,
                        'customer_id' => $spk->pelanggan_id,
                        'reseller_id' => $spk->reseller_id,
                        'status' => $spk->status,
                        'invoice_status' => $spk->status_nota,
                        'delivery_note_status' => $spk->status_srjalan,
                        'copy' => 1,
                        'title' => $spk->keterangan,
                        'completed_amount' => $spk->jumlah_selesai,
                        'total_amount' => $spk->jumlah_total,
                        'total_price' => $spk->harga_total,
                        'amount_in_invoice' => $spk->jumlah_sudah_nota,
                        'amount_in_delivery_note' => $spk->jumlah_sudah_srjalan,
                        'customer_name' => $spk->pelanggan_nama,
                        'customer_short_address' => $spk->cust_short,
                        'reseller_name' => $spk->reseller_nama,
                        'reseller_short_address' => $spk->reseller_short,

                        'created_by' => $spk->created_by,
                        'updated_by' => $spk->updated_by,
                        'issued_at' => $spk->created_at,
                        'finished_at' => $spk->finished_at,
                        'created_at' => $spk->created_at,
                        'updated_at' => $spk->updated_at,
                    ]);
                    // $this->info("Memproses SPK ID: {$spk->id}");
                } catch (\Exception $e) {
                    Log::error("Gagal migrasi SPK ID {$spk->id}: " . $e->getMessage());
                }
            }
        });

        // work_order_items
        DB::connection('mysql_old')->table('spk_produks')->orderBy('id')->chunk(500, function ($spk_produks) {
            // Log::info("Chunk ditemukan dengan jumlah: " . count($spk_produks));
            foreach ($spk_produks as $spk_produk) {
                $product_name = null;
                $product = Product::find($spk_produk->produk_id);
                if (!$product) {
                    Log::warning("Produk ID {$spk_produk->produk_id} tidak ditemukan.");
                } else {
                    $product_name = $product->name;
                }
                // cek apakah work order benar-benar ada
                $wo_id = $spk_produk->spk_id;
                $work_order = WorkOrder::find($spk_produk->spk_id);
                if (!$work_order) {
                    Log::warning("[WARNING] Tidak diinput Work Order Item. Work Order ID {$spk_produk->spk_id} tidak ditemukan untuk SPK Produk ID {$spk_produk->id}.");
                    continue; // Skip this product if the work order does not exist
                }
                try {
                    WorkOrderItem::create([
                        'id' => $spk_produk->id,
                        'wo_id' => $wo_id,
                        'product_id' => $spk_produk->produk_id,
                        'product_name' => $product->name,
                        'description' => $spk_produk->keterangan,
                        'amount' => $spk_produk->jumlah,
                        'deviation_amount' => $spk_produk->deviasi_jumlah,
                        'total_amount' => $spk_produk->jumlah_total,
                        'completed_amount' => $spk_produk->jumlah_selesai,
                        'amount_on_invoice' => $spk_produk->jumlah_sudah_nota,
                        'amount_on_delivery_note' => $spk_produk->jumlah_sudah_srjalan,
                        'actual_price' => $spk_produk->koreksi_harga,
                        'status' => $spk_produk->status,
                        'created_at' => $spk_produk->created_at,
                        'updated_at' => $spk_produk->updated_at,
                    ]);
                } catch (\Exception $e) {
                    Log::error("Gagal migrasi SPK_PRODUK ID {$spk_produk->id}: " . $e->getMessage());
                }
            }
        });
    }
}
