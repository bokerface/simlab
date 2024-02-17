<?php

namespace Bokerface\Survey\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $primaryKey  = 'id_survey';
    public $timestamps = false;
}
