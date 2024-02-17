<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KuliahLapangan extends Model
{
    use HasFactory;
    protected $table = "kuliah_lapangan";
    protected $connection = 'sqlsrv';
    public $timestamps = false;

    public function matkul()
    {
        return $this->hasOne(Matkul::class, 'course_id', 'id_praktikum');
    }
}
