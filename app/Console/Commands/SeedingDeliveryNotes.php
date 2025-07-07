<?php

namespace App\Console\Commands;

use App\Models\Address;
use App\Models\ContactNumber;
use App\Models\DeliveryNote;
use App\Models\DeliveryNoteExpedition;
use App\Models\WorkOrder;
use App\Models\WorkOrderInvoiceDeliveryNote;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SeedingDeliveryNotes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:seeding-delivery-notes';

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
         * Migrasi data delivery_notes pada database baru dari data srjalans pada database lama
         */
        // Ambil semua data srjalans dari database lama
        $this->info('Seeding Delivery Notes...');
        DB::connection('mysql_old')->table('srjalans')->orderBy('id')->chunk(500, function ($srjalans) {
            foreach ($srjalans as $srjalan) {
                // Data Customer
                $customer_full_address = str_replace('\/', '-', str_replace('"', "'", $srjalan->cust_long));
                $address_id = null;
                $address = Address::where('full', $customer_full_address)->first();
                if ($address) {
                    $address_id = $address->id;
                }

                $customer_contact_number_id = null;
                $customer_contact_number = null;
                if ($srjalan->cust_kontak) {
                    $cust_kontak = json_decode($srjalan->cust_kontak, true);
                    $customer_contact_number = $cust_kontak['nomor'];
                    if (isset($cust_kontak['kodearea'])) {
                        $customer_contact_number = $cust_kontak['kodearea'] . '-' . $cust_kontak['nomor'];
                    }
                    $contact_number = ContactNumber::where('owner_type', 'customer')
                        ->where('owner_name', $srjalan->pelanggan_nama)
                        ->where('number', json_decode($srjalan->cust_kontak, true)['nomor'])
                        ->first();
                    if ($contact_number) {
                        $customer_contact_number_id = $contact_number->id;
                    }
                }

                // Data Reseller
                $reseller_full_address = str_replace('\/', '-', str_replace('"', "'", $srjalan->cust_long));
                $address_id = null;
                $address = Address::where('full', $reseller_full_address)->first();
                if ($address) {
                    $address_id = $address->id;
                }

                $reseller_contact_number_id = null;
                $reseller_contact_number_string = null;
                if ($srjalan->reseller_kontak) {
                    $reseller_kontak = json_decode($srjalan->reseller_kontak, true);
                    $reseller_contact_number_string = $reseller_kontak['nomor'];
                    if (isset($reseller_kontak['kodearea'])) {
                        $reseller_contact_number_string = $reseller_kontak['kodearea'] . '-' . $reseller_kontak['nomor'];
                    }
                    $contact_number = ContactNumber::where('owner_type', 'customer')
                        ->where('owner_name', $srjalan->pelanggan_nama)
                        ->where('number', json_decode($srjalan->reseller_kontak, true)['nomor'])
                        ->first();
                    if ($contact_number) {
                        $reseller_contact_number_id = $contact_number->id;
                    }
                }
                DeliveryNote::create([
                    'id' => $srjalan->id,
                    'delivery_number' => $srjalan->no_srjalan,
                    'customer_id' => $srjalan->pelanggan_id,
                    'customer_name' => $srjalan->pelanggan_nama,
                    'alias' => $srjalan->nama_tertera,
                    'customer_address_id' => $address_id,
                    'customer_full_address' => $customer_full_address,
                    'customer_short_address' => $srjalan->cust_short,
                    'customer_contact_number_id' => $customer_contact_number_id,
                    'customer_contact_number' => $customer_contact_number,

                    'reseller_id' => $srjalan->reseller_id,
                    'reseller_name' => $srjalan->reseller_nama,
                    'reseller_address_id' => $srjalan->alamat_reseller_id,
                    'reseller_full_address' => $reseller_full_address,
                    'reseller_short_address' => $srjalan->reseller_short,
                    'reseller_contact_number_id' => $reseller_contact_number_id,
                    'reseller_contact_number' => $reseller_contact_number_string,

                    'created_by' => $srjalan->created_by,
                    'updated_by' => $srjalan->updated_by,
                ]);

                // Data Expedition
                $expedition_full_address = str_replace('\/', '-', str_replace('"', "'", $srjalan->cust_long));
                $expedition_address_id = null;
                $expedition_address = Address::where('full', $expedition_full_address)->first();
                if ($expedition_address) {
                    $expedition_address_id = $address->id;
                }

                // Expedition Contact
                $expedition_contact_number_id = null;
                $expedition_contact_number_string = null;
                if ($srjalan->ekspedisi_kontak) {
                    $expedition_kontak = json_decode($srjalan->ekspedisi_kontak, true);
                    $expedition_contact_number_string = $expedition_kontak['nomor'];
                    if (isset($expedition_kontak['kodearea'])) {
                        $expedition_contact_number_string = $expedition_kontak['kodearea'] . '-' . $expedition_kontak['nomor'];
                    }
                    $expedition_contact_number = ContactNumber::where('owner_type', 'expedition')
                        ->where('owner_name', $srjalan->pelanggan_nama)
                        ->where('number', json_decode($srjalan->ekspedisi_kontak, true)['nomor'])
                        ->first();
                    if ($expedition_contact_number) {
                        $expedition_contact_number_id = $expedition_contact_number->id;
                    }
                }

                DeliveryNoteExpedition::create([
                    'delivery_id' => $srjalan->id,
                    'expedition_id' => $srjalan->ekspedisi_id,
                    'expedition_name' => $srjalan->ekspedisi_nama,
                    'address_id' => $expedition_address_id,
                    'full_address' => $expedition_full_address,
                    'short_address' => $srjalan->ekspedisi_short,
                    'contact_number_id' => $expedition_contact_number_id,
                    'contact_number' => $expedition_contact_number_string,
                ]);

                // Data Transit
                if ($srjalan->transit_nama) {
                    $transit_full_address = str_replace('\/', '-', str_replace('"', "'", $srjalan->cust_long));
                    $transit_address_id = null;
                    $transit_address = Address::where('full', $transit_full_address)->first();
                    if ($transit_address) {
                        $transit_address_id = $address->id;
                    }

                    // Transit Contact
                    $transit_contact_number_id = null;
                    $transit_contact_number_string = null;
                    if ($srjalan->transit_kontak) {
                        $transit_kontak = json_decode($srjalan->transit_kontak, true);
                        $transit_contact_number_string = $transit_kontak['nomor'];
                        if (isset($transit_kontak['kodearea'])) {
                            $transit_contact_number_string = $transit_kontak['kodearea'] . '-' . $transit_kontak['nomor'];
                        }
                        $transit_contact_number = ContactNumber::where('owner_type', 'expedition')
                            ->where('owner_name', $srjalan->pelanggan_nama)
                            ->where('number', json_decode($srjalan->transit_kontak, true)['nomor'])
                            ->first();
                        if ($transit_contact_number) {
                            $transit_contact_number_id = $transit_contact_number->id;
                        }
                    }

                    DeliveryNoteExpedition::create([
                        'delivery_id' => $srjalan->id,
                        'expedition_type' => 'transit',
                        'expedition_id' => $srjalan->ekspedisi_id,
                        'expedition_name' => $srjalan->ekspedisi_nama,
                        'address_id' => $transit_address_id,
                        'full_address' => $transit_full_address,
                        'short_address' => $srjalan->ekspedisi_short,
                        'contact_number_id' => $transit_contact_number_id,
                        'contact_number' => $transit_contact_number_string,
                    ]);
                }
            }
        });

        // Work Order Invoices Delivery Notes
        DB::connection('mysql_old')->table('spk_notas')->orderBy('id')->chunk(500, function ($spk_notas) {
            foreach ($spk_notas as $spk_nota) {
                $work_order = WorkOrder::find($spk_nota->spk_id);
                if (!$work_order) {
                    Log::warning("[WARNING] Tidak diinput - Work Order Invoices. Work Order ID {$spk_nota->spk_id} tidak ditemukan untuk SPK Nota ID {$spk_nota->id}.");
                    continue; // Skip this invoice if the work order does not exist
                }
                try {
                    WorkOrderInvoiceDeliveryNote::create([
                        'id' => $spk_nota->id,
                        'wo_id' => $spk_nota->spk_id,
                        'invoice_id' => $spk_nota->nota_id,
                    ]);
                } catch (\Exception $e) {
                    Log::error("Gagal migrasi WORK_ORDER_INVOICE ID {$spk_nota->id}: " . $e->getMessage());
                }
            }
        });
    }
}
