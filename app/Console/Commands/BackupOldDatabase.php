<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class BackupOldDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:backup-old-database';

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
        $tables = ['users', 'pelanggans', 'suppliers', 'bahans', 'bahan_hargas', 'ekspedisis', 'pelanggan_ekspedisis',
        'supplier_alamats', 'supplier_kontaks', 'pelanggan_alamats', 'pelanggan_kontaks'
        ];

        $addresses = [];
        foreach ($tables as $table) {
            $data = collect();
            $new_name = $table;
            if ($table === 'users') {
                $data = DB::connection('mysql_old')->table($table)->get()->map(function ($item) {
                    $item = json_decode(json_encode($item), true); // Ubah object menjadi array
                    $item['fullname'] = $item['nama']; // Buat kolom baru
                    $item['role'] = strtolower($item['role']); // Ubah role menjadi huruf kecil

                    if ($item['role'] === 'developer') {
                        $item['clearance_level'] = 6;
                    } elseif ($item['role'] === 'superadmin') {
                        $item['clearance_level'] = 5;
                    } elseif ($item['role'] === 'admin') {
                        $item['clearance_level'] = 4;
                    } elseif ($item['role'] === 'user') {
                        $item['clearance_level'] = 3;
                    }
                    
                    unset($item['nama']); // Hapus kolom lama
                    return $item;
                });
            } elseif ($table === 'pelanggans' || $table === 'suppliers') {
                $new_name = $table === 'pelanggans' ? 'customers' : 'suppliers';
                $data = DB::connection('mysql_old')->table($table)->get()->map(function ($item) {
                    $item = json_decode(json_encode($item), true); // Ubah object menjadi array
                    $item['type'] = $item['tipe']; // Buat kolom baru
                    $item['business_entity'] = $item['bentuk'];
                    $item['company_name'] = $item['nama'];

                    if ($item['reseller_id'] !== null) {
                        $item['is_reseller'] = 'yes';
                    }

                    unset($item['tipe']); // Hapus kolom lama
                    unset($item['bentuk']);
                    unset($item['nama']);
                    unset($item['gender']);
                    unset($item['nik']);
                    unset($item['sapaan']);
                    unset($item['gelar']);
                    unset($item['tanggal_lahir']);
                    unset($item['kategori']);
                    unset($item['keterangan']);
                    unset($item['creator']);
                    unset($item['updater']);
                    return $item;
                });
            } elseif ($table === 'pelanggan_alamats' || $table === 'supplier_alamats') {
                $owner_type = $table === 'pelanggan_alamats' ? 'customer' : 'supplier';
                $datas = DB::connection('mysql_old')->table($table)->get();
                foreach ($datas as $item) {
                    $owner_id = $item->pelanggan_id ?? $item->supplier_id; // Ambil ID owner
                    DB::connection('mysql_old')->table('alamats')
                        ->where('owner_id', $owner_id)
                        ->where('owner_type', $owner_type)
                        ->get()->map(function ($item) use (&$addresses, $owner_type, $owner_id) {
                            $item = json_decode(json_encode($item), true); // Ubah object menjadi array
                            $item['owner_id'] = $owner_id;
                            $item['owner_type'] = $owner_type;
                            $item['owner_name'] = $item['nama'];
                            $item['address_type'] = $item['tipe'];
                            $item['address_status'] = $item['status'];
                            $item['description'] = $item['keterangan'];

                            unset($item['pelanggan_id']); // Hapus kolom lama
                            unset($item['supplier_id']);
                            unset($item['nama']);
                            unset($item['tipe']);
                            unset($item['status']);
                            unset($item['keterangan']);

                            // Simpan alamat untuk digunakan nanti
                            if (!empty($item)) {
                                $addresses[] = $item;
                            }
                            
                            return $item;
                        });
                }
                # code...
            } elseif ($table === 'ekspedisis') {
                $data = DB::connection('mysql_old')->table($table)->get()->map(function ($item) {
                    $item = json_decode(json_encode($item), true); // Ubah object menjadi array
                    $item['business_entity'] = $item['bentuk']; // Buat kolom baru
                    $item['name'] = $item['nama']; 

                    unset($item['bentuk']); // Hapus kolom lama
                    unset($item['nama']);
                    unset($item['keterangan']);
                    return $item;
                });
                $new_name = 'expeditions';
            } elseif ($table === 'bahans') {
                $data = DB::connection('mysql_old')->table($table)->get()->map(function ($item) {
                    $item = json_decode(json_encode($item), true); // Ubah object menjadi array
                    $item['name'] = $item['nama']; // Buat kolom baru
                    $item['description'] = $item['keterangan'];

                    unset($item['nama']); // Hapus kolom lama
                    unset($item['keterangan']);
                    return $item;
                });
                $new_name = 'materials';
            } elseif ($table === 'bahan_hargas') {
                $data = DB::connection('mysql_old')->table($table)->get()->map(function ($item) {
                    $item = json_decode(json_encode($item), true); // Ubah object menjadi array
                    $item['material_id'] = $item['bahan_id']; // Buat kolom baru
                    $item['price'] = $item['harga'];

                    unset($item['bahan_id']); // Hapus kolom lama
                    unset($item['harga']);
                    return $item;
                });
                $new_name = 'material_prices';
            } elseif ($table === 'pelanggan_ekspedisis') {
                $data = DB::connection('mysql_old')->table($table)->get()->map(function ($item) {
                    $item = json_decode(json_encode($item), true); // Ubah object menjadi array
                    $item['customer_id'] = $item['pelanggan_id']; // Buat kolom baru
                    $item['expedition_id'] = $item['ekspedisi_id'];
                    $item['type'] = $item['tipe'];

                    unset($item['pelanggan_id']); // Hapus kolom lama
                    unset($item['ekspedisi_id']);
                    unset($item['tipe']);
                    return $item;
                });
                $new_name = 'customer_expeditions';
            } else {
                $data = DB::connection('mysql_old')->table($table)->get();
            }
            File::put(storage_path("backup/$new_name.json"), $data->toJson());
            echo "Backup berhasil disimpan ke storage/backup/$new_name.json\n";
        }

        // Table: product_types

        $product_types = [
            ["id" => 1, "name" => "Busa Stang", "slug" => "busa-stang", "parent_id" => null, "parent_slug" => null, "short_name" => "Busa Stang", "abbreviation" => "BS", "photo_path" => null, "photo_url" => null, "description" => "Busa yang digunakan untuk melapisi stang motor, memberikan kenyamanan saat berkendara."],
            ["id" => 2, "name" => "Jok Assy", "slug" => "jok-assy", "parent_id" => null, "parent_slug" => null, "short_name" => "Jok Assy", "abbreviation" => "ASS", "photo_path" => null, "photo_url" => null, "description" => "Jok Assy adalah jok motor yang sudah lengkap dengan rangka dan busa, siap dipasang pada motor."],
            ["id" => 3, "name" => "Kulit Jok Motor", "slug" => "kulit-jok-motor", "parent_id" => null, "parent_slug" => null, "short_name" => "Kulit Jok Motor", "abbreviation" => "KJM", "photo_path" => null, "photo_url" => null, "description" => "Kulit jok motor atau sarung jok motor merupakan produk utama pada usaha ini."],
            ["id" => 4, "name" => "Rol", "slug" => "rol", "parent_id" => null, "parent_slug" => null, "short_name" => "Rol", "abbreviation" => "ROL", "photo_path" => null, "photo_url" => null, "description" => "Kulit jok motor yang masih berbentuk gulungan/rol."],
            ["id" => 5, "name" => "Rotan", "slug" => "rotan", "parent_id" => null, "parent_slug" => null, "short_name" => "Rotan", "abbreviation" => "ROT", "photo_path" => null, "photo_url" => null, "description" => "Bahan yang digunakan untuk membuat kulit jok motor dengan tipe tertentu yang menggunakan rotan ini sebagai list/rotan."],
            ["id" => 6, "name" => "Stiker", "slug" => "stiker", "parent_id" => null, "parent_slug" => null, "short_name" => "Stiker", "abbreviation" => "STK", "photo_path" => null, "photo_url" => null, "description" => "Produk yang digunakan untuk menghias atau memberikan identitas pada motor."],
            ["id" => 7, "name" => "Tank Pad", "slug" => "tank-pad", "parent_id" => null, "parent_slug" => null, "short_name" => "Tank Pad", "abbreviation" => "TP", "photo_path" => null, "photo_url" => null, "description" => "Pelindung tangki motor yang berfungsi untuk melindungi tangki dari goresan."],

            // Product Types for Kulit Jok Motor
            ["id" => 8, "name" => "Japstyle", "slug" => "japstyle", "parent_id" => 3, "parent_slug" => "kulit-jok-motor", "short_name" => "Japstyle", "abbreviation" => "JAP", "photo_path" => null, "photo_url" => null, "description" => "Kulit jok motor dengan model yang terinspirasi dari gaya Jepang, yang terdiri dari baris-baris yang di press dengan busa tipis."],
            ["id" => 9, "name" => "Kombinasi", "slug" => "kombinasi", "parent_id" => 3, "parent_slug" => "kulit-jok-motor", "short_name" => "Kombinasi", "abbreviation" => "KOM", "photo_path" => null, "photo_url" => null, "description" => "Kulit jok motor dengan kombinasi 2 bahan atau 2 warna yang berbeda yang harganya biasanya tergolong murah."],
            ["id" => 10, "name" => "Motif", "slug" => "motif", "parent_id" => 3, "parent_slug" => "kulit-jok-motor", "short_name" => "Motif", "abbreviation" => "MOT", "photo_path" => null, "photo_url" => null, "description" => "Kulit jok motor dengan kombinasi 2 bahan atau 2 warna yang berbeda dan terdiri dari jahitan tengah atau jahitan samping atau keduanya."],
            ["id" => 11, "name" => "Standar", "slug" => "standar", "parent_id" => 3, "parent_slug" => "kulit-jok-motor", "short_name" => "Standar", "abbreviation" => "STD", "photo_path" => null, "photo_url" => null, "description" => "Kulit jok motor yang model dan ukurannya sudah disesuaikan dengan motor-motor tertentu."],
            ["id" => 12, "name" => "Tato Sixpack", "slug" => "tato-sixpack", "parent_id" => 3, "parent_slug" => "kulit-jok-motor", "short_name" => "T. Sixpack", "abbreviation" => "T-SIX", "photo_path" => null, "photo_url" => null, "description" => "Kulit jok motor dengan model sixpack besar yang di press."],
            ["id" => 13, "name" => "Variasi", "slug" => "variasi", "parent_id" => 3, "parent_slug" => "kulit-jok-motor", "short_name" => "Variasi", "abbreviation" => "VAR", "photo_path" => null, "photo_url" => null, "description" => "Semua variasi kulit jok motor bisa digolongkan sebagai variasi, namun saat ini yang tergolong variasi adalah Polos, Logo(LG.), Tato(T.)"],
        ];

        // 13 product types

        $product_types_table = ['jokassies', 'rols', 'rotans', 'stikers', 'tankpads',
        'standars', 'motifs', 'kombinasis', 'japstyles', 'tsixpacks', 'variasis'];

        foreach ($product_types_table as $table) {
            $parent_id = null;
            $parent_slug = null;
            if ($table === 'busastangs') {$parent_id = 1; $parent_slug = 'busa-stang';}
            elseif ($table === 'jokassies') {$parent_id = 2;$parent_slug = 'jok-assy';}
            elseif ($table === 'rols') {$parent_id = 4;$parent_slug = 'rol';}
            elseif ($table === 'rotans') {$parent_id = 5;$parent_slug = 'rotan';}
            elseif ($table === 'stikers') {$parent_id = 6;$parent_slug = 'stiker';}
            elseif ($table === 'tankpads') {$parent_id = 7;$parent_slug = 'tank-pad';}
            elseif ($table === 'japstyles') {$parent_id = 8;$parent_slug = 'japstyle';}
            elseif ($table === 'kombinasis') {$parent_id = 9;$parent_slug = 'kombinasi';}
            elseif ($table === 'motifs') {$parent_id = 10;$parent_slug = 'motif';}
            elseif ($table === 'standars') {$parent_id = 11;$parent_slug = 'standar';}
            elseif ($table === 'tsixpacks') {$parent_id = 12;$parent_slug = 'tato-sixpack';}
            elseif ($table === 'variasis') {$parent_id = 13;$parent_slug = 'variasi';}

            $data = DB::connection('mysql_old')->table($table)->get()->map(function ($item) use ($parent_id, $parent_slug) {
                $item = json_decode(json_encode($item), true); // Ubah object menjadi array
                $item['name'] = $item['nama']; // Buat kolom baru
                $item['slug'] = str_replace(' ', '-', strtolower($item['nama'])); // Buat slug dari nama
                $item['parent_id'] = $parent_id; // Parent ID
                $item['parent_slug'] = $parent_slug; // Parent slug
                $item['short_name'] = $item['nama']; // Short name sama dengan nama
                $item['abbreviation'] = null; // Tidak ada abbreviation
                $item['photo_path'] = null; // Tidak ada photo_path
                $item['photo_url'] = null; // Tidak ada photo_url
                $item['description'] = $item['keterangan'];

                unset($item['nama']); // Hapus kolom lama
                unset($item['keterangan']);
                return $item;
            });

            $product_types = array_merge($product_types, $data->toArray());
        }

        File::put(storage_path("backup/product_types.json"), json_encode($product_types));
        echo "Backup berhasil disimpan ke storage/backup/product_types.json\n";

        // Table: features
        $data = DB::connection('mysql_old')->table('specs')->get()->map(function ($item) {
            $item = json_decode(json_encode($item), true); // Ubah object menjadi array
            $item['category'] = $item['kategori'];
            $item['name'] = $item['nama'];
            $item['invoice_name'] = $item['nama_nota'];

            unset($item['nama']); // Hapus kolom lama
            return $item;
        });

        $features = $data->toArray();

        $data = DB::connection('mysql_old')->table('variasistandar_hargas')->get()->map(function ($item) {
            $item = json_decode(json_encode($item), true); // Ubah object menjadi array
            $item['category'] = 'feature-sj-variasi';
            $item['name'] = $item['variasi_standar'];

            unset($item['nama']); // Hapus kolom lama
            return $item;
        });

        $features = array_merge($features, $data->toArray());
        File::put(storage_path("backup/features.json"), json_encode($features));
        echo "Backup berhasil disimpan ke storage/backup/features.json\n";

        // Table: feature_prices
        $data = DB::connection('mysql_old')->table('variasistandar_hargas')->get()->map(function ($item) {
            $item = json_decode(json_encode($item), true); // Ubah object menjadi array
            $item['feature_id'] = $item['id']; // Buat kolom baru
            $item['price'] = $item['harga'];

            unset($item['id']); // Hapus kolom lama
            unset($item['harga']);
            return $item;
        });
        File::put(storage_path("backup/feature_prices.json"), $data->toJson());
        echo "Backup berhasil disimpan ke storage/backup/feature_prices.json\n";
    }
}
