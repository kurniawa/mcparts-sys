<?php

namespace App\Console\Commands;

use App\Models\Address;
use DB;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test';

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
         * Memeriksa apakah setiap alamat yang tertera dari setiap surat jalan pada database lama, semuanya ada/lengkap
         * pada database baru.
         */
        DB::connection('mysql_old')->table('srjalans')->orderBy('id')->chunk(500, function ($srjalans) {
            foreach ($srjalans as $srjalan) {
                $customer_address = Address::where('full', str_replace('\/', '-', str_replace('"', "'", $srjalan->cust_long)))->first();
                if ($customer_address) {
                    Log::info("[FOUND]: $srjalan->pelanggan_nama - $srjalan->cust_long");
                } else {
                    Log::error("[NOT-FOUND]: $srjalan->pelanggan_nama - $srjalan->cust_long");
                }
            }
        });
    }
}
