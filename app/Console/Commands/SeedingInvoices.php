<?php

namespace App\Console\Commands;

use App\Models\Address;
use App\Models\ContactNumber;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\WorkOrder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SeedingInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:seeding-invoices';

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
        // invoices
        $this->info('Seeding Invoices...');
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
                        'issued_at' => $nota->created_at,
                        'finished_at' => $nota->finished_at,
                        'created_at' => $nota->created_at,
                        'updated_at' => $nota->updated_at,
                    ]);
                } catch (\Exception $e) {
                    Log::error("Gagal migrasi INVOICE ID {$nota->id}: " . $e->getMessage());
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
                        $customer = Customer::where('name', $pelanggan->nama)->first();
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
                        'product_price_id' => $spk_produk_nota->produk_harga_id,
                        'product_invoice_name' => $spk_produk_nota->nama_nota,
                        'unit_price' => $spk_produk_nota->harga,
                        'total_price' => $spk_produk_nota->harga_t,
                        'created_at' => $spk_produk_nota->created_at,
                        'updated_at' => $spk_produk_nota->updated_at,
                    ]);
                } catch (\Exception $e) {
                    Log::error("Gagal migrasi WORK_ORDER_ITEM_INVOICE ID {$spk_produk_nota->id}: " . $e->getMessage());
                }
            }
        });
    }
}
