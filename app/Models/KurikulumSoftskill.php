<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KurikulumSoftskill extends Model
{
    use HasFactory;
    // protected $table = 'V_Kurikulum_Angkatan';
    protected $table = 'V_Kurikulum_Softskill';
    public $timestamps = false;
}
