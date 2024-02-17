<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;
    protected $table = 'V_Mahasiswa';
    protected $primaryKey = 'STUDENTID';

    public function course()
    {
        return $this->hasOne(CourseMahasiswa::class, 'studentid', 'STUDENTID');
    }
}
