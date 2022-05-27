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
            $table->string("NAMA_EVENT", 100)->nullable();
            $table->date("TGL_MULAI")->nullable();
            $table->date("TGL_SELESAI")->nullable();
            $table->date("TGL_ACARA_MULAI")->nullable();
            $table->date("TGL_ACARA_SELESAI")->nullable();
            $table->time("WAKTU_MULAI")->nullable();
            $table->time("WAKTU_SELESAI")->nullable();
            $table->string("STATUS_EVENT", 50)->nullable();
            $table->string("VISIBLE_EVENT", 50)->nullable();
            $table->string("EVENT_TAB", 50);
            $table->string("GAMBAR_EVENT", 50)->nullable();
            $table->string("MODE_EVENT", 50)->nullable();
            $table->string("NAMA_LOKASI", 50)->nullable();
            $table->string("DESKRIPSI", 1000)->nullable();
            $table->string("SYARAT", 1000)->nullable();
            $table->double("LNG")->nullable();
            $table->double("LAT")->nullable();
            $table->string("URL", 150)->nullable();
            $table->string("QRCODE", 50);
            $table->integer("TOTAL_TIKET_BEREDAR")->nullable();
            $table->string("TOKEN", 50);
            $table->boolean("QNA", 50);
            $table->boolean("EVALUASI", 50);
            $table->boolean("SERTIFIKAT", 50);
            $table->integer("BATAS_TIKET")->nullable();
            $table->string("KOMENTAR", 256)->nullable()->nullable();
            $table->unsignedBigInteger("ID_JENIS_ACARA")->nullable();           
            $table
                ->foreign("ID_JENIS_ACARA")
                ->references("ID_JENIS_ACARA")
                ->on("jenis_acara");
            $table->unsignedBigInteger("ID_KOTA")->nullable();
            $table
                ->foreign("ID_KOTA")
                ->references("ID_KOTA")
                ->on("kota");
            $table->unsignedBigInteger("ID_GENRE")->nullable();
            $table
                ->foreign("ID_GENRE")
                ->references("ID_GENRE")
                ->on("genre");
            $table->unsignedBigInteger("ID_EO");
            $table
                ->foreign("ID_EO")
                ->references("ID_EO")
                ->on("eo");
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
