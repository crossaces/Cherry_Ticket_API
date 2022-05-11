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
        Schema::create("pendaftaran_peserta", function (Blueprint $table) {
            $table->id("ID_PENDAFTARAN");
            $table->json("DATA_PERTANYAAN");
            $table->integer("NOMOR_TIKET");
            $table->string("STATUS_PENDAFTARAN");
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
        Schema::dropIfExists("pendaftaran_peserta");
    }
};
