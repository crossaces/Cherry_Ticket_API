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
        Schema::create("EO", function (Blueprint $table) {
            $table->id("ID_EO");
            $table->string("NAMA_EO", 50);
            $table->string("LINK_WEB", 255)->nullable();
            $table->string("ALAMAT", 255)->nullable();
            $table->string("GAMBAR", 100)->nullable();
            $table->string("STATUS_EO", 50)->default("Active");
            $table->unsignedBigInteger("ID_USER");
            $table
                ->foreign("ID_USER")
                ->references("id")
                ->on("users");
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
        Schema::dropIfExists("EO");
    }
};
