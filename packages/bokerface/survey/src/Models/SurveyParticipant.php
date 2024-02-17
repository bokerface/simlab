<?php

namespace Bokerface\Survey\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyParticipant extends Model
{
    use HasFactory;

    protected $primaryKey  = 'participant_id';
    protected $table = 'survey_participants';
    public $timestamps = false;
}
