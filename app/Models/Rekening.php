<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekening extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';
    protected $table = 'profil_dosen';
    public $timestamps = false;
    protected $primaryKey = "id_pegawai";

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'id_pegawai');
    }
}
