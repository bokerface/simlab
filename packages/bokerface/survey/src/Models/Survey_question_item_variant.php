<?php

namespace Bokerface\Survey\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey_question_item_variant extends Model
{
    use HasFactory;

    protected $primaryKey  = 'survey_question_variant_id';
    public $timestamps = false;
}
