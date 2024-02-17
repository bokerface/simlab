<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKuliahLapanganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kuliah_lapangan', function (Blueprint $table) {
            $table->id();
            $table->string('acara');
            $table->dateTime('tanggal_start');
            $table->dateTime('tanggal_end');
            $table->string('instansi');
            $table->string('tema');
            $table->string('id_praktikum');
            $table->integer('tahun_ajaran');
            $table->smallInteger('semester');
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
        Schema::dropIfExists('kuliah_lapangan');
    }
}
