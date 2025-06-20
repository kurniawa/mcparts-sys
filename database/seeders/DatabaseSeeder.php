<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use SeedingHelper;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        foreach (['users', 'customers', 'suppliers', 'expeditions',
        'addresses', 'contact_numbers', 'customer_expeditions',
        'materials', 'material_prices', 'features', 'feature_prices'] 
        as $table) {
            SeedingHelper::seedTableFromJSON($table, $this->command);
        }
        $this->call([
            ProductTypeSeeder::class,
        ]);
    }
}
