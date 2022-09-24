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
        Schema::create("sertifikat", function (Blueprint $table) {
            $table->id("ID_SERTIFIKAT");    
            $table->string("BACKGROUND", 50)->nullable();
            $table->integer("RED")->nullable();
            $table->integer("BLUE")->nullable();
            $table->integer("GREEN")->nullable();
            $table->integer("FONT_SIZE")->nullable();
            $table->integer("X")->nullable();
            $table->integer("Y")->nullable();
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
        Schema::dropIfExists("sertifikat");
    }
};
