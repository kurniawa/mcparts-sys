<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * Produks ini nanti nya akan berkaitan dengan table2 yang lain, meski tidak ada relasi yang dibuat pada table ini.
         * Tergantung dari tipe nya, semisal SJ-Variasi, berarti nantinya dia akan berkaitan dengan bahan, variasi, ukuran dan jahit.
         *
         */
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->nullable()->constrained()->onDelete('set null');
            $table->string('supplier_name', 100)->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('category_trees')->onDelete('set null');
            $table->string('parent_slug', 50)->nullable();
            $table->foreignId('category_id')->nullable()->constrained('category_trees')->onDelete('set null');
            $table->string('category_slug', 50)->nullable();
            $table->string('type', 50)->nullable();
            $table->string('pure_name');
            $table->string('name');
            $table->string('invoice_name');
            $table->string('packaging_type', 20)->nullable();
            $table->smallInteger('packaging_rule')->nullable();
            $table->string('image_path')->nullable();
            $table->string('image_url')->nullable(); // URL to the product type photo.
            $table->string('description')->nullable();

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
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
