<?php

namespace App\Console\Commands;

use App\Models\Address;
use App\Models\ContactNumber;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\WorkOrder;
use App\Models\WorkOrderInvoice;
use App\Models\WorkOrderItem;
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
        /**
         * @var mixed
         * Menambahkan $product_price->product_name dan $product_price->product_invoice_name
         * Berdasarkan data yang ada di tabel products.
         */
        $product_prices = \App\Models\ProductPrice::all();
        foreach ($product_prices as $product_price) {
            $product = Product::find($product_price->product_id);
            if ($product) {
                $product_price->product_name = $product->name;
                $product_price->product_invoice_name = $product->invoice_name;
                $product_price->save();
            }
        }

        /**
         * Migrasi data work_orders pada database baru dari data spk pada database lama
         */
        // Ambil semua data spk dari database lama
        // $this->info("Jumlah SPK yang ditemukan: " . DB::connection('mysql_old')->table('spks')->count());
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

        // invoices
        DB::connection('mysql_old')->table('notas')->orderBy('id')->chunk(500, function ($notas) {
            // Log::info("Chunk ditemukan dengan jumlah: " . count($notas));
            foreach ($notas as $nota) {
                // Contact Numbers
                $customer_contact_number_id = $nota->kontak_id;
                $customer_contact_number = null;
                if ($nota->cust_kontak) {
                    $nota_cust_kontak = json_decode($nota->cust_kontak, true);
                    $customer_contact_number = $nota_cust_kontak['nomor'] ?? null;
                    if ($customer_contact_number) {
                        $contact_number = ContactNumber::where('owner_type', 'customer')
                            ->where('owner_name', $nota->pelanggan_nama)
                            ->where('number', $customer_contact_number)
                            ->first();
                        if ($contact_number) {
                            $customer_contact_number_id = $contact_number->id;
                        } else {
                            Log::warning("[WARNING] Nomor kontak tidak ditemukan untuk customer: " . $nota->pelanggan_nama . " dengan nomor: " . $customer_contact_number);
                            $customer_contact_number_id = null;
                        }
                    }
                    if (isset($nota_cust_kontak['kodearea']) && $nota_cust_kontak['kodearea']) {
                        $customer_contact_number = $nota_cust_kontak['kodearea'] . '-' . $customer_contact_number;
                    }
                    
                }

                $reseller_contact_number_id = $nota->kontak_reseller_id;
                $reseller_contact_number = null;
                if ($nota->reseller_kontak) {
                    $nota_reseller_kontak = json_decode($nota->reseller_kontak, true);
                    $reseller_contact_number = $nota_reseller_kontak['nomor'] ?? null;

                    if ($reseller_contact_number) {
                        $contact_number = ContactNumber::where('owner_type', 'customer')
                            ->where('owner_name', $nota->reseller_nama)
                            ->where('number', $nota_reseller_kontak['nomor'])
                            ->first();
                        if ($contact_number) {
                            $reseller_contact_number_id = $contact_number->id;
                        } else {
                            Log::warning("[WARNING] Nomor kontak tidak ditemukan untuk reseller: " . $nota->reseller_nama . " dengan nomor: " . $reseller_contact_number);
                            $reseller_contact_number_id = null;
                        }
                    }
                    if (isset($nota_reseller_kontak['kodearea']) && $nota_reseller_kontak['kodearea']) {
                        $reseller_contact_number = $nota_reseller_kontak['kodearea'] . '-' . $reseller_contact_number;
                    }
                }

                // Addresses
                $customer_address_id = null;
                $customer_full_address = null;
                $customer_short_address = null;
                if ($nota->alamat_id) {
                    $customer_address = Address::where('owner_type', 'customer')
                        ->where('owner_id', $nota->pelanggan_id)
                        ->first();
                    $customer_address_id = $customer_address->id;
                    $customer_full_address = $customer_address->full_address;
                    $customer_short_address = $customer_address->short_address;
                }

                $reseller_address_id = null;
                $reseller_full_address = null;
                $reseller_short_address = null;
                if ($nota->alamat_id) {
                    $reseller_address = Address::where('owner_type', 'customer')
                        ->where('owner_id', $nota->pelanggan_id)
                        ->first();
                    $reseller_address_id = $reseller_address->id;
                    $reseller_full_address = $reseller_address->full_address;
                    $reseller_short_address = $reseller_address->short_address;
                }

                try {
                    Invoice::create([
                        'id' => $nota->id,
                        'invoice_number' => $nota->no_nota,
                        'customer_id' => $nota->pelanggan_id,
                        'customer_address_id' => $customer_address_id,
                        'customer_contact_number_id' => $customer_contact_number_id,
                        'customer_name' => $nota->pelanggan_nama,
                        'customer_full_address' => $customer_full_address,
                        'customer_short_address' => $customer_short_address,
                        'customer_contact_number' => $customer_contact_number,
                        'reseller_id' => $nota->reseller_id,
                        'reseller_address_id' => $reseller_address_id,
                        'reseller_contact_number_id' => $reseller_contact_number_id,
                        'reseller_name' => $nota->reseller_nama,
                        'reseller_full_address' => $reseller_full_address,
                        'reseller_short_address' => $reseller_short_address,
                        'reseller_contact_number' => $reseller_contact_number,

                        'total_amount' => $nota->jumlah_total,
                        'total_price' => $nota->harga_total,
                        'remaining_payment' => null,
                        'description' => $nota->keterangan,
                        'payment_status' => 'unpaid',

                        // 'paid_off_date' => $nota->tanggal_lunas,
                        'created_by' => $nota->created_by,
                        'updated_by' => $nota->updated_by,
                        // 'deleted_at' => $nota->deleted_at,
                        // 'deleted_by' => $nota->deleted_by,
                        // 'deleted_reason' => $nota->deleted_reason,
                        'finished_at' => $nota->finished_at,
                        'created_at' => $nota->created_at,
                        'updated_at' => $nota->updated_at,
                    ]);
                } catch (\Exception $e) {
                    Log::error("Gagal migrasi INVOICE ID {$nota->id}: " . $e->getMessage());
                }
            }
        });

        // Work Order Invoices
        DB::connection('mysql_old')->table('spk_notas')->orderBy('id')->chunk(500, function ($spk_notas) {
            foreach ($spk_notas as $spk_nota) {
                $work_order = WorkOrder::find($spk_nota->spk_id);
                if (!$work_order) {
                    Log::warning("[WARNING] Tidak diinput - Work Order Invoices. Work Order ID {$spk_nota->spk_id} tidak ditemukan untuk SPK Nota ID {$spk_nota->id}.");
                    continue; // Skip this invoice if the work order does not exist
                }
                try {
                    WorkOrderInvoice::create([
                        'id' => $spk_nota->id,
                        'wo_id' => $spk_nota->spk_id,
                        'invoice_id' => $spk_nota->nota_id,
                    ]);
                } catch (\Exception $e) {
                    Log::error("Gagal migrasi WORK_ORDER_INVOICE ID {$spk_nota->id}: " . $e->getMessage());
                }
            }
        });
        
        
        // Work Order Item Invoices
        DB::connection('mysql_old')->table('spk_produk_notas')->orderBy('id')->chunk(500, function ($spk_produk_notas) {
            foreach ($spk_produk_notas as $spk_produk_nota) {
                $work_order = WorkOrder::find($spk_produk_nota->spk_id);
                if (!$work_order) {
                    Log::warning("[WARNING] Tidak diinput - Work Order Item Invoices. Work Order ID {$spk_produk_nota->spk_id} tidak ditemukan untuk SPK Produk Nota ID {$spk_produk_nota->id}.");
                    continue; // Skip this product if the work order does not exist
                }
                $customer_id = null;
                $customer_name = null;
                if ($spk_produk_nota->pelanggan_id) {
                    $pelanggan = DB::connection('mysql_old')->table('pelanggans')->where('id', $spk_produk_nota->pelanggan_id)->first();
                    if ($pelanggan) {
                        $customer = Customer::where('customer_name', $pelanggan->nama)->first();
                        if ($customer) {
                            $customer_id = $customer->id;
                            $customer_name = $customer->name;
                        }
                    }
                }
                try {
                    DB::table('work_order_item_invoices')->insert([
                        'id' => $spk_produk_nota->id,
                        'wo_id' => $spk_produk_nota->spk_id,
                        'product_id' => $spk_produk_nota->produk_id,
                        'work_order_item_id' => $spk_produk_nota->spk_produk_id,
                        'invoice_id' => $spk_produk_nota->nota_id,
                        'customer_id' => $customer_id,
                        'customer_name' => $customer_name,
                        'amount' => $spk_produk_nota->jumlah,
                        'product_price_id' => $spk_produk_nota->harga_id,
                        'product_name' => $spk_produk_nota->nama_produk,
                        'product_invoice_name' => $spk_produk_nota->nama_nota,
                        'unit_price' => $spk_produk_nota->harga_satuan,
                        'total_price' => $spk_produk_nota->harga_total,
                        'created_at' => $spk_produk_nota->created_at,
                        'updated_at' => $spk_produk_nota->updated_at,
                    ]);
                } catch (\Exception $e) {
                    Log::error("Gagal migrasi WORK_ORDER_ITEM_INVOICE ID {$spk_produk_nota->id}: " . $e->getMessage());
                }
            }
        });

        $this->info('Data telah diperbaiki dan migrasi SPK selesai.');
    }
}
