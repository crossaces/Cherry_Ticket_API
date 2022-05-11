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
        Schema::create("qna", function (Blueprint $table) {
            $table->id("ID_QNA");
            $table->string("NAMA_PESERTA", 50);
            $table->string("PERTANYAAN", 200);
            $table->unsignedBigInteger("ID_EVENT");
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
        Schema::dropIfExists("qna");
    }
};
