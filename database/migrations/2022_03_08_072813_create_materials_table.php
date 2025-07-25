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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->nullable()->unique();
            $table->foreignId('supplier_id')->nullable();
            $table->string('supplier_name', 50)->nullable();
            $table->string('supplier_item_name')->nullable();
            $table->string('supplier_item_code', 50)->nullable();
            $table->enum('grade', ['A','B'])->nullable(); // ada grade A dan B
            $table->decimal('thickness', 2, 1)->nullable(); // Ketebalan dalam mm
            $table->string('texture', 50)->nullable(); // misalnya: motif urat tangan
            $table->string('color', 50)->nullable();
            $table->string('backing_color', 50)->nullable();
            $table->string('stamp', 50)->nullable(); // merek yang tercantum, misalnya: "MC"
            $table->decimal('default_price', 15, 2)->default(0.00); // Harga per meter
            $table->string('image_path')->nullable();
            $table->string('image_url')->nullable(); // URL to the product type photo.
            $table->string('description', 1000)->nullable();

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
        Schema::dropIfExists('materials');
    }
};
