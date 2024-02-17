<?php

namespace Bokerface\Survey\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipantSurveyAnswer extends Model
{
    use HasFactory;

    protected $table = 'survey_answers';
    protected $primaryKey  = 'survey_answer_id';
    public $timestamps = false;
}
