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
        Schema::create("event", function (Blueprint $table) {
            $table->id("ID_EVENT");
            $table->string("NAMA_EVENT", 100);
            $table->date("TGL_MULAI");
            $table->date("TGL_SELESAI");
            $table->date("TGL_ACARA_MULAI");
            $table->date("TGL_ACARA_SELESAI")->nullable();
            $table->string("STATUS_EVENT", 50)->nullable();
            $table->string("MODE_EVENT", 50);
            $table->string("NAMA_LOKASI", 50);
            $table->double("LNG");
            $table->double("LAT");
            $table->string("URL", 150);
            $table->string("QRCode", 50);
            $table->string("Token", 50);
            $table->integer("BATAS_TIKET");
            $table->string("KOMENTAR", 256)->nullable();
            $table->unsignedBigInteger("ID_JENIS_ACARA");
            $table
                ->foreign("ID_JENIS_ACARA")
                ->references("ID_JENIS_ACARA")
                ->on("JENIS_ACARA");
            $table->unsignedBigInteger("ID_KOTA");
            $table
                ->foreign("ID_KOTA")
                ->references("ID_KOTA")
                ->on("KOTA");
            $table->unsignedBigInteger("ID_EO");
            $table
                ->foreign("ID_EO")
                ->references("ID_EO")
                ->on("EO");
            $table->unsignedBigInteger("ID_SERTIFIKAT");
            $table
                ->foreign("ID_SERTIFIKAT")
                ->references("ID_SERTIFIKAT")
                ->on("SERTIFIKAT");
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
        Schema::dropIfExists("event");
    }
};
