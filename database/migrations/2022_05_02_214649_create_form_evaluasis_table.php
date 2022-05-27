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
        Schema::create("form_evaluasi", function (Blueprint $table) {
            $table->id("ID_FORM_EVALUASI");
            $table->json("DATA_PERTANYAAN")->nullable();
            $table->unsignedBigInteger("ID_EVENT")->nullable();
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
        Schema::dropIfExists("form_evaluasi");
    }
};
