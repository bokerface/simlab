<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';
    protected $table = 'V_Dosen';
    protected $primaryKey = 'id_pegawai';
    public $timestamps = false;

    public function rekening()
    {
        return $this->hasOne(Rekening::class, 'id_pegawai');
    }
}
