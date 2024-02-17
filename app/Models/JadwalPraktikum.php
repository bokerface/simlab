<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPraktikum extends Model
{
    use HasFactory;
    protected $connection = "sqlsrv";
    protected $table = "V_Course_Sched";

    public function matkul()
    {
        return $this->hasOne(Matkul::class, 'course_id', 'COURSE_ID');
    }

    public function dosen()
    {
        return $this->hasOne(Dosen::class, 'id_pegawai', 'ID_PEGAWAI');
    }
}
