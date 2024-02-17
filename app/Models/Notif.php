<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notif extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_notif';
    protected $table = 'tr_notif';
    // public $timestamps = false;
}
