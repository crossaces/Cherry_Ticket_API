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
        Schema::create("order", function (Blueprint $table) {
            $table->id("ID_ORDER");
            $table->integer("JUMLAH");
            $table->integer("SUBTOTAL");
            $table->unsignedBigInteger("ID_TRANSAKSI");
            $table
                ->foreign("ID_TRANSAKSI")
                ->references("ID_TRANSAKSI")
                ->on("transaksi");
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
        Schema::dropIfExists("order");
    }
};
