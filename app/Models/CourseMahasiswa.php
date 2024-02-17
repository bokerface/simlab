<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseMahasiswa extends Model
{
    use HasFactory;
    protected $table = 'V_Student_Course_Krs';
    protected $connection = 'sqlsrv';

    public function mahasiswa()
    {
        $this->hasOne(Mahasiswa::class, 'STUDENTID', 'studentid');
    }

    public function nama_matkul()
    {
        return $this->hasOne(Matkul::class, 'course_id', 'course_id');
    }
}
