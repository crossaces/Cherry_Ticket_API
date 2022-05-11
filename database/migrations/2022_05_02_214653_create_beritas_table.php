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
        Schema::create("berita", function (Blueprint $table) {
            $table->id("ID_BERITA");
            $table->date("TGL_MULAI");
            $table->date("TGL_SELESAI");
            $table->string("JUDUL", 100);
            $table->string("DESKRIPSI", 1000);
            $table->string("GAMBAR_BERITA")->nullable();
            $table->unsignedBigInteger("ID_ADMIN");
            $table
                ->foreign("ID_ADMIN")
                ->references("ID_ADMIN")
                ->on("admin");
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
        Schema::dropIfExists("berita");
    }
};
