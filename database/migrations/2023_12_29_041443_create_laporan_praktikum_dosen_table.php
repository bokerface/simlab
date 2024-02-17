<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanPraktikumDosenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laporan_praktikum_dosen', function (Blueprint $table) {
            $table->id();
            $table->string('id_praktikum');
            $table->string('id_dosen');
            $table->integer('tahun');
            $table->text('laporan_praktikum');
            $table->text('laporan_kuliah_umum');
            $table->text('laporan_kuliah_lapangan');
            $table->text('catatan1');
            $table->text('catatan2');
            $table->text('catatan3');
            $table->string('praktikum_selesai');
            $table->string('kuliah_umum_selesai');
            $table->string('kuliah_lapangan_selesai');
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
        Schema::dropIfExists('laporan_praktikum_dosen');
    }
}
