<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('check', function (Blueprint $table) {
            $table->id('ID_CHECK');
            $table->date('TGL_CHECK');
            $table->string('STATUS_CHECK');
            $table->unsignedBigInteger("ID_PESERTA");
            $table
                ->foreign("ID_PESERTA")
                ->references("ID_PESERTA")
                ->on("peserta");
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
        Schema::dropIfExists('check');
    }
};
