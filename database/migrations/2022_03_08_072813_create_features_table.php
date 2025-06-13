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
            $table->string('category', 50);
            $table->foreignId('parent_id')->nullable();
            $table->string('parent_name', 50)->nullable();
            $table->string('name', 50);
            $table->string('name_on_spk', 50)->nullable();
            $table->string('name_on_invoice', 50)->nullable();
            $table->string('default_price', 50)->nullable();
            $table->string('photo_path')->nullable(); // Path to the product type photo.
            $table->string('photo_url')->nullable(); // URL to the product type photo.
            $table->string('description')->nullable();
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
