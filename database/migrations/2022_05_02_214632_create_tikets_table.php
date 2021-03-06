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
        Schema::create("tiket", function (Blueprint $table) {
            $table->id("ID_TIKET");
            $table->string("NAMA_TIKET", 255);
            $table->string("FASILITAS", 255);
            $table->integer("HARGA");
            $table->integer("STOK");
            $table->date("TGL_MULAI_PENJUALAN");
            $table->date("TGL_SELESAI_PENJUALAN");
            $table->unsignedBigInteger("ID_EVENT");
            $table
                ->foreign("ID_EVENT")
                ->references("ID_EVENT")
                ->on("event");
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
        Schema::dropIfExists("tiket");
    }
};
