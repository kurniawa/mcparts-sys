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
        Schema::create('category_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('category_trees')->onDelete('set null');
            $table->string('category_slug', 50);
            $table->decimal('price', 15, 2)->default(0.00);
            $table->string('price_type', 50)->nullable(); 
            $table->string('price_category', 50)->nullable(); 
            $table->string('price_order', 50)->nullable(); 

            $table->string('created_by', 50)->nullable();
            $table->string('updated_by', 50)->nullable();
            $table->timestamp('deleted_at')->nullable(); // Soft delete
            $table->string('deleted_by', 50)->nullable(); // User who deleted the record, if applicable
            $table->string('deleted_reason', 255)->nullable(); // Reason for deletion, if applicable
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_prices');
    }
};
