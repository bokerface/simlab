<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        if (session('user_data')['role'] == 1) {
            return view('home');
        } else {
            $survey = DB::table('surveys')
                ->select(
                    '*',
                    DB::raw("FORMAT(expires_at,'dd/MM/yyyy') as expires_at")
                )
                ->where('is_active', '=', 1)
                ->first();

            if (!empty($survey)) {
                $data_survey_participant = DB::table('survey_participants')
                    ->where([
                        ['user_id', '=', session('user_data')['user_id']],
                        ['survey_id', '=', $survey->id_survey],
                    ])
                    ->first();
            }

            if ((empty($data_survey_participant)) || ($data_survey_participant->finish_date == null)) {
                $survey_done = false;
            } else {
                $survey_done = true;
            }

            return view('mhs-dsn-home', [
                'survey_done' => $survey_done,
                'survey_data' => $survey
            ]);
        }
    }
}
