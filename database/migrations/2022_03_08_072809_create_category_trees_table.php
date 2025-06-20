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
        Schema::create('category_trees', function (Blueprint $table) {
            $table->id();
            $table->string('scope', 50); // product, feature, etc.
            $table->string('name', 50); // Kulit Jok Motor, Tank Pad, Busa Stang, dll.
            $table->string('slug', 50)->unique(); // kulit-jok-motor, tank-pad, busa-stang, dll.
            $table->foreignId('parent_id')->nullable();
            $table->string('parent_slug', 50)->nullable();
            $table->string('short_name', 50); 
            $table->string('abbreviation', 10)->nullable();
            $table->string('photo_path')->nullable(); // Path to the product type photo.
            $table->string('photo_url')->nullable(); // URL to the product type photo.
            $table->decimal('price', 15, 2)->nullable();
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
     */
    public function down(): void
    {
        Schema::dropIfExists('category_trees');
    }
};
