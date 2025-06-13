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
        Schema::create('feature_prices', function (Blueprint $table) {
            $table->id();
            $table->string('feature_name', 50);
            $table->foreignId('feature_id')->constrained('features')->onDelete('CASCADE');
            $table->decimal('price', 15, 2)->default(0.00);
            $table->string('type', 20)->default('previous');
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
        Schema::dropIfExists('feature_prices');
    }
};
