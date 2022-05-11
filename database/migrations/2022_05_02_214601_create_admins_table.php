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
        Schema::create("admin", function (Blueprint $table) {
            $table->id("ID_ADMIN");
            $table->string("NAMA_DEPAN", 50);
            $table->string("NAMA_BELAKANG", 50)->nullable();
            $table->string("STATUS", 50)->default("Active");
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
        Schema::dropIfExists("admin");
    }
};
