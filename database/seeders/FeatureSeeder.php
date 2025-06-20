<?php

namespace Database\Seeders;

use App\Models\CategoryTree;
use App\Models\Feature;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $feature_categories = [
            ['id' => 1, 'name' => 'variasi', 'parent_id' => null, 'parent_name' => null],
            ['id' => 2, 'name' => 'general', 'parent_id' => null, 'parent_name' => null],
            ['id' => 3, 'name' => 'drawing', 'parent_id' => null, 'parent_name' => null],
            // variasi
            ['name' => 'grade_bahan', 'parent_id' => 1, 'parent_name' => 'variasi'],
            ['name' => 'ukuran', 'parent_id' => 1, 'parent_name' => 'variasi'],
            ['name' => 'jahit', 'parent_id' => 1, 'parent_name' => 'variasi'],
            ['name' => 'alas', 'parent_id' => 1, 'parent_name' => 'variasi'],
            ['name' => 'busa', 'parent_id' => 1, 'parent_name' => 'variasi'],
            ['name' => 'sayap', 'parent_id' => 1, 'parent_name' => 'variasi'],
            ['name' => 'list', 'parent_id' => 1, 'parent_name' => 'variasi'],
            // general
            ['name' => 'jht.Kepala', 'parent_id' => 2, 'parent_name' => 'general'],
            ['name' => 'jht.Samping', 'parent_id' => 2, 'parent_name' => 'general'],
            ['name' => 'PRESS', 'parent_id' => 2, 'parent_name' => 'general'],
            ['name' => 'Alas', 'parent_id' => 2, 'parent_name' => 'general'],
            ['name' => 'Busa', 'parent_id' => 2, 'parent_name' => 'general'],
            // drawing
            ['name' => 'honda', 'parent_id' => 3, 'parent_name' => 'drawing'],
            ['name' => 'yamaha', 'parent_id' => 3, 'parent_name' => 'drawing'],
            ['name' => 'neutral', 'parent_id' => 3, 'parent_name' => 'drawing'],
            ['name' => 'multiple', 'parent_id' => 3, 'parent_name' => 'drawing'],
            ['name' => 'anime', 'parent_id' => 3, 'parent_name' => 'drawing'],
            ['name' => 'cartoon', 'parent_id' => 3, 'parent_name' => 'drawing'],
            ['name' => 'animal', 'parent_id' => 3, 'parent_name' => 'drawing'],
            ['name' => 'tulang', 'parent_id' => 3, 'parent_name' => 'drawing'],
            ['name' => 'tribal', 'parent_id' => 3, 'parent_name' => 'drawing'],
            ['name' => 'mica', 'parent_id' => 3, 'parent_name' => 'drawing'],
            ['name' => 'event', 'parent_id' => 3, 'parent_name' => 'drawing'],
            ['name' => 'list',   // this is a duplicate of the list above
                // but it is used for kawahara
                // so it is not a duplicate
                'parent_id' => 3, 'parent_name' => 'drawing'
            ],
            ['name' => 'mix', 'parent_id' => 3, 'parent_name' => 'drawing'],
        ];
        $features = [
            // grade bahan
            ['category' => 'grade_bahan', 'name' => 'A', 'spk_name' => '', 'invoice_name' => 'A'],
            ['category' => 'grade_bahan', 'name' => 'B', 'spk_name' => '', 'invoice_name' => 'B'],

            // category ukuran
            ['category' => 'ukuran', 'name' => 'PK', 'spk_name' => 'uk.PK', 'invoice_name' => 'uk.PK'],
            ['category' => 'ukuran', 'name' => 'JB-93x53', 'spk_name' => 'uk.JB', 'invoice_name' => 'uk.JB'],
            ['category' => 'ukuran', 'name' => 'L', 'spk_name' => 'uk.L', 'invoice_name' => 'uk.L'],
            ['category' => 'ukuran', 'name' => 'LONG-95x51', 'spk_name' => 'uk.LONG', 'invoice_name' => 'uk.LONG'],
            ['category' => 'ukuran', 'name' => '97x68.5', 'spk_name' => 'uk.97x68', 'invoice_name' => 'uk.97x68.5'],
            ['category' => 'ukuran', 'name' => 'SuperJB-97x53', 'spk_name' => 'uk.SuperJB', 'invoice_name' => 'uk.SuperJB'],
            ['category' => 'ukuran', 'name' => 'MEGA-100x57', 'spk_name' => 'uk.MEGA', 'invoice_name' => 'uk.MEGA'],
            ['category' => 'ukuran', 'name' => 'GIGA-100x68.5', 'spk_name' => 'uk.GIGA', 'invoice_name' => 'uk.GIGA'],
            ['category' => 'ukuran', 'name' => '108x53', 'spk_name' => 'uk.108x53', 'invoice_name' => 'uk.108x53'],
            ['category' => 'ukuran', 'name' => 'Scoopy', 'spk_name' => 'uk.Scoopy', 'invoice_name' => 'uk.Scoopy'],
            ['category' => 'ukuran', 'name' => 'NMAX', 'spk_name' => 'uk.NMAX', 'invoice_name' => 'uk.NMAX'],
            ['category' => 'ukuran', 'name' => 'PCX', 'spk_name' => 'uk.PCX', 'invoice_name' => 'uk.PCX'],
            ['category' => 'ukuran', 'name' => 'Aerox', 'spk_name' => 'uk.Aerox', 'invoice_name' => 'uk.Aerox'],
            ['category' => 'ukuran', 'name' => 'FreeGo', 'spk_name' => 'uk.FreeGo', 'invoice_name' => 'uk.FreeGo'],
            ['category' => 'ukuran', 'name' => 'Vario150', 'spk_name' => 'uk.Vario150', 'invoice_name' => 'uk.Vario150'],
            ['category' => 'ukuran', 'name' => 'MioSoulGT125', 'spk_name' => 'uk.MioSoulGT125', 'invoice_name' => 'uk.MioSoulGT125'],
            ['category' => 'ukuran', 'name' => 'ADV', 'spk_name' => 'uk.ADV', 'invoice_name' => 'uk.ADV'],
            ['category' => 'ukuran', 'name' => 'LEXI', 'spk_name' => 'uk.LEXI', 'invoice_name' => 'uk.LEXI'],
            ['category' => 'ukuran', 'name' => 'FINO', 'spk_name' => 'uk.FINO', 'invoice_name' => 'uk.FINO'],
            ['category' => 'ukuran', 'name' => 'Vario 125/150', 'spk_name' => 'uk.Vario 125/150', 'invoice_name' => 'uk.Vario 125/150'],
            ['category' => 'ukuran', 'name' => 'M3', 'spk_name' => 'uk.M3', 'invoice_name' => 'uk.M3'],
            
            // category jahit
            ['category' => 'jahit', 'name' => 'Univ', 'spk_name' => 'jht.Univ', 'invoice_name' => 'jht.Univ'],
            ['category' => 'jahit', 'name' => 'ABS-RV', 'spk_name' => 'jht.ABS', 'invoice_name' => 'jht.ABS-RV'],
            ['category' => 'jahit', 'name' => 'RXK', 'spk_name' => 'jht.RXK', 'invoice_name' => 'jht.RXK'],
            ['category' => 'jahit', 'name' => 'JB', 'spk_name' => 'jht.JB', 'invoice_name' => 'jht.JB'],
            ['category' => 'jahit', 'name' => 'Scoopy', 'spk_name' => 'jht.Scoopy', 'invoice_name' => 'jht.Scoopy'],
            ['category' => 'jahit', 'name' => 'NMAX', 'spk_name' => 'jht.NMAX', 'invoice_name' => 'jht.NMAX'],
            ['category' => 'jahit', 'name' => 'PCX', 'spk_name' => 'jht.PCX', 'invoice_name' => 'jht.PCX'],
            ['category' => 'jahit', 'name' => 'Aerox', 'spk_name' => 'jht.Aerox', 'invoice_name' => 'jht.Aerox'],
            ['category' => 'jahit', 'name' => 'FreeGo', 'spk_name' => 'jht.FreeGo', 'invoice_name' => 'jht.FreeGo'],
            ['category' => 'jahit', 'name' => 'Vario150', 'spk_name' => 'jht.Vario150', 'invoice_name' => 'jht.Vario150'],
            ['category' => 'jahit', 'name' => 'MioSoulGT125', 'spk_name' => 'jht.MioSoulGT125', 'invoice_name' => 'jht.MioSoulGT125'],
            ['category' => 'jahit', 'name' => 'Warna', 'spk_name' => 'jht.Warna', 'invoice_name' => 'jht.Warna'],
            ['category' => 'jahit', 'name' => 'ADV', 'spk_name' => 'jht.ADV', 'invoice_name' => 'jht.ADV'],
            ['category' => 'jahit', 'name' => 'LEXI', 'spk_name' => 'jht.LEXI', 'invoice_name' => 'jht.LEXI'],
            ['category' => 'jahit', 'name' => 'FINO', 'spk_name' => 'jht.FINO', 'invoice_name' => 'jht.FINO'],
            ['category' => 'jahit', 'name' => 'Vario 125/150', 'spk_name' => 'jht.Vario 125/150', 'invoice_name' => 'jht.Vario 125/150'],
            ['category' => 'jahit', 'name' => 'M3', 'spk_name' => 'jht.M3', 'invoice_name' => 'jht.M3'],
            ['category' => 'jahit', 'name' => 'NMAX (Promo)', 'spk_name' => 'jht.NMAX (Promo)', 'invoice_name' => 'jht.NMAX (Promo)'],
            
            // alas
            ['category' => 'alas', 'name' => 'Alas', 'spk_name' => '', 'invoice_name' => 'Alas'],
            
            // busa
            ['category' => 'busa', 'name' => 'Busa', 'spk_name' => '', 'invoice_name' => 'Busa'],
            
            // sayap
            ['category' => 'sayap', 'name' => 'Sayap Abu', 'spk_name' => '', 'invoice_name' => 'Sayap Abu'],
            ['category' => 'sayap', 'name' => 'Sayap Hitam', 'spk_name' => '', 'invoice_name' => 'Sayap Hitam'],
            
            // list
            ['category' => 'list', 'name' => 'Benang', 'spk_name' => '', 'invoice_name' => 'Benang'],
            ['category' => 'list', 'name' => 'Benang Warna', 'spk_name' => '', 'invoice_name' => 'Benang Warna'],
            ['category' => 'list', 'name' => 'Rotan', 'spk_name' => '', 'invoice_name' => 'Rotan'],
            ['category' => 'list', 'name' => 'Rotan Warna', 'spk_name' => '', 'invoice_name' => 'Rotan Warna'],

            // general
            ['category' => 'general', 'name' => 'jht.Kepala', 'spk_name' => 'jht.Kepala', 'invoice_name' => 'jht.Kepala'],
            ['category' => 'general', 'name' => 'jht.Samping', 'spk_name' => 'jht.Samping', 'invoice_name' => 'jht.Samping'],
            ['category' => 'general', 'name' => 'PRESS', 'spk_name' => 'PRESS', 'invoice_name' => 'PRESS'],
            ['category' => 'general', 'name' => 'Alas', 'spk_name' => 'Alas', 'invoice_name' => 'Alas'],
            ['category' => 'general', 'name' => 'Busa', 'spk_name' => 'Busa', 'invoice_name' => 'Busa'],
        
            // drawing
            ['category' => 'honda', 'name' => 'C70', 'spk_name' => 'C70', 'invoice_name' => 'C70'],
            ['category' => 'honda', 'name' => 'CB', 'spk_name' => 'CB', 'invoice_name' => 'CB'],
            ['category' => 'honda', 'name' => 'Honda', 'spk_name' => 'Honda', 'invoice_name' => 'Honda'],
            ['category' => 'yamaha', 'name' => 'RXK', 'spk_name' => 'RXK', 'invoice_name' => 'RXK'],
            ['category' => 'neutral', 'name' => 'Netral', 'spk_name' => 'Netral', 'invoice_name' => 'Netral'],
            ['category' => 'neutral', 'name' => '46', 'spk_name' => '46', 'invoice_name' => '46'],
            ['category' => 'neutral', 'name' => 'Alpinestar', 'spk_name' => 'Alpinestar', 'invoice_name' => 'Alpinestar'],
            ['category' => 'neutral', 'name' => 'Bikers', 'spk_name' => 'Bikers', 'invoice_name' => 'Bikers'],
            ['category' => 'neutral', 'name' => 'Black', 'spk_name' => 'Black', 'invoice_name' => 'Black'],
            ['category' => 'neutral', 'name' => 'BRIDE', 'spk_name' => 'BRIDE', 'invoice_name' => 'BRIDE'],
            ['category' => 'neutral', 'name' => 'CW', 'spk_name' => 'CW', 'invoice_name' => 'CW'],
            ['category' => 'neutral', 'name' => 'Daytona', 'spk_name' => 'Daytona', 'invoice_name' => 'Daytona'],
            ['category' => 'neutral', 'name' => 'DBS', 'spk_name' => 'DBS', 'invoice_name' => 'DBS'],
            ['category' => 'neutral', 'name' => 'Diavel', 'spk_name' => 'Diavel', 'invoice_name' => 'Diavel'],
            ['category' => 'neutral', 'name' => 'Fox', 'spk_name' => 'Fox', 'invoice_name' => 'Fox'],
            ['category' => 'neutral', 'name' => 'HKS', 'spk_name' => 'HKS', 'invoice_name' => 'HKS'],
            ['category' => 'neutral', 'name' => 'Kitaco', 'spk_name' => 'Kitaco', 'invoice_name' => 'Kitaco'],
            ['category' => 'neutral', 'name' => 'Monster', 'spk_name' => 'Monster', 'invoice_name' => 'Monster'],
            ['category' => 'neutral', 'name' => 'MotoGP', 'spk_name' => 'MotoGP', 'invoice_name' => 'MotoGP'],
            ['category' => 'neutral', 'name' => 'Movistar', 'spk_name' => 'Movistar', 'invoice_name' => 'Movistar'],
            ['category' => 'neutral', 'name' => 'Movistar XLGP', 'spk_name' => 'Movistar XLGP', 'invoice_name' => 'Movistar XLGP'],
            ['category' => 'neutral', 'name' => 'NGO', 'spk_name' => 'NGO', 'invoice_name' => 'NGO'],
            ['category' => 'neutral', 'name' => 'Kawahara', 'spk_name' => 'Kawahara', 'invoice_name' => 'Kawahara'],
            ['category' => 'neutral', 'name' => 'RacingBoy', 'spk_name' => 'RacingBoy', 'invoice_name' => 'RacingBoy'],
            ['category' => 'neutral', 'name' => 'RacingBoy XLGP', 'spk_name' => 'RacingBoy XLGP', 'invoice_name' => 'RacingBoy XLGP'],
            ['category' => 'neutral', 'name' => 'RacingBoy Thailand', 'spk_name' => 'RacingBoy Thailand', 'invoice_name' => 'RacingBoy Thailand'],
            ['category' => 'neutral', 'name' => 'Repsol', 'spk_name' => 'Repsol', 'invoice_name' => 'Repsol'],
            ['category' => 'neutral', 'name' => 'Ride It', 'spk_name' => 'Ride It', 'invoice_name' => 'Ride It'],
            ['category' => 'neutral', 'name' => 'Rockstar', 'spk_name' => 'Rockstar', 'invoice_name' => 'Rockstar'],
            ['category' => 'neutral', 'name' => 'Rossy 46', 'spk_name' => 'Rossy 46', 'invoice_name' => 'Rossy 46'],
            ['category' => 'neutral', 'name' => '46 The Doctor', 'spk_name' => '46 The Doctor', 'invoice_name' => '46 The Doctor'],
            ['category' => 'neutral', 'name' => 'Sepatu', 'spk_name' => 'Sepatu', 'invoice_name' => 'Sepatu'],
            ['category' => 'neutral', 'name' => 'Sa-Korn', 'spk_name' => 'Sa-Korn', 'invoice_name' => 'Sa-Korn'],
            ['category' => 'neutral', 'name' => 'Somjin', 'spk_name' => 'Somjin', 'invoice_name' => 'Somjin'],
            ['category' => 'neutral', 'name' => 'TDR', 'spk_name' => 'TDR', 'invoice_name' => 'TDR'],
            ['category' => 'neutral', 'name' => 'Tokage', 'spk_name' => 'Tokage', 'invoice_name' => 'Tokage'],
            ['category' => 'neutral', 'name' => 'Upin-Ipin', 'spk_name' => 'Upin-Ipin', 'invoice_name' => 'Upin-Ipin'],
            ['category' => 'neutral', 'name' => 'Yamaha', 'spk_name' => 'Yamaha', 'invoice_name' => 'Yamaha'],
            ['category' => 'neutral', 'name' => 'Yoshimura', 'spk_name' => 'Yoshimura', 'invoice_name' => 'Yoshimura'],
            ['category' => 'neutral', 'name' => 'YSS', 'spk_name' => 'YSS', 'invoice_name' => 'YSS'],
            ['category' => 'multiple', 'name' => 'Bride 9X', 'spk_name' => 'Bride 9X', 'invoice_name' => 'Bride 9X'],
            ['category' => 'multiple', 'name' => 'Blok Bride', 'spk_name' => 'Blok Bride', 'invoice_name' => 'Blok Bride'],
            ['category' => 'multiple', 'name' => 'Blok Bride Pelangi', 'spk_name' => 'Blok Bride Pelangi', 'invoice_name' => 'Blok Bride Pelangi'],
            ['category' => 'multiple', 'name' => 'Tribal 5X', 'spk_name' => 'Tribal 5X', 'invoice_name' => 'Tribal 5X'],
            ['category' => 'multiple', 'name' => 'Tribal Bride 5X', 'spk_name' => 'Tribal Bride 5X', 'invoice_name' => 'Tribal Bride 5X'],
            ['category' => 'multiple', 'name' => 'Kawahara 8X', 'spk_name' => 'Kawahara 8X', 'invoice_name' => 'Kawahara 8X'],
            ['category' => 'multiple', 'name' => 'NGO 7X', 'spk_name' => 'NGO 7X', 'invoice_name' => 'NGO 7X'],
            ['category' => 'multiple', 'name' => 'Somjin 7X', 'spk_name' => 'Somjin 7X', 'invoice_name' => 'Somjin 7X'],
            ['category' => 'multiple', 'name' => 'Thailook 5X', 'spk_name' => 'Thailook 5X', 'invoice_name' => 'Thailook 5X'],
            ['category' => 'multiple', 'name' => 'Tribal 5X', 'spk_name' => 'Tribal 5X', 'invoice_name' => 'Tribal 5X'],
            ['category' => 'anime', 'name' => 'Doraemon', 'spk_name' => 'Doraemon', 'invoice_name' => 'Doraemon'],
            ['category' => 'anime', 'name' => 'Doraemon Jepang', 'spk_name' => 'Doraemon Jepang', 'invoice_name' => 'Doraemon Jepang'],
            ['category' => 'anime', 'name' => 'Doraemon New', 'spk_name' => 'Doraemon New', 'invoice_name' => 'Doraemon New'],
            ['category' => 'anime', 'name' => 'Straw Hat', 'spk_name' => 'Straw Hat', 'invoice_name' => 'Straw Hat'],
            ['category' => 'cartoon', 'name' => 'Kartun', 'spk_name' => 'Kartun', 'invoice_name' => 'Kartun'],
            ['category' => 'cartoon', 'name' => 'HelloKitty2', 'spk_name' => 'HelloKitty2', 'invoice_name' => 'HelloKitty2'],
            ['category' => 'cartoon', 'name' => 'Keropi', 'spk_name' => 'Keropi', 'invoice_name' => 'Keropi'],
            ['category' => 'cartoon', 'name' => 'Keropi No.9', 'spk_name' => 'Keropi No.9', 'invoice_name' => 'Keropi No.9'],
            ['category' => 'cartoon', 'name' => 'MickeyMouse', 'spk_name' => 'MickeyMouse', 'invoice_name' => 'MickeyMouse'],
            ['category' => 'cartoon', 'name' => 'Minion', 'spk_name' => 'Minion', 'invoice_name' => 'Minion'],
            ['category' => 'cartoon', 'name' => 'SpongeBob', 'spk_name' => 'SpongeBob', 'invoice_name' => 'SpongeBob'],
            ['category' => 'animal', 'name' => 'Kelabang', 'spk_name' => 'Kelabang', 'invoice_name' => 'Kelabang'],
            ['category' => 'animal', 'name' => 'Laba-Laba', 'spk_name' => 'Laba-Laba', 'invoice_name' => 'Laba-Laba'],
            ['category' => 'animal', 'name' => 'Macan', 'spk_name' => 'Macan', 'invoice_name' => 'Macan'],
            ['category' => 'animal', 'name' => 'Naga', 'spk_name' => 'Naga', 'invoice_name' => 'Naga'],
            ['category' => 'animal', 'name' => 'Scorpion', 'spk_name' => 'Scorpion', 'invoice_name' => 'Scorpion'],
            ['category' => 'tulang', 'name' => 'Prima', 'spk_name' => 'Prima', 'invoice_name' => 'Prima'],
            ['category' => 'tribal', 'name' => 'Cumi', 'spk_name' => 'Cumi', 'invoice_name' => 'Cumi'],
            ['category' => 'tribal', 'name' => 'Tribal 1-6', 'spk_name' => 'Tribal 1-6', 'invoice_name' => 'Tribal 1-6'],
            ['category' => 'tribal', 'name' => 'Tribal 1', 'spk_name' => 'Tribal 1', 'invoice_name' => 'Tribal 1'],
            ['category' => 'tribal', 'name' => 'Tribal 2', 'spk_name' => 'Tribal 2', 'invoice_name' => 'Tribal 2'],
            ['category' => 'tribal', 'name' => 'Tribal 3', 'spk_name' => 'Tribal 3', 'invoice_name' => 'Tribal 3'],
            ['category' => 'tribal', 'name' => 'Tribal 4', 'spk_name' => 'Tribal 4', 'invoice_name' => 'Tribal 4'],
            ['category' => 'tribal', 'name' => 'Tribal 5', 'spk_name' => 'Tribal 5', 'invoice_name' => 'Tribal 5'],
            ['category' => 'tribal', 'name' => 'Tribal 6', 'spk_name' => 'Tribal 6', 'invoice_name' => 'Tribal 6'],
            ['category' => 'tribal', 'name' => 'Tribal 46', 'spk_name' => 'Tribal 46', 'invoice_name' => 'Tribal 46'],
            ['category' => 'tribal', 'name' => 'Tribal Movistar', 'spk_name' => 'Tribal Movistar', 'invoice_name' => 'Tribal Movistar'],
            ['category' => 'tribal', 'name' => 'Tribal Petir', 'spk_name' => 'Tribal Petir', 'invoice_name' => 'Tribal Petir'],
            ['category' => 'tribal', 'name' => 'Trisula', 'spk_name' => 'Trisula', 'invoice_name' => 'Trisula'],
            ['category' => 'mica', 'name' => '1W', 'spk_name' => '1W', 'invoice_name' => '1W'],
            ['category' => 'event', 'name' => 'Modi', 'spk_name' => 'Modi', 'invoice_name' => 'Modi'],
            ['category' => 'list', 'name' => 'Kawahara', 'spk_name' => 'Kawahara', 'invoice_name' => 'Kawahara'],
            ['category' => 'mix', 'name' => 'Campur', 'spk_name' => 'Campur', 'invoice_name' => 'Campur'],
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

        foreach ($feature_categories as $category) {
            $scope = 'feature_types';
            CategoryTree::create([
                'scope' => $scope,
                'name' => $category['name'],
                'slug' => str_replace(' ', '-', strtolower($category['name'])),
                'parent_id' => $category['parent_id'],
                'parent_slug' => $category['parent_name'] ? str_replace(' ', '-', strtolower($category['parent_name'])) : null,
                'short_name' => $category['name'],
            ]);
        }

        foreach ($features as $feature) {
            $feature_type = CategoryTree::where('name', $feature['category'])->first();
            Feature::create([
                'category_id' => $feature_type->id,
                'category_slug' => $feature_type->slug,
                'name' => $feature['name'],
                'spk_name' => $feature['spk_name'] ?? null,
                'invoice_name' => $feature['invoice_name'] ?? null,
            ]);
        }
    }
}
