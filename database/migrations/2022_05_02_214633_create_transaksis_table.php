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
        Schema::create("transaksi", function (Blueprint $table) {
            $table->id("ID_TRANSAKSI");
            $table->date("TGL_TRANSAKSI");
            $table->string("STATUS_TRANSAKSI", 50);
            $table->string("METODE_PEMBAYARAN", 50);
            $table->unsignedBigInteger("ID_PESERTA");
            $table
                ->foreign("ID_PESERTA")
                ->references("ID_PESERTA")
                ->on("PESERTA");
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
        Schema::dropIfExists("transaksi");
    }
};
