<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTPembicaraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_pembicara', function (Blueprint $table) {
            $table->id();
            $table->integer('id_kuliah_umum');
            $table->string('nama');
            $table->string('jabatan');
            $table->string('foto');
            $table->string('instansi');
            $table->char('tipe');
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
        Schema::dropIfExists('t_pembicara');
    }
}
