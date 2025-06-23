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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string("type", 50)->nullable(); // pribadi, organisasi/badan/perusahaan
            $table->string('role', 50)->nullable(); // ["kreditur", "debitur"]
            $table->string("business_entity", 50)->nullable(); // PT, CV, Yayasan, Sekolah, dll.
            $table->string("name", 100);
            $table->string("company_name", 100)->nullable();
            $table->string("organization_name", 100)->nullable();
            $table->string("store_name", 100)->nullable();
            $table->string("owner_name", 100)->nullable();;
            $table->string("nickname", 10)->nullable();
            $table->enum("gender", ['male', 'female'])->nullable();
            $table->string("id_type", 20)->nullable();
            $table->string("id_number", 50)->nullable();
            $table->string("alias", 100)->nullable();
            $table->string("title", 50)->nullable();
            $table->string("initial", 10)->nullable();
            $table->date("birthday")->nullable();
            $table->string("description")->nullable();
            $table->enum("is_reseller", ['yes', 'no'])->nullable()->default('no');
            $table->bigInteger("reseller_id")->nullable();

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
        Schema::dropIfExists('customers');
    }
};
