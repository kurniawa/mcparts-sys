<?php

namespace App\Console\Commands;

use App\Models\CategoryTree;
use App\Models\Wallet;
use DB;
use Illuminate\Console\Command;

class SeedingWallets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:seeding-wallets';

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
        // Seeding Category Trees
        $category_trees = [
            ['scope' => 'accounting', "name" => "Safe", "slug" => "safe", "parent_id" => null, "parent_slug" => null, "short_name" => "Safe",],
            ['scope' => 'accounting', "name" => "Bank", "slug" => "bank", "parent_id" => null, "parent_slug" => null, "short_name" => "Bank",],
            ['scope' => 'accounting', 'name' => 'E-Wallet', 'slug' => 'ewallet', 'parent_id' => null, 'parent_slug' => null, 'short_name' => 'E-Wallet',],
        ];
        foreach ($category_trees as $category_tree) {
            CategoryTree::create([
                'id' => $category_tree['id'],
                'name' => $category_tree['name'],
                'slug' => $category_tree['slug'],
                'short_name' => $category_tree['short_name'],
            ]);
        }
        $user_instances = DB::connection('mysql_old')->table('user_instances')->orderBy('id')->get();
        foreach ($user_instances as $user_instance) {
            $category_tree = CategoryTree::where('short_name', $user_instance->instance_type)->first();
            Wallet::create([
                'id' => $user_instance->id,
                'category_id' => $category_tree->id,
                'category_slug' => $category_tree->slug,
                'user_id' => $user_instance->user_id,
                'username' => $user_instance->username,
                'name' => $user_instance->instance_name,
                'account_number' => $user_instance->account_number,
                'account_holder' => null,
                'balance' => null,
            ]);
        }
    }
}
