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
        Schema::create('customer_expeditions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('CASCADE');
            $table->foreignId('expedition_id')->constrained()->onDelete('CASCADE');
            $table->string('customer_name', 100)->nullable();
            $table->string('expedition_name', 100)->nullable();
            $table->string('expedition_type', 50)->nullable(); // transit
            $table->string('expedition_status', 50)->nullable(); // active, inactive, etc.
            $table->string('expedition_order', 50)->nullable(); // Order of the expedition, e.g., 1 for primary, 2 for secondary, etc.
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
        Schema::dropIfExists('customer_expeditions');
    }
};
