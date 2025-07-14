<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SeedingFromPreviousDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:seeding-from-previous-database';

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
        // $test = '{"id":2,"pelanggan_id":2,"tipe":"seluler","kodearea":null,"nomor":"082253633222","is_aktual":"yes","lokasi":null,"created_at":"2022-11-03T07:40:54.000000Z","updated_at":"2022-11-03T07:40:54.000000Z"}';
        // dd(json_decode($test, true));
        $this->call('app:seeding-product-prices');
        $this->call('app:seeding-work-orders');
        $this->call('app:seeding-invoices');
        $this->call('app:seeding-delivery-notes');
        $this->call('app:seeding-wallets');

        $this->info('Data telah diperbaiki dan migrasi SPK selesai.');
    }
}
