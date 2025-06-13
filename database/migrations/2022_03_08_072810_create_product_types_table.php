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
        Schema::create('product_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50); // Kulit Jok Motor, Tank Pad, Busa Stang, dll.
            $table->string('slug', 50)->unique(); // kulit-jok-motor, tank-pad, busa-stang, dll.
            $table->foreignId('parent_id')->nullable();
            $table->string('parent_slug', 50)->nullable();
            $table->string('short_name', 50); 
            $table->string('abbreviation', 10)->nullable();
            $table->string('photo_path')->nullable(); // Path to the product type photo.
            $table->string('photo_url')->nullable(); // URL to the product type photo.
            $table->string('description', 1000)->nullable();
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
        Schema::dropIfExists('product_types');
    }
};
