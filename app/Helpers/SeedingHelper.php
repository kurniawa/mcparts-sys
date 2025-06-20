<?php

class SeedingHelper
{
    /**
     * 
     *
     * @return string|null
     */
    public static function seedTableFromJSON(string $table, $command): void
    {
        // Path ke file JSON
        $path = storage_path("backup/$table.json");

        // Periksa apakah file JSON ada
        if (!File::exists($path)) {
            $command->error("File $path tidak ditemukan.");
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
            $command->info("Data berhasil dimasukkan ke tabel $table.");
            
        } else {
            $command->warn("Tidak ada data yang ditemukan di file $table JSON.");
        }
    }
}

?>