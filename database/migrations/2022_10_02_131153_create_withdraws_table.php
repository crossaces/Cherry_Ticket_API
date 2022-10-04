<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::create('withdraw', function (Blueprint $table) {
            $table->id('ID_WITHDRAW');
            $table->date('TGL_WITHDRAW');
            $table->integer("JUMLAH_WITHDRAW");
            $table->integer("INCOME_ADMIN");
            $table->integer("STATUS_WITHDRAW")->default("Pending");
            $table->integer("TOTAL_WITHDRAW");
            $table->string("METHOD_PAYMENT", 100);
            $table->string("NOMOR_TRANSAKSI", 100);
            $table->string("NAMA_TUJUAN", 100);
            $table->unsignedBigInteger("ID_EO");
            $table
                ->foreign("ID_EO")
                ->references("ID_EO")
                ->on("eo");
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
        Schema::dropIfExists('withdraws');
    }
};

