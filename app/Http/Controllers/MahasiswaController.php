<?php

namespace App\Http\Controllers;

use App\Models\CourseMahasiswa;
use App\Models\Krs;
use App\Models\Softskill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class MahasiswaController extends Controller
{
    public function peserta_softskill_data()
    {
        if (date('n') < 6) {
            $cur_year = date("Y") - 1;
            $tahun_ajaran = $cur_year . '/' . date('Y');
        } else {
            $cur_year = date("Y");
            $tahun_ajaran = $cur_year . '/' . (date('Y') + 1);
        }

        if (in_array(date('n'), [8, 9, 10, 11, 12, 1])) {
            $semester = [1, 3, 5];
            $semester_nama = "Ganjil";
        } else {
            $semester = [2, 4, 6];
            $semester_nama = "Genap";
        }

        $data = DB::table('V_Mahasiswa')
            ->leftJoin('V_Student_Course_Krs', 'V_Student_Course_Krs.STUDENTID', '=', 'V_Mahasiswa.STUDENTID')
            ->select(
                'V_Mahasiswa.STUDENTID',
                // 'V_Student_Course_Krs.course_id',
                'V_Mahasiswa.FULLNAME',
            )
            ->where([
                ['thajaranid', '=', $cur_year],
            ])
            ->whereIn('V_Student_Course_Krs.termid', $semester)
            ->whereIn('V_Student_Course_Krs.course_id', ['SOFT001', 'SOFT002', 'SOFT003', 'SOFT004', 'SOFT005', 'SOFT1705', 'SOFT1801'])
            ->distinct();
        // ->where('STUDENTID', '=', 20200520004);
        // ->where('V_Mahasiswa.STUDENTID', '=', 20150520313)
        //     ->limit(20)
        //     ->get()
        //     ->toArray();

        // dd($data);

        return DataTables::of($data)
            ->addColumn('softskill_progress', function ($data) {

                $softskill_krs = Krs::select('course_id')
                    ->where(
                        [
                            ['studentid', '=', $data->STUDENTID]
                        ]
                    )
                    // ->whereIn('course_id', Softskill::select('course_id')->get()->toArray());
                    ->whereIn('course_id', ['SOFT001', 'SOFT002', 'SOFT003', 'SOFT004', 'SOFT005', 'SOFT1705', 'SOFT1801'])
                    ->get()
                    ->toArray();

                $softskill_passed = DB::table('presensi_softskill')
                    ->where('STUDENTID', '=', $data->STUDENTID)
                    ->whereIn('id_matkul', $softskill_krs)
                    ->count();

                $softskill_progress = number_format(($softskill_passed / 6) * 100);
                return $softskill_progress;

                // return $softskill_passed;
            })
            ->addColumn('photo_profile', function ($data) {
                $year = substr($data->STUDENTID, 0, 4);
                $url = "https://krs.umy.ac.id/FotoMhs/$year/$data->STUDENTID.jpg";

                return $url;
            })
            ->addColumn('t_akademik', function ($data) {
                return substr($data->STUDENTID, 0, 4);
            })
            ->make(true);
    }

    public function peserta_softskill_view()
    {
        return view('pages/admin/softskill/peserta_softskill');
    }
}
