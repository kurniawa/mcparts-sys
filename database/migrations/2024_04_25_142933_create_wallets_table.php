<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('category_trees');
            $table->string('category_slug')->nullable();
            $table->foreignId('user_id')->nullable()->constrained(); // who manages this wallet
            $table->string('username', 50)->unique();
            $table->string('type', 20)->nullable(); // laci, bank atau ewallet
            $table->string('name', 20)->unique(); // tunai, BCA atau GoPay
            $table->string('account_number', 50)->nullable();
            $table->string('account_holder')->nullable();
            $table->decimal('balance', 15, 2)->nullable();
            // $table->decimal('initial_balance', 15, 2)->default(0);
            // $table->decimal('current_balance', 15, 2)->default(0);
            $table->char('currency', 3)->default('IDR');
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
