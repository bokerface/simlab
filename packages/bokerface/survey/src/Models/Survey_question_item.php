<?php

namespace Bokerface\Survey\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey_question_item extends Model
{
    use HasFactory;

    protected $primaryKey  = 'survey_question_id';
    protected $table = 'survey_question_items';
    public $timestamps = false;
}
