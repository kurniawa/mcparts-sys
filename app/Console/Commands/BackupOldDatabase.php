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
        $tables = ['users', 'pelanggans', 'suppliers', 'ekspedisis',
        'pelanggan_alamats', 'pelanggan_kontaks', 'supplier_alamats', 'supplier_kontaks', 'ekspedisi_alamats', 'ekspedisi_kontaks',
        'bahans', 'bahan_hargas', 'pelanggan_ekspedisis',
        ];

        $addresses = [];
        $contact_numbers = [];

        foreach ($tables as $table) {
            $data = collect();
            $new_name = $table;
            $run_save_file = true;
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
            } elseif ($table === 'pelanggans' || $table === 'suppliers' || $table === 'ekspedisis') {
                $new_name = $table === 'pelanggans' ? 'customers' : ($table === 'suppliers' ? 'suppliers' : 'expeditions');
                $data = DB::connection('mysql_old')->table($table)->get()->map(function ($item) {
                    $item = json_decode(json_encode($item), true); // Ubah object menjadi array
                    $entity_type = $item['tipe'] ?? null;
                    $item['type'] = $entity_type; // Buat kolom baru
                    $item['business_entity'] = $item['bentuk'];
                    $item['name'] = $item['nama'];

                    if (isset($item['reseller_id'])) {
                        if ($item['reseller_id'] !== null) {
                            $item['is_reseller'] = 'yes';
                        }
                    }

                    // Hapus kolom lama
                    if (isset($item['tipe'])) {unset($item['tipe']);}
                    unset($item['bentuk']);
                    unset($item['nama']);
                    if (isset($item['gender'])) {unset($item['gender']);}
                    if (isset($item['nik'])) {unset($item['nik']);}
                    if (isset($item['sapaan'])) {unset($item['sapaan']);}
                    if (isset($item['gelar'])) {unset($item['gelar']);}
                    if (isset($item['tanggal_lahir'])) {unset($item['tanggal_lahir']);}
                    if (isset($item['kategori'])) {unset($item['kategori']);}
                    if (isset($item['keterangan'])) {unset($item['keterangan']);}
                    if (isset($item['creator'])) {unset($item['creator']);}
                    if (isset($item['updater'])) {unset($item['updater']);}
                    return $item;
                });
            } elseif ($table === 'pelanggan_alamats' || $table === 'supplier_alamats' || $table === 'ekspedisi_alamats') {
                $run_save_file = false;
                $owner_type = $table === 'pelanggan_alamats' ? 'customer' : ($table === 'supplier_alamats' ? 'supplier' : 'expedition');
                $datas = DB::connection('mysql_old')->table($table)->get();
                foreach ($datas as $item) {
                    $owner_id = $item->pelanggan_id ?? $item->supplier_id ?? $item->ekspedisi_id; // Ambil ID owner
                    $entity_address_table = isset($item->pelanggan_id) ? 'pelanggan_alamats' : (isset($item->supplier_id) ? 'supplier_alamats' : 'ekspedisi_alamats');
                    $entity_address_column = isset($item->pelanggan_id) ? 'pelanggan_id' : (isset($item->supplier_id) ? 'supplier_id' : 'ekspedisi_id');
                    $entity_table = $table === 'pelanggan_alamats' ? 'pelanggans' : ($table === 'supplier_alamats' ? 'suppliers' : 'ekspedisis');
                    $entity_addresses = DB::connection('mysql_old')->table($entity_address_table)
                        ->where($entity_address_column, $owner_id)
                        ->get();

                    foreach ($entity_addresses as $entity_address) {
                        DB::connection('mysql_old')->table('alamats')->where('id', $entity_address->alamat_id)
                            ->get()->map(function ($item) use (&$addresses, $owner_type, $owner_id, $entity_address, $entity_table) {
                                $item = json_decode(json_encode($item), true); // Ubah object menjadi array
                                $item['owner_id'] = $owner_id;
                                $item['owner_type'] = $owner_type;
                                $owner = DB::connection('mysql_old')->table($entity_table)
                                    ->where('id', $owner_id)
                                    ->first();
                                $item['owner_name'] = $owner->nama;
                                $item['address_type'] = 'office';
                                $item['housing_complex'] = $item['komplek'];
                                $item['street'] = $item['jalan'];
                                $item['rural_village'] = $item['desa'];
                                $item['urban_village'] = $item['kelurahan'];
                                $item['district'] = $item['kecamatan'];
                                $item['city'] = $item['kota'];
                                $item['postal_code'] = $item['kodepos'];
                                $item['regency'] = $item['kabupaten'];
                                $item['province'] = $item['provinsi'];
                                $item['country'] = $item['negara'];
                                $item['long'] = str_replace('"', "'", $item['long']);
                                $item['long'] = str_replace('\/', "-", $item['long']);
    
                                $address_order = 'primary';
                                if ($entity_address->tipe === 'CADANGAN') {
                                    $address_order = 'secondary';
                                }
                                $item['address_order'] = $address_order;
    
                                unset($item['jalan']);unset($item['komplek']);unset($item['desa']);unset($item['kelurahan']);
                                unset($item['kecamatan']);unset($item['kota']);unset($item['kodepos']);
                                unset($item['kabupaten']);unset($item['provinsi']);unset($item['pulau']);unset($item['negara']);
                                unset($item['id']);
    
                                // Simpan alamat untuk digunakan nanti
                                if (!empty($item)) {
                                    // dd(json_encode($item));
                                    $addresses[] = $item;
                                }
                                
                                return $item;
                            });
                    }
                    // dd($addresses);
                }
            } elseif ($table === 'pelanggan_kontaks' || $table === 'supplier_kontaks' || $table === 'ekspedisi_kontaks') {
                $run_save_file = false;
                $owner_type = $table === 'pelanggan_kontaks' ? 'customer' : ($table === 'supplier_kontaks' ? 'supplier' : 'expedition');
                $owner_table = $table === 'pelanggan_kontaks' ? 'pelanggans' : ($table === 'supplier_kontaks' ? 'suppliers' : 'ekspedisis');
                $datas = DB::connection('mysql_old')->table($table)->get()->map(function ($item) use (&$contact_numbers, $owner_type, $owner_table) {
                    $item = json_decode(json_encode($item), true); // Ubah object menjadi array
                    $owner_id = $item['pelanggan_id'] ?? $item['supplier_id'] ?? $item['ekspedisi_id']; // Ambil ID owner
                    $item['owner_id'] = $owner_id;
                    $item['owner_type'] = $owner_type;

                    $owner = DB::connection('mysql_old')->table($owner_table)
                        ->where('id', $owner_id)
                        ->first();

                    $item['owner_name'] = $owner->nama;
                    $item['contact_type'] = $item['tipe'];

                    $contact_order = 'primary';
                    if ($item['is_aktual'] === 'no') {
                        $contact_order = 'secondary';
                    }
                    $item['contact_order'] = $contact_order;
                    $item['country_code'] = '+62';
                    $item['area_code'] = $item['kodearea'];
                    $item['number'] = $item['nomor'];

                    if (isset($item['supplier_id'])) { unset($item['supplier_id']);}
                    elseif (isset($item['pelanggan_id'])) { unset($item['pelanggan_id']);}
                    elseif (isset($item['ekspedisi_id'])) { unset($item['ekspedisi_id']);}
                    unset($item['tipe']);
                    unset($item['is_aktual']);
                    unset($item['kodearea']);
                    unset($item['nomor']);
                    unset($item['keterangan']);
                    unset($item['id']);
                    unset($item['lokasi']);

                    if (!empty($item)) {
                        $contact_numbers[] = $item;
                    }
                    
                    return $item;
                });
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

                    $expedition_type = "direct";
                    if (isset($item['is_transit']) && $item['is_transit'] === 'yes') {
                        $expedition_type = 'transit';
                    }
                    $item['expedition_type'] = $expedition_type;

                    $expedition_order = 'primary';
                    if (isset($item['tipe']) && $item['tipe'] === 'CADANGAN') {
                        $expedition_order = 'secondary';
                    }
                    $item['expedition_order'] = $expedition_order;

                    unset($item['pelanggan_id']); // Hapus kolom lama
                    unset($item['ekspedisi_id']);
                    unset($item['tipe']);
                    unset($item['is_transit']);
                    return $item;
                });
                $new_name = 'customer_expeditions';
            } else {
                $data = DB::connection('mysql_old')->table($table)->get();
            }

            if ($run_save_file) {
                File::put(storage_path("backup/$new_name.json"), $data->toJson());
                echo "Backup berhasil disimpan ke storage/backup/$new_name.json\n";
            }
        }

        // Table: addresses
        if (!empty($addresses)) {
            File::put(storage_path("backup/addresses.json"), json_encode($addresses));
            echo "Backup berhasil disimpan ke storage/backup/addresses.json\n";
        } else {
            echo "Tidak ada alamat yang ditemukan untuk dibackup.\n";
        }

        // Table: contact_numbers
        if (!empty($contact_numbers)) {
            File::put(storage_path("backup/contact_numbers.json"), json_encode($contact_numbers));
            echo "Backup berhasil disimpan ke storage/backup/contact_numbers.json\n";
        } else {
            echo "Tidak ada nomor kontak yang ditemukan untuk dibackup.\n";
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
