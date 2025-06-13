<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = [
            // grade bahan
            ['id' => 1, 'category' => 'grade_bahan', 'parent_id' => null, 'parent_name' => null, 'name' => 'A', 'name_on_spk' => '', 'name_on_invoice' => 'A', 'description' => null],
            ['id' => 2, 'category' => 'grade_bahan', 'parent_id' => null, 'parent_name' => null, 'name' => 'B', 'name_on_spk' => '', 'name_on_invoice' => 'B', 'description' => null],

            // category ukuran
            ['id' => 3, 'category' => 'ukuran', 'parent_id' => null, 'parent_name' => null, 'name' => 'PK', 'name_on_spk' => 'uk.PK', 'name_on_invoice' => 'uk.PK', 'description' => null],
            ['id' => 4, 'category' => 'ukuran', 'parent_id' => null, 'parent_name' => null, 'name' => 'JB-93x53', 'name_on_spk' => 'uk.JB', 'name_on_invoice' => 'uk.JB', 'description' => null],
            ['id' => 5, 'category' => 'ukuran', 'parent_id' => null, 'parent_name' => null, 'name' => 'L', 'name_on_spk' => 'uk.L', 'name_on_invoice' => 'uk.L', 'description' => null],
            ['id' => 6, 'category' => 'ukuran', 'parent_id' => null, 'parent_name' => null, 'name' => 'LONG-95x51', 'name_on_spk' => 'uk.LONG', 'name_on_invoice' => 'uk.LONG', 'description' => null],
            ['id' => 7, 'category' => 'ukuran', 'parent_id' => null, 'parent_name' => null, 'name' => '97x68.5', 'name_on_spk' => 'uk.97x68', 'name_on_invoice' => 'uk.97x68.5', 'description' => null],
            ['id' => 8, 'category' => 'ukuran', 'parent_id' => null, 'parent_name' => null, 'name' => 'SuperJB-97x53', 'name_on_spk' => 'uk.SuperJB', 'name_on_invoice' => 'uk.SuperJB', 'description' => null],
            ['id' => 9, 'category' => 'ukuran', 'parent_id' => null, 'parent_name' => null, 'name' => 'MEGA-100x57', 'name_on_spk' => 'uk.MEGA', 'name_on_invoice' => 'uk.MEGA', 'description' => null],
            ['id' => 10, 'category' => 'ukuran', 'parent_id' => null, 'parent_name' => null, 'name' => 'GIGA-100x68.5', 'name_on_spk' => 'uk.GIGA', 'name_on_invoice' => 'uk.GIGA', 'description' => null],
            ['id' => 11, 'category' => 'ukuran', 'parent_id' => null, 'parent_name' => null, 'name' => '108x53', 'name_on_spk' => 'uk.108x53', 'name_on_invoice' => 'uk.108x53', 'description' => null],
            ['id' => 12, 'category' => 'ukuran', 'parent_id' => null, 'parent_name' => null, 'name' => 'Scoopy', 'name_on_spk' => 'uk.Scoopy', 'name_on_invoice' => 'uk.Scoopy', 'description' => null],
            ['id' => 13, 'category' => 'ukuran', 'parent_id' => null, 'parent_name' => null, 'name' => 'NMAX', 'name_on_spk' => 'uk.NMAX', 'name_on_invoice' => 'uk.NMAX', 'description' => null],
            ['id' => 14, 'category' => 'ukuran', 'parent_id' => null, 'parent_name' => null, 'name' => 'PCX', 'name_on_spk' => 'uk.PCX', 'name_on_invoice' => 'uk.PCX', 'description' => null],
            ['id' => 15, 'category' => 'ukuran', 'parent_id' => null, 'parent_name' => null, 'name' => 'Aerox', 'name_on_spk' => 'uk.Aerox', 'name_on_invoice' => 'uk.Aerox', 'description' => null],
            ['id' => 16, 'category' => 'ukuran', 'parent_id' => null, 'parent_name' => null, 'name' => 'FreeGo', 'name_on_spk' => 'uk.FreeGo', 'name_on_invoice' => 'uk.FreeGo', 'description' => null],
            ['id' => 17, 'category' => 'ukuran', 'parent_id' => null, 'parent_name' => null, 'name' => 'Vario150', 'name_on_spk' => 'uk.Vario150', 'name_on_invoice' => 'uk.Vario150', 'description' => null],
            ['id' => 18, 'category' => 'ukuran', 'parent_id' => null, 'parent_name' => null, 'name' => 'MioSoulGT125', 'name_on_spk' => 'uk.MioSoulGT125', 'name_on_invoice' => 'uk.MioSoulGT125', 'description' => null],
            ['id' => 19, 'category' => 'ukuran', 'parent_id' => null, 'parent_name' => null, 'name' => 'ADV', 'name_on_spk' => 'uk.ADV', 'name_on_invoice' => 'uk.ADV', 'description' => null],
            ['id' => 20, 'category' => 'ukuran', 'parent_id' => null, 'parent_name' => null, 'name' => 'LEXI', 'name_on_spk' => 'uk.LEXI', 'name_on_invoice' => 'uk.LEXI', 'description' => null],
            ['id' => 21, 'category' => 'ukuran', 'parent_id' => null, 'parent_name' => null, 'name' => 'FINO', 'name_on_spk' => 'uk.FINO', 'name_on_invoice' => 'uk.FINO', 'description' => null],
            ['id' => 22, 'category' => 'ukuran', 'parent_id' => null, 'parent_name' => null, 'name' => 'Vario 125/150', 'name_on_spk' => 'uk.Vario 125/150', 'name_on_invoice' => 'uk.Vario 125/150', 'description' => null],
            ['id' => 23, 'category' => 'ukuran', 'parent_id' => null, 'parent_name' => null, 'name' => 'M3', 'name_on_spk' => 'uk.M3', 'name_on_invoice' => 'uk.M3', 'description' => null],
            
            // category jahit
            ['id' => 24, 'category' => 'jahit', 'parent_id' => null, 'parent_name' => null, 'name' => 'Univ', 'name_on_spk' => 'jht.Univ', 'name_on_invoice' => 'jht.Univ', 'description' => null],
            ['id' => 25, 'category' => 'jahit', 'parent_id' => null, 'parent_name' => null, 'name' => 'ABS-RV', 'name_on_spk' => 'jht.ABS', 'name_on_invoice' => 'jht.ABS-RV', 'description' => null],
            ['id' => 26, 'category' => 'jahit', 'parent_id' => null, 'parent_name' => null, 'name' => 'RXK', 'name_on_spk' => 'jht.RXK', 'name_on_invoice' => 'jht.RXK', 'description' => null],
            ['id' => 27, 'category' => 'jahit', 'parent_id' => null, 'parent_name' => null, 'name' => 'JB', 'name_on_spk' => 'jht.JB', 'name_on_invoice' => 'jht.JB', 'description' => null],
            ['id' => 28, 'category' => 'jahit', 'parent_id' => null, 'parent_name' => null, 'name' => 'Scoopy', 'name_on_spk' => 'jht.Scoopy', 'name_on_invoice' => 'jht.Scoopy', 'description' => null],
            ['id' => 29, 'category' => 'jahit', 'parent_id' => null, 'parent_name' => null, 'name' => 'NMAX', 'name_on_spk' => 'jht.NMAX', 'name_on_invoice' => 'jht.NMAX', 'description' => null],
            ['id' => 30, 'category' => 'jahit', 'parent_id' => null, 'parent_name' => null, 'name' => 'PCX', 'name_on_spk' => 'jht.PCX', 'name_on_invoice' => 'jht.PCX', 'description' => null],
            ['id' => 31, 'category' => 'jahit', 'parent_id' => null, 'parent_name' => null, 'name' => 'Aerox', 'name_on_spk' => 'jht.Aerox', 'name_on_invoice' => 'jht.Aerox', 'description' => null],
            ['id' => 32, 'category' => 'jahit', 'parent_id' => null, 'parent_name' => null, 'name' => 'FreeGo', 'name_on_spk' => 'jht.FreeGo', 'name_on_invoice' => 'jht.FreeGo', 'description' => null],
            ['id' => 33, 'category' => 'jahit', 'parent_id' => null, 'parent_name' => null, 'name' => 'Vario150', 'name_on_spk' => 'jht.Vario150', 'name_on_invoice' => 'jht.Vario150', 'description' => null],
            ['id' => 34, 'category' => 'jahit', 'parent_id' => null, 'parent_name' => null, 'name' => 'MioSoulGT125', 'name_on_spk' => 'jht.MioSoulGT125', 'name_on_invoice' => 'jht.MioSoulGT125', 'description' => null],
            ['id' => 35, 'category' => 'jahit', 'parent_id' => null, 'parent_name' => null, 'name' => 'Warna', 'name_on_spk' => 'jht.Warna', 'name_on_invoice' => 'jht.Warna', 'description' => null],
            ['id' => 36, 'category' => 'jahit', 'parent_id' => null, 'parent_name' => null, 'name' => 'ADV', 'name_on_spk' => 'jht.ADV', 'name_on_invoice' => 'jht.ADV', 'description' => null],
            ['id' => 37, 'category' => 'jahit', 'parent_id' => null, 'parent_name' => null, 'name' => 'LEXI', 'name_on_spk' => 'jht.LEXI', 'name_on_invoice' => 'jht.LEXI', 'description' => null],
            ['id' => 38, 'category' => 'jahit', 'parent_id' => null, 'parent_name' => null, 'name' => 'FINO', 'name_on_spk' => 'jht.FINO', 'name_on_invoice' => 'jht.FINO', 'description' => null],
            ['id' => 39, 'category' => 'jahit', 'parent_id' => null, 'parent_name' => null, 'name' => 'Vario 125/150', 'name_on_spk' => 'jht.Vario 125/150', 'name_on_invoice' => 'jht.Vario 125/150', 'description' => null],
            ['id' => 40, 'category' => 'jahit', 'parent_id' => null, 'parent_name' => null, 'name' => 'M3', 'name_on_spk' => 'jht.M3', 'name_on_invoice' => 'jht.M3', 'description' => null],
            ['id' => 41, 'category' => 'jahit', 'parent_id' => null, 'parent_name' => null, 'name' => 'NMAX (Promo)', 'name_on_spk' => 'jht.NMAX (Promo)', 'name_on_invoice' => 'jht.NMAX (Promo)', 'description' => null],
            
            // alas
            ['id' => 42, 'category' => 'alas', 'parent_id' => null, 'parent_name' => null, 'name' => 'Alas', 'name_on_spk' => '', 'name_on_invoice' => 'Alas', 'description' => null],
            
            // busa
            ['id' => 43, 'category' => 'busa', 'parent_id' => null, 'parent_name' => null, 'name' => 'Busa', 'name_on_spk' => '', 'name_on_invoice' => 'Busa', 'description' => null],
            
            // sayap
            ['id' => 44, 'category' => 'sayap', 'parent_id' => null, 'parent_name' => null, 'name' => 'Sayap Abu', 'name_on_spk' => '', 'name_on_invoice' => 'Sayap Abu', 'description' => null],
            ['id' => 45, 'category' => 'sayap', 'parent_id' => null, 'parent_name' => null, 'name' => 'Sayap Hitam', 'name_on_spk' => '', 'name_on_invoice' => 'Sayap Hitam', 'description' => null],
            
            // list
            ['id' => 46, 'category' => 'list', 'parent_id' => null, 'parent_name' => null, 'name' => 'Benang', 'name_on_spk' => '', 'name_on_invoice' => 'Benang', 'description' => null],
            ['id' => 47, 'category' => 'list', 'parent_id' => null, 'parent_name' => null, 'name' => 'Benang Warna', 'name_on_spk' => '', 'name_on_invoice' => 'Benang Warna', 'description' => null],
            ['id' => 48, 'category' => 'list', 'parent_id' => null, 'parent_name' => null, 'name' => 'Rotan', 'name_on_spk' => '', 'name_on_invoice' => 'Rotan', 'description' => null],
            ['id' => 49, 'category' => 'list', 'parent_id' => null, 'parent_name' => null, 'name' => 'Rotan Warna', 'name_on_spk' => '', 'name_on_invoice' => 'Rotan Warna', 'description' => null],

            // general
            ['id' => 50, 'category' => 'general', 'parent_id' => null, 'parent_name' => null, 'name' => 'jht.Kepala', 'name_on_spk' => 'jht.Kepala', 'name_on_invoice' => 'jht.Kepala', 'description' => null],
            ['id' => 51, 'category' => 'general', 'parent_id' => null, 'parent_name' => null, 'name' => 'jht.Samping', 'name_on_spk' => 'jht.Samping', 'name_on_invoice' => 'jht.Samping', 'description' => null],
            ['id' => 52, 'category' => 'general', 'parent_id' => null, 'parent_name' => null, 'name' => 'PRESS', 'name_on_spk' => 'PRESS', 'name_on_invoice' => 'PRESS', 'description' => null],
            ['id' => 53, 'category' => 'general', 'parent_id' => null, 'parent_name' => null, 'name' => 'Alas', 'name_on_spk' => 'Alas', 'name_on_invoice' => 'Alas', 'description' => null],
            ['id' => 53, 'category' => 'general', 'parent_id' => null, 'parent_name' => null, 'name' => 'Busa', 'name_on_spk' => 'Busa', 'name_on_invoice' => 'Busa', 'description' => null],
        ];

        /**
         * urutan:
         * 1. grade_bahan
         * 2. ukuran
         * 3. jahit
         * 4. alas
         * 5. busa
         * 6. sayap
         * 7. list
         */

        foreach ($features as $feature) {
            \App\Models\Feature::create($feature);
        }
    }
}
