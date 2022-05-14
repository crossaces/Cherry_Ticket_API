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
        Schema::create("jenis_acara", function (Blueprint $table) {
            $table->id("ID_JENIS_ACARA");
            $table->string("NAMA_JENIS", 50);
            $table->string("STATUS", 50)->nullable();
            $table->string("GAMBAR", 50)->nullable();
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
        Schema::dropIfExists("jenis_acara");
    }
};
