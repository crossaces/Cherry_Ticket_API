<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("sertifikat", function (Blueprint $table) {
            $table->id("ID_SERTIFIKAT");
            $table->string("NAMA_SATU", 50)->nullable();
            $table->string("NAMA_DUA", 50)->nullable();
            $table->string("NAMA_TIGA", 50)->nullable();
            $table->string("DESKRIPSI_SERTIFIKAT", 250)->nullable();
            $table->string("TANDA_TANGAN_SATU", 50)->nullable();
            $table->string("TANDA_TANGAN_DUA", 50)->nullable();
            $table->string("TANDA_TANGAN_TIGA", 50)->nullable();
            $table->string("BAHASA", 50);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("sertifikat");
    }
};
