<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Path ke file JSON
        $table = 'category_trees';
        $path = storage_path("backup/$table.json");

        // Periksa apakah file JSON ada
        if (!File::exists($path)) {
            $this->command->error("File $path tidak ditemukan.");
            return;
        }

        // Baca data dari file JSON
        $json = File::get($path);
        $data = json_decode($json, true);

        // Insert data ke tabel 'users'
        if (!empty($data)) {
            $chunks = array_chunk($data, 1000); // Pecah data menjadi batch 1000 per insert

            foreach ($chunks as $chunk) {
                DB::table($table)->insert($chunk);
            }
            $this->command->info("Data berhasil dimasukkan ke tabel $table.");
            
        } else {
            $this->command->warn("Tidak ada data yang ditemukan di file $table JSON.");
        }
        // $product_types = [
        //     [
        //         "name" => "Busa Stang",
        //         "parent_id" => null,
        //         "parent_slug" => null,
        //         "short_name" => "Busa Stang",
        //         "abbreviation" => "BS",
        //         "photo_path" => null,
        //         "photo_url" => null,
        //         "description" => "Busa yang digunakan untuk melapisi stang motor, memberikan kenyamanan saat berkendara.",
        //     ],
        //     [
        //         "name" => "Jok Assy",
        //         "parent_id" => null,
        //         "parent_slug" => null,
        //         "short_name" => "Jok Assy",
        //         "abbreviation" => "ASS",
        //         "photo_path" => null,
        //         "photo_url" => null,
        //         "description" => "Jok Assy adalah jok motor yang sudah lengkap dengan rangka dan busa, siap dipasang pada motor.",
        //     ],
        //     [
        //         "name" => "Kulit Jok Motor",
        //         "parent_id" => null,
        //         "parent_slug" => null,
        //         "short_name" => "Kulit Jok Motor",
        //         "abbreviation" => "KJM",
        //         "photo_path" => null,
        //         "photo_url" => null,
        //         "description" => "Kulit jok motor atau sarung jok motor merupakan produk utama pada usaha ini.",
        //     ],
        //     [
        //         "name" => "Rol",
        //         "parent_id" => null,
        //         "parent_slug" => null,
        //         "short_name" => "Rol",
        //         "abbreviation" => "ROL",
        //         "photo_path" => null,
        //         "photo_url" => null,
        //         "description" => "Kulit jok motor yang masih berbentuk gulungan/rol.",
        //     ],
        //     [
        //         "name" => "Rotan",
        //         "parent_id" => null,
        //         "parent_slug" => null,
        //         "short_name" => "Rotan",
        //         "abbreviation" => "RTN",
        //         "photo_path" => null,
        //         "photo_url" => null,
        //         "description" => "Bahan yang digunakan untuk membuat kulit jok motor dengan tipe tertentu yang menggunakan rotan ini sebagai list/rotan.",
        //     ],
        //     [
        //         "name" => "Stiker",
        //         "parent_id" => null,
        //         "parent_slug" => null,
        //         "short_name" => "Stiker",
        //         "abbreviation" => "STK",
        //         "photo_path" => null,
        //         "photo_url" => null,
        //         "description" => "Produk yang digunakan untuk menghias atau memberikan identitas pada motor.",
        //     ],
        //     [
        //         "name" => "Tank Pad",
        //         "parent_id" => null,
        //         "parent_slug" => null,
        //         "short_name" => "Tank Pad",
        //         "abbreviation" => "TP",
        //         "photo_path" => null,
        //         "photo_url" => null,
        //         "description" => "Pelindung tangki motor yang berfungsi untuk melindungi tangki dari goresan.",
        //     ],

        //     // Product Types for Kulit Jok Motor
        //     [
        //         "name" => "Variasi",
        //         "parent_id" => 3, // Kulit Jok Motor
        //         "parent_slug" => "kulit-jok-motor",
        //         "short_name" => "Variasi",
        //         "abbreviation" => "VAR",
        //         "photo_path" => null,
        //         "photo_url" => null,
        //         "description" => "Semua variasi kulit jok motor bisa digolongkan sebagai variasi, namun saat ini yang tergolong variasi adalah Polos, Logo(LG.), Tato(T.)",
        //     ],
        //     [
        //         "name" => "Tato Sixpack",
        //         "parent_id" => 3, // Kulit Jok Motor
        //         "parent_slug" => "kulit-jok-motor",
        //         "short_name" => "T. Sixpack",
        //         "abbreviation" => "T-SIX",
        //         "photo_path" => null,
        //         "photo_url" => null,
        //         "description" => "Kulit jok motor dengan model sixpack besar yang di press.",
        //     ],
        //     [
        //         "name" => "Japstyle",
        //         "parent_id" => 3, // Kulit Jok Motor
        //         "parent_slug" => "kulit-jok-motor",
        //         "short_name" => "Japstyle",
        //         "abbreviation" => "JAP",
        //         "photo_path" => null,
        //         "photo_url" => null,
        //         "description" => "Kulit jok motor dengan model yang terinspirasi dari gaya Jepang, yang terdiri dari baris-baris yang di press dengan busa tipis.",
        //     ],
        //     [
        //         "name" => "Kombinasi",
        //         "parent_id" => 3, // Kulit Jok Motor
        //         "parent_slug" => "kulit-jok-motor",
        //         "short_name" => "Kombinasi",
        //         "abbreviation" => "KOM",
        //         "photo_path" => null,
        //         "photo_url" => null,
        //         "description" => "Kulit jok motor dengan kombinasi 2 bahan atau 2 warna yang berbeda yang harganya biasanya tergolong murah.",
        //     ],
        //     [
        //         "name" => "Standar",
        //         "parent_id" => 3, // Kulit Jok Motor
        //         "parent_slug" => "kulit-jok-motor",
        //         "short_name" => "Standar",
        //         "abbreviation" => "STD",
        //         "photo_path" => null,
        //         "photo_url" => null,
        //         "description" => "Kulit jok motor yang model dan ukurannya sudah disesuaikan dengan motor-motor tertentu.",
        //     ],
        //     [
        //         "name" => "Motif",
        //         "parent_id" => 3, // Kulit Jok Motor
        //         "parent_slug" => "kulit-jok-motor",
        //         "short_name" => "Motif",
        //         "abbreviation" => "MOT",
        //         "photo_path" => null,
        //         "photo_url" => null,
        //         "description" => "Kulit jok motor dengan kombinasi 2 bahan atau 2 warna yang berbeda dan terdiri dari jahitan tengah atau jahitan samping atau keduanya.",
        //     ],
        // ];

        // foreach ($product_types as $product_type) {
        //     DB::table('product_types')->insert(
        //         [
        //             'name' => $product_type['name'],
        //             'slug' => str_replace(' ', '-', strtolower($product_type['name'])),
        //             'parent_id' => $product_type['parent_id'],
        //             'parent_slug' => $product_type['parent_slug'],
        //             'short_name' => $product_type['short_name'],
        //             'abbreviation' => $product_type['abbreviation'],
        //             'photo_path' => null,
        //             'photo_url' => null,
        //             'description' => $product_type['description'],
        //         ]
        //     );
        // }
    }
}
