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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string("type", 20)->nullable(); // pribadi, organisasi/badan/perusahaan
            $table->string('role', 20)->nullable(); // ["kreditur", "debitur"]
            $table->string("business_entity", 10)->nullable(); // PT, CV, Yayasan, Sekolah, dll.
            $table->string("company_name", 100)->nullable();
            $table->string("organization_name", 100)->nullable();
            $table->string("store_name", 100)->nullable();
            $table->string("owner_name", 100);
            $table->string("nickname", 10)->nullable();
            $table->enum("gender", ['male', 'female'])->nullable();
            $table->string("id_type", 20)->nullable();
            $table->string("id_number", 50)->nullable();
            $table->string("alias", 100)->nullable();
            $table->string("title", 20)->nullable();
            $table->string("initial", 10)->nullable();
            $table->date("birthday")->nullable();
            $table->string("description")->nullable();
            $table->enum("is_reseller", ['yes', 'no'])->nullable()->default('no');
            $table->bigInteger("reseller_id")->nullable();
            $table->string('created_by', 50)->nullable();
            $table->string('updated_by', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
