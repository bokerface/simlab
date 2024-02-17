<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;
    protected $connection = "sqlsrv";
    protected $table = "pembayaran";
    public $timestamps = false;
}
