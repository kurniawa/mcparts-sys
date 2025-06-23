<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable();
            $table->string('category_slug', 50)->nullable();
            $table->string('name', 50);
            $table->string('spk_name', 50)->nullable();
            $table->string('invoice_name', 50)->nullable();
            $table->string('default_price', 50)->nullable();
            $table->string('photo_path')->nullable(); // Path to the product type photo.
            $table->string('photo_url')->nullable(); // URL to the product type photo.
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
        Schema::dropIfExists('features');
    }
};
