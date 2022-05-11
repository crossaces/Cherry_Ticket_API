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
        Schema::create("form_pendaftaran", function (Blueprint $table) {
            $table->id("ID_FORM_PENDAFTARAN");
            $table->json("DATA_PERTANYAAN");
            $table->unsignedBigInteger("ID_EVENT");
            $table->unsignedBigInteger("ID_USER");
            $table
                ->foreign("ID_USER")
                ->references("id")
                ->on("users");
            $table
                ->foreign("ID_EVENT")
                ->references("ID_EVENT")
                ->on("EVENT");
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
        Schema::dropIfExists("form_pendaftaran");
    }
};
