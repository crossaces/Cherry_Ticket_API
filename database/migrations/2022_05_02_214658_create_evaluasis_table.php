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
        Schema::create("evaluasi", function (Blueprint $table) {
            $table->id("ID_EVALUASI");
            $table->json("DATA_JAWABAN");
            $table->unsignedBigInteger("ID_FORM_EVALUASI");
            $table
                ->foreign("ID_FORM_EVALUASI")
                ->references("ID_FORM_EVALUASI")
                ->on("form_evaluasi");
            $table->unsignedBigInteger("ID_PENDAFTARAN");
            $table
                ->foreign("ID_PENDAFTARAN")
                ->references("ID_PENDAFTARAN")
                ->on("pendaftaran_peserta");
            $table->softDeletes();
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
        Schema::dropIfExists("evaluasi");
    }
};
