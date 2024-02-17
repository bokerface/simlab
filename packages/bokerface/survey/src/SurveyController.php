<?php

namespace Bokerface\Survey;

use App\Http\Controllers\Controller;
use Bokerface\Survey\Models\ParticipantSurveyAnswer;
use Bokerface\Survey\Models\Survey;
use Bokerface\Survey\Models\Survey_question_item;
use Bokerface\Survey\Models\Survey_question_item_variant;
use Bokerface\Survey\Models\SurveyParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SurveyQuestionItems;

use function GuzzleHttp\Promise\all;

class SurveyController extends Controller
{

    public function index()
    {
        if (session('user_data')['role'] == 1) {
            return redirect()->to('survey/daftar-survey');
        }

        $survey = DB::table('surveys')
            ->where('is_active', '=', 1)
            ->first();

        $query_pertanyaan = DB::table('survey_question_items')
            ->where(
                [
                    ['survey_id', '=', $survey->id_survey],
                    ['is_active', '=', 1],
                ]
            )
            ->get();

        $survey_participant = DB::table('survey_participants')->where(
            [
                ['user_id', '=', session('user_data')['user_id']],
                ['role', '=', session('user_data')['role']],
                ['survey_id', '=', $survey->id_survey]
            ]
        )->first();

        if (empty($survey_participant)) {
            $survey_participant = new SurveyParticipant();
            $survey_participant->survey_id = $survey->id_survey;
            $survey_participant->user_id = session('user_data')['user_id'];
            $survey_participant->role = session('user_data')['role'];
            $survey_participant->start_date = date('Y-m-d H:i:s');
            $survey_participant->save();
        }

        if (!empty($survey_participant->finish_date)) {
            return redirect()->to(url('/'))->withErrors(['type' => 'danger', 'message' => 'anda sudah mengisi survey']);
        }

        $pertanyaan = [];

        foreach ($query_pertanyaan as $query_pertanyaan) {
            $pertanyaan[] = [
                'pertanyaan' => $query_pertanyaan->question,
                'jawaban' => call_user_func(function () use ($query_pertanyaan) {
                    $query = DB::table('survey_question_item_variants')
                        ->where('survey_question_id', '=',   $query_pertanyaan->survey_question_id)
                        ->get();

                    if ($query_pertanyaan->question_type_id == 1) {
                        $is_required = $query_pertanyaan->is_required;
                        $option = '';
                        foreach ($query as $jawaban) {
                            $option .= "<div class='form-check mr-3'>";
                            $option .= "<input class='form-check-input' type='radio' name='$query_pertanyaan->survey_question_id' value='$jawaban->survey_question_variant_id,$jawaban->variant' id='$jawaban->survey_question_variant_id' $is_required>";
                            $option .= "<label class='form-check-label' for='$jawaban->survey_question_variant_id'>$jawaban->variant</label>";
                            $option .= "</div>";
                        }
                        return $option;
                    } elseif ($query_pertanyaan->question_type_id == 2) {
                        $is_required = $query_pertanyaan->is_required;
                        $option = '';
                        foreach ($query as $jawaban) {
                            $option .= "<div class='form-check mr-3'>";
                            $option .= "<input class='form-check-input' type='checkbox' name='$query_pertanyaan->survey_question_id[]' value='$jawaban->survey_question_variant_id,$jawaban->variant' id='$jawaban->survey_question_variant_id' $is_required>";
                            $option .= "<label class='form-check-label' for='$jawaban->survey_question_variant_id'>$jawaban->variant</label>";
                            $option .= "</div>";
                        }
                        return $option;
                    } else {
                        $is_required = $query_pertanyaan->is_required;
                        return "<textarea class='form-control' name='$query_pertanyaan->survey_question_id' id='validationTextarea' rows='3' $is_required></textarea>";
                    }
                })
            ];
        }

        // dd($pertanyaan);

        return view(
            'survey::survey',
            [
                'survey' => $survey,
                'daftar_pertanyaan' => $pertanyaan
            ]
        );
    }

    public function submit_survey(Request $request)
    {
        // dump($request->all());

        $survey_participant = SurveyParticipant::where(
            [
                ['user_id', '=', session('user_data')['user_id']],
                ['role', '=', session('user_data')['role']],
                ['survey_id', '=', $request->survey_id]
            ]
        )
            ->first();
        $survey_participant->finish_date = date('Y-m-d H:i:s');
        $survey_participant->save();

        $daftar_jawaban = $request->all();

        foreach ($daftar_jawaban as $id_pertanyaan => $value) {

            if (is_int($id_pertanyaan)) {
                $question_type = DB::table('survey_question_items')
                    ->select('question_type_id')
                    ->where([
                        ['survey_question_id', '=', $id_pertanyaan],
                        ['survey_id', '=', $request->survey_id]
                    ])
                    ->first();

                if ($question_type->question_type_id == 1) {
                    $answer = explode(',', $value);
                    $survey_answer = new ParticipantSurveyAnswer();
                    $survey_answer->participant_id = $survey_participant->first()->participant_id;
                    $survey_answer->survey_id = $request->survey_id;
                    $survey_answer->survey_question_id = $id_pertanyaan;
                    $survey_answer->survey_question_variant_id = $answer[0];
                    $survey_answer->answer_text = $answer[1];
                    $survey_answer->save();
                } elseif ($question_type->question_type_id == 2) {
                    foreach ($value as $key => $single) {
                        $answer = explode(',', $single);
                        $survey_answer = new ParticipantSurveyAnswer();
                        $survey_answer->participant_id = $survey_participant->first()->participant_id;
                        $survey_answer->survey_id = $request->survey_id;
                        $survey_answer->survey_question_id = $id_pertanyaan;
                        $survey_answer->survey_question_variant_id = $answer[0];
                        $survey_answer->answer_text = $answer[1];
                        $survey_answer->save();
                    }
                } else {
                    $survey_answer = new ParticipantSurveyAnswer();
                    $survey_answer->participant_id = $survey_participant->first()->participant_id;
                    $survey_answer->survey_id = $request->survey_id;
                    $survey_answer->survey_question_id = $id_pertanyaan;
                    $survey_answer->question_item_other = $value;
                    $survey_answer->save();
                }
            }
        }
        return redirect()->to(url('/'))->with('success', ['type' => 'success', 'message' => 'Survey berhasil dikirim!']);
    }

    public function list()
    {
        $daftar_survey = DB::table('surveys')->get();

        return view('survey::survey-list', ['daftar_survey' => $daftar_survey]);
    }

    public function create()
    {
        return view('survey::create');
    }

    public function store(Request $request)
    {
        $rules = [
            'nama_survey' => 'required|string',
            'deskripsi_survey' => 'required|string',
            'expired_date' => 'required|date',
        ];

        $customMessages = [
            'required' => ':attribute wajib diisi'
        ];

        $validated = $request->validate($rules, $customMessages);

        $survey = new Survey();
        $survey->survey_name = $validated['nama_survey'];
        $survey->survey_description = $validated['deskripsi_survey'];
        $survey->created_at = date("Y-m-d");
        $survey->expires_at = $validated['expired_date'];
        if ($survey->save()) {
            return redirect()->to(url('survey/edit' . '/' . $survey->id_survey));
        }
    }

    public function edit($id_survey)
    {
        $detail = DB::table('surveys')
            ->select(
                '*',
                // DB::raw("FORMAT(expires_at,'dd/MM/yyyy') as expires_at")
            )
            ->where([
                ['id_survey', '=', $id_survey]
            ])
            ->first();

        // dd($detail);

        $pertanyaan = DB::table('survey_question_items')
            ->where([
                ['survey_id', '=', $id_survey]
            ])->get();

        $detail_pertanyaan = [];

        foreach ($pertanyaan as $pertanyaan) {

            $detail_pertanyaan[] = [
                'pertanyaan' => $pertanyaan->question,
                'id_pertanyaan' => $pertanyaan->survey_question_id,
                'id_jenis_pertanyaan' => $pertanyaan->question_type_id,
                'jawaban' => call_user_func(function () use ($pertanyaan) {
                    if ($pertanyaan->question_type_id == 1 || $pertanyaan->question_type_id == 2) {
                        $variant = DB::table('survey_question_item_variants')
                            ->where('survey_question_id', '=', $pertanyaan->survey_question_id)
                            ->get();

                        $persentase_jawaban = [];

                        foreach ($variant as $jawaban) {
                            $persentase_jawaban[] = [
                                'jawaban' => $jawaban->variant,
                                'persentase' => call_user_func(function () use ($jawaban) {
                                    $jumlah_spesifik_jawaban = DB::table('survey_answers')
                                        ->where('survey_question_variant_id', '=', $jawaban->survey_question_variant_id)
                                        ->count();

                                    $jumlah_total_jawaban = DB::table('survey_answers')
                                        ->where('survey_question_id', '=', $jawaban->survey_question_id)
                                        ->count();

                                    if ($jumlah_total_jawaban > 0) {
                                        return number_format(($jumlah_spesifik_jawaban / $jumlah_total_jawaban) * (100));
                                    }
                                    return number_format(0);
                                })
                            ];
                        }

                        return $persentase_jawaban;
                    } else {
                        $query_jawaban = DB::table('survey_answers')
                            ->where('survey_question_id', '=', $pertanyaan->survey_question_id)
                            ->get();

                        $jawaban = [];
                        foreach ($query_jawaban as $isi_jawaban) {
                            $jawaban[] = [
                                'text' => $isi_jawaban->question_item_other
                            ];
                        }

                        return url("survey/detail-jawaban-survey/" . $pertanyaan->survey_question_id);
                    }
                })
            ];
        }
        // die();

        // dd($detail_pertanyaan);

        return view('survey::edit', [
            'id_survey' => $id_survey,
            'detail_survey' => $detail,
            'pertanyaan' => $detail_pertanyaan
        ]);
    }

    public function update(Request $request, $id_survey)
    {
        $rules = [
            'nama_survey' => 'required|string',
            'deskripsi_survey' => 'required|string',
            'expired_date' => 'required|date',
        ];

        $customMessages = [
            'required' => ':attribute wajib diisi'
        ];

        $validated = $request->validate($rules, $customMessages);

        $survey = Survey::find($id_survey);
        $survey->survey_name = $validated['nama_survey'];
        $survey->survey_description = $validated['deskripsi_survey'];
        $survey->expires_at = $validated['expired_date'];
        if (!empty($request->aktif == 1)) {
            $survey->is_active = 1;
        } else {
            $survey->is_active = 0;
        }
        $survey->save();

        return redirect()->back();

        // dd($survey->id_survey);

        // dd($validated);
    }

    public function tambah_pertanyaan($id_survey)
    {
        $daftar_jenis_pertanyaan = DB::table('question_types')->get();
        return view(
            'survey::tambah-pertanyaan',
            [
                'id_survey' => $id_survey,
                'daftar_jenis_pertanyaan' => $daftar_jenis_pertanyaan
            ]
        );
    }

    public function store_pertanyaan(Request $request)
    {
        $rules =
            [
                'id_survey' => 'required',
                'pertanyaan' => 'required|string',
                'question_type' => 'required|string|exists:question_types,question_type_id'
            ];

        $messages = [
            'required' => ':attribute wajib diisi'
        ];
        $validated_pertanyaan = $request->validate($rules, $messages);

        $pertanyaan_survey = new Survey_question_item();
        $pertanyaan_survey->question = $validated_pertanyaan['pertanyaan'];
        $pertanyaan_survey->question_type_id = $validated_pertanyaan['question_type'];
        $pertanyaan_survey->survey_id = $validated_pertanyaan['id_survey'];
        $pertanyaan_survey->is_active = 1;

        if (!empty($request->required)) {
            $pertanyaan_survey->is_required = 1;
        }


        if ($validated_pertanyaan['question_type'] == 3) {
            $condition = "string";
        } else {
            $condition = "required|string";
        }

        $validated_jawaban = $request->validate(
            [
                'jawaban' => $condition,
            ],
            [
                'required' => ':attribute wajib diisi'
            ]
        );

        if ($pertanyaan_survey->save()) {

            if (!empty($validated_jawaban['jawaban'])) {

                $variasi_jawaban = preg_split('/(\r\n|\n|\r)/', $validated_jawaban['jawaban']);

                foreach ($variasi_jawaban as $variasi_jawaban) {
                    $jawaban = new Survey_question_item_variant();
                    $jawaban->survey_question_id = $pertanyaan_survey->survey_question_id;
                    $jawaban->variant = $variasi_jawaban;
                    $jawaban->save();
                }

                return redirect()->to(url('survey/edit' . '/' . $validated_pertanyaan['id_survey']));
            }

            return redirect()->to(url('survey/edit' . '/' . $validated_pertanyaan['id_survey']));
        }
    }

    public function edit_pertanyaan($id_pertanyaan)
    {
        $daftar_jenis_pertanyaan = DB::table('question_types')->get();
        $pertanyaan = Survey_question_item::where('survey_question_id', '=', $id_pertanyaan)->first();
        $survey = DB::table('surveys')->where('id_survey', '=', $pertanyaan->survey_id)->first();

        if ($survey->is_active == 1) {
            return redirect()->back()->withErrors(['type' => 'error', 'message' => 'survey yang sedang berjalan tidak bisa dirubah']);
        }

        $raw_jawaban = Survey_question_item_variant::where('survey_question_id', '=', $pertanyaan->survey_question_id)->get();
        if ($pertanyaan->question_type_id == 1 || $pertanyaan->question_type_id == 2) {
            foreach ($raw_jawaban as $raw) {
                $unmerged_jawaban[] = $raw->variant;
            }
            $jawaban = implode(PHP_EOL, $unmerged_jawaban);
        } else {
            $jawaban = '';
        }

        return view(
            'survey::edit-pertanyaan',
            [
                'daftar_jenis_pertanyaan' => $daftar_jenis_pertanyaan,
                'pertanyaan' => $pertanyaan,
                'jawaban' => $jawaban,
            ]
        );
    }

    public function update_pertanyaan(Request $request, $id_pertanyaan)
    {
        $rules = [
            'pertanyaan' => 'required|string',
            'question_type' => 'required|numeric',
            'jawaban' => 'string'
        ];

        $messages = [
            'required' => ':attribute wajib diisi',
            'string' => 'data yang anda masukkan tidak valid',
            'numeric' => 'data yang anda masukkan tidak valid',
        ];

        $validated = $request->validate($rules, $messages);
        $pertanyaan_survey = Survey_question_item::where('survey_question_id', '=', $id_pertanyaan)->first();
        $pertanyaan_survey->question = $validated['pertanyaan'];
        $pertanyaan_survey->question_type_id = $validated['question_type'];
        if (!empty($request->required)) {
            $pertanyaan_survey->is_required = 1;
        } else {
            $pertanyaan_survey->is_required = 0;
        }

        if ($pertanyaan_survey->save()) {
            if ($validated['question_type'] == 3) {
                $condition = "string";
            } else {
                $condition = "required|string";
            }

            $validated_jawaban = $request->validate(
                [
                    'jawaban' => $condition,
                ]
            );

            if (!empty($validated_jawaban['jawaban'])) {

                DB::table('survey_question_item_variants')->where('survey_question_id', '=', $pertanyaan_survey->survey_question_id)->delete();
                $variasi_jawaban = preg_split('/(\r\n|\n|\r)/', $validated_jawaban['jawaban']);

                foreach ($variasi_jawaban as $variasi_jawaban) {
                    $jawaban = new Survey_question_item_variant();
                    $jawaban->survey_question_id = $pertanyaan_survey->survey_question_id;
                    $jawaban->variant = $variasi_jawaban;
                    $jawaban->save();
                }

                return redirect()->to(url('survey/edit' . '/' . $pertanyaan_survey->survey_id));
            }
            return redirect()->to(url('survey/edit' . '/' . $pertanyaan_survey->survey_id));
        }
    }

    public function destroy_pertanyaan($id_pertanyaan)
    {
        $pertanyaan_survey = DB::table('survey_question_items')->where('survey_question_id', '=', $id_pertanyaan);
        $survey = DB::table('surveys')->where('id_survey', '=', $pertanyaan_survey->first()->survey_id)->first();

        if ($survey->is_active == 1) {
            return redirect()->back()->withErrors(['type' => 'error', 'message' => 'survey yang sedang berjalan tidak bisa dirubah']);
        }

        if ($pertanyaan_survey->delete()) {
            $variant = DB::table('survey_question_item_variants')->where('survey_question_id', '=', $id_pertanyaan);
            if ($variant->delete()) {
                return redirect()->back()->with('success', ['type' => 'success', 'message' => 'pertanyaan berhasil dihapus']);
            }
            return redirect()->back()->with('success', ['type' => 'success', 'message' => 'pertanyaan berhasil dihapus']);
        }
    }

    public function text_survey($id_pertanyaan)
    {
        $text_jawaban_survey = DB::table('survey_answers')->where('survey_question_id', '=', $id_pertanyaan)->get();
        $pertanyaan = DB::table('survey_question_items')->where('survey_question_id', '=', $id_pertanyaan)->first();

        return view(
            'survey::detail_answers_text',
            [
                'jawaban' => $text_jawaban_survey,
                'judul_pertanyaan' => $pertanyaan->question
            ]
        );
    }
}
