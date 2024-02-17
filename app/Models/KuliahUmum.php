<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KuliahUmum extends Model
{
    use HasFactory;
    protected $table = 'kuliah_umum';
    protected $connection = 'sqlsrv';
    public $timestamps = false;

    public function matkul()
    {
        return $this->hasOne(Matkul::class, 'course_id', 'id_praktikum');
    }
}
