<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class SeedingProductPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:seeding-product-prices';

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
        $this->info('Seeding Product Prices...');
        $product_prices = \App\Models\ProductPrice::all();
        foreach ($product_prices as $product_price) {
            $product = Product::find($product_price->product_id);
            if ($product) {
                $product_price->product_name = $product->name;
                $product_price->product_invoice_name = $product->invoice_name;
                $product_price->save();
            }
        }
    }
}
