<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class GenerateWorkOrdersJSON extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-work-orders-j-s-o-n';

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
        $work_orders = [];
        $filename = "work_orders";
        DB::connection('mysql_old')->table('spks')->orderBy('id')->chunk(500, function ($items) {
            // $this->info("Mulai migrasi work_orders...");
            foreach ($items as $item) {
                $temp = [];
                $temp['id'] = $item->id;
                $temp['wo_number'] = $item->no_spk;
                $temp['customer_id'] = $item->pelanggan_id;
                $temp['reseller_id'] = $item->reseller_id;
                $temp['status'] = $item->status;
                $temp['invoice_status'] = $item->status_nota;
                $temp['delivery_nota_status'] = $item->status_srjalan;
                $temp['copy'] = 1;
                $temp['title'] = $item->keterangan;
                $temp['completed_amount'] = $item->jumlah_selesai;
                $temp['total_amount'] = $item->jumlah_total;
                $temp['total_price'] = $item->harga_total;
                $temp['amount_in_invoice'] = $item->jumlah_sudah_nota;
                $temp['amount_in_delivery_note'] = $item->jumlah_sudah_srjalan;
                $temp['customer_name'] = $item->pelanggan_nama;
                $temp['customer_short_address'] = $item->cust_short;
                $temp['reseller_name'] = $item->reseller_nama;
                $temp['reseller_short_address'] = $item->reseller_short;

                $temp['created_by'] = $item->created_by;
                $temp['updated_by'] = $item->updated_by;
                $temp['issued_at'] = $item->created_at;
                $temp['finished_at'] = $item->finished_at;
                $temp['created_at'] = $item->created_at;
                $temp['updated_at'] = $item->updated_at;

                $work_orders = array_merge($work_orders, $temp);
            }
        });

        File::put(storage_path("backup/$filename.json"), json_encode($work_orders));
        echo "Backup berhasil disimpan ke storage/backup/$filename.json\n";

        // work_order_items
        $work_order_items = [];
        $filename = "work_order_items";
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
