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
            $table->string("STATUS_PENDAFTARAN");
            $table->unsignedBigInteger("ID_ORDER");
            $table
                ->foreign("ID_ORDER")
                ->references("ID_ORDER")
                ->on("order");
            $table->unsignedBigInteger("ID_EVENT");
            $table
                ->foreign("ID_EVENT")
                ->references("ID_EVENT")
                ->on("event");
            $table->unsignedBigInteger("ID_FORM_PENDAFTARAN")->nullable();
            $table
                ->foreign("ID_FORM_PENDAFTARAN")
                ->references("ID_FORM_PENDAFTARAN")
                ->on("form_pendaftaran");
            $table->unsignedBigInteger("ID_PESERTA");
            $table
                ->foreign("ID_PESERTA")
                ->references("ID_PESERTA")
                ->on("peserta");
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
