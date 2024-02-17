<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilDosenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profil_dosen', function (Blueprint $table) {
            $table->id();
            $table->integer('id_pegawai');
            $table->string('no_rek');
            $table->string('bank');
            $table->string('cabang');
            $table->string('nama_rekening');
            $table->string('telepon');
            $table->string('whatsapp');
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
        Schema::dropIfExists('profil_dosen');
    }
}
