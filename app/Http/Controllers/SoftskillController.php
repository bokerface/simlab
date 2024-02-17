<?php

namespace App\Http\Controllers;

use App\Http\Requests\BuktisoftskillRequest;
use App\Http\Requests\JadwalRequest;
use App\Models\JadwalSoftskill;
use App\Models\Krs;
use App\Models\KurikulumAngkatan;
use App\Models\PresensiSoftskill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class SoftskillController extends Controller
{
    public function jadwal_softskill()
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

        $semester = [1];
        $cur_year = 2022;

        if (session('user_data')['role'] == 1) {
            $data = DB::connection('sqlsrv')
                ->table('jadwal_softskill')
                ->select('id', 'name_of_course', 'tanggal', 'jam_mulai', 'jam_selesai', 'pembicara', 'tempat',)
                ->leftJoin('V_Softskill', 'V_Softskill.course_id', '=', 'jadwal_softskill.id_matkul')
                ->where([
                    ['t_akademik', '=', $cur_year]
                ])
                ->whereIn('jadwal_softskill.semester', $semester)
                ->get()
                ->toArray();

            // dd($data);

            $isi = [];

            foreach ($data as $jadwal) {
                $isi[] = [
                    "<a href=" . url('jadwal-softskill/' . $jadwal->id) . ">" . $jadwal->name_of_course . "</a>",
                    $jadwal->tanggal,
                    $jadwal->jam_mulai,
                    $jadwal->jam_selesai,
                    $jadwal->pembicara,
                    $jadwal->tempat,
                ];
            }

            // dd($isi);

            $kolom = [
                'Softskill',
                'Tanggal',
                'Jam mulai',
                'Jam selesai',
                'Pembicara',
                'Tempat',
            ];

            return view('pages/admin/softskill/jadwal_softskill', [
                'kolom' => $kolom,
                'isi' => $isi,
                'semester_nama' => $semester_nama
            ]);
        } elseif (session('user_data')['role'] == 3) {

            // $kurikulum_angkatan = KurikulumAngkatan::select('course_id')
            //     ->leftJoin('V_Kurikulum_Matakuliah_Softskill', 'V_Kurikulum_Matakuliah_Softskill.implemented_curriculum', '=', 'V_Kurikulum_Angkatan.kurikulum')
            //     ->where('tahun', '=', $cur_year)
            //     ->get();

            // dd($kurikulum_angkatan);

            $jadwal = Krs::select(
                'V_Softskill.name_of_course',
                'V_Softskill.course_id',
                'jadwal_softskill.id as id',
                'jadwal_softskill.tanggal',
                'jadwal_softskill.jam_mulai',
                'jadwal_softskill.jam_selesai',
                'jadwal_softskill.pembicara',
                'V_Student_Course_Krs.thajaranid',
                'V_Student_Course_Krs.termid',
                'screenshot'
            )
                ->leftJoin('V_Softskill', 'V_Softskill.course_id', '=', 'V_Student_Course_Krs.course_id')
                ->leftJoin('jadwal_softskill', 'jadwal_softskill.id_matkul', '=', 'V_Student_Course_Krs.course_id')
                ->leftJoin('presensi_softskill', 'presensi_softskill.STUDENTID', '=', 'V_Student_Course_Krs.STUDENTID')
                ->where(
                    [
                        ['V_Student_Course_Krs.studentid', '=', session('user_data')['user_id']],
                        ['V_Student_Course_Krs.thajaranid', '=', $cur_year],
                        ['jadwal_softskill.t_akademik', '=', $cur_year],
                    ]
                )
                ->whereIn('V_Student_Course_Krs.termid', $semester)
                ->whereIn(
                    'V_Student_Course_Krs.course_id',
                    KurikulumAngkatan::select('course_id')
                        ->leftJoin('V_Kurikulum_Matakuliah_Softskill', 'V_Kurikulum_Matakuliah_Softskill.implemented_curriculum', '=', 'V_Kurikulum_Angkatan.kurikulum')
                        ->where('tahun', '=', $cur_year)
                        ->get()
                )
                ->get()
                ->toArray();

            // dd($jadwal);

            return view(
                'pages/mahasiswa/softskill/jadwal_softskill',
                [
                    'jadwal' => $jadwal,
                    'gangen' => $semester_nama,
                    'tahun_ajaran' => $tahun_ajaran
                ]
            );
        }
    }

    public function detail_jadwal_softskill($id_jadwal_softskill)
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

        $detail = JadwalSoftskill::leftJoin('V_Softskill', 'V_Softskill.course_id', 'jadwal_softskill.id_matkul')
            ->where('id', '=', $id_jadwal_softskill)->first();
        // $detail = JadwalSoftskill::leftJoin('V_Course', 'V_Course.course_id', 'jadwal_softskill.id_matkul')
        //     ->where('id', '=', $id_jadwal_softskill)->first();

        return view('pages/admin/softskill/detail-jadwal-softskill', ['jadwal_softskill' => $detail]);
    }

    function detail_jadwal_softskill_data($id_jadwal_softskill)
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

        $data = JadwalSoftskill::select(
            'V_Mahasiswa.STUDENTID as STUDENTID',
            'V_Mahasiswa.FULLNAME as FULLNAME',
            'jadwal_softskill.t_akademik',
            'jadwal_softskill.semester',
            'jadwal_softskill.id_matkul',
        )
            ->leftJoin('V_Student_Course_Krs', 'V_Student_Course_Krs.COURSE_ID', '=', 'jadwal_softskill.id_matkul')
            ->leftJoin('V_Mahasiswa', 'V_Mahasiswa.STUDENTID', '=', 'V_Student_Course_Krs.studentid')
            ->leftJoin('V_Course', 'V_Course.course_id', '=', 'V_Student_Course_Krs.course_id')
            ->where([
                ['id', '=', $id_jadwal_softskill],
                ['t_akademik', '=', $cur_year],
                ['thajaranid', '=', $cur_year],
            ])
            ->whereIn('semester', $semester)
            ->whereIn('termid', $semester);
        // ->limit(10);

        if (request()->has('search')) {
            $data->where(function ($query) {
                $query->where('V_Mahasiswa.FULLNAME', 'like', "%" . request('search') . "%")
                    ->orWhere('V_Mahasiswa.STUDENTID', 'like', "%" . request('search') . "%");
            });
        }

        return DataTables::of($data)
            ->addColumn('foto_mahasiswa', function ($data) {
                $year = substr($data->STUDENTID, 0, 4);
                $url = "https://krs.umy.ac.id/FotoMhs/$year/$data->STUDENTID.jpg";

                return [
                    'foto' => $url,
                    'nim' => $data->STUDENTID
                ];
            })
            ->addColumn('nim', function ($data) {
                return $data->STUDENTID;
            })
            ->addColumn('nama', function ($data) {
                return $data->FULLNAME;
            })
            ->addColumn('presensi', function ($data) {
                $presensi_softskill = DB::table('presensi_softskill')
                    ->where([
                        ['id_matkul', '=', $data->id_matkul],
                        ['t_akademik', '=', $data->t_akademik],
                        ['semester', '=', $data->semester],
                        ['STUDENTID', '=', $data->STUDENTID],
                    ])
                    ->first();

                $checked = !empty($presensi_softskill->kehadiran) ? "checked" : "";

                if (!empty($presensi_softskill)) {
                    return "<div class='form-group form-check'>
                                <input type='checkbox' class='form-check-input' $checked onchange='cek_kehadiran($presensi_softskill->id)'>
                                <label class='form-check-label' for='exampleCheck1'>Hadir</label>
                            </div>";
                }

                return "mahasiswa belum mengirim foto";
            })
            ->addColumn('screenshot', function ($data) {
                $presensi_softskill = DB::table('presensi_softskill')
                    // ->select('screenshot')
                    ->where([
                        ['id_matkul', '=', $data->id_matkul],
                        ['t_akademik', '=', $data->t_akademik],
                        ['semester', '=', $data->semester],
                        ['STUDENTID', '=', $data->STUDENTID],
                    ])
                    ->first();

                if (!empty($presensi_softskill->screenshot)) {
                    return url('bukti-presensi-softskill/' . $presensi_softskill->screenshot);
                } else {
                    return "https://via.placeholder.com/100x60";
                }
            })
            ->rawColumns(['presensi'])
            // ->filter(function ($query) {
            //     if (request()->has('search')) {
            //         $query->orWhere('V_Mahasiswa.FULLNAME', 'like', "%" . request('search') . "%")
            //             ->orWhere('V_Mahasiswa.STUDENTID', 'like', "%" . request('search') . "%");
            //     }
            // })
            ->make(true);

        // dd($data);
    }

    public function arsip_softskill_data()
    {
        $data = DB::connection('sqlsrv')
            ->table('jadwal_softskill')
            ->select('name_of_course', 't_akademik', 'jadwal_softskill.semester', 'tempat')
            ->leftJoin('V_Softskill', 'V_Softskill.course_id', '=', 'jadwal_softskill.id_matkul')
            ->whereRaw('CONVERT(varchar(10),jadwal_softskill.tanggal,111) < CONVERT(varchar(10),GETDATE(),111)');

        return Datatables::of($data)
            ->make(true);
    }

    public function arsip_softskill_view()
    {
        return view('pages/admin/softskill/arsip_softskill');
    }

    public function softskill_by_kurikulum_data($id_kurikulum)
    {
        $data = DB::table('V_Kurikulum_Matakuliah_Softskill')
            ->select('*')
            ->leftJoin('V_Course', 'V_Course.course_id', '=', 'V_Kurikulum_Matakuliah_Softskill.course_id')
            ->where([
                ['V_Kurikulum_Matakuliah_Softskill.implemented_curriculum', '=', $id_kurikulum],
                // ['V_Kurikulum_Matakuliah_Softskill.department_id', '=', 52],
                // ['V_Kurikulum_Matakuliah_Softskill.faculty_id', '=', 5],
            ])
            // ->orderBy('study_level')
            ->get()
            ->toArray();

        return json_encode($data);
    }

    public function tambah_jadwal_softskill()
    {
        $softskill_option = DB::table('V_Softskill')->get()->toArray();
        return view(
            'pages/admin/softskill/tambah_jadwal',
            [
                'softskill_options' => $softskill_option
            ]
        );
    }

    public function store_jadwal_softskill(JadwalRequest $request)
    {
        $validated = $request->validated();
        // dd($validated);

        $jadwal_softskill = new JadwalSoftskill();
        $jadwal_softskill->id_matkul = $validated['softskill'];
        $jadwal_softskill->semester = $validated['semester'];
        $jadwal_softskill->tanggal = $validated['tanggal'];
        $jadwal_softskill->jam_mulai = $validated['jam_mulai'];
        $jadwal_softskill->jam_selesai = $validated['jam_selesai'];
        $jadwal_softskill->pembicara = $validated['pembicara'];
        $jadwal_softskill->tempat = $validated['tempat'];
        $jadwal_softskill->t_akademik = date("Y");

        if ($jadwal_softskill->save()) {
            return redirect()->to(url('/jadwal-softskill'))->with('success', 'Jadwal Berhasil Ditambahkan');
        }

        return redirect()->back()->withErrors('error', 'Terjadi kesalahan saat memasukkan data');
    }

    public function vue_select_softskills_data($nama_softskill = null)
    {
        $data[] = [];

        if ($nama_softskill != null) {
            $data_softskill = DB::table('V_Softskill')
                ->where('name_of_course', 'like', '%' . $nama_softskill . '%')
                ->get()
                ->toArray();

            foreach ($data_softskill as $softskill) {
                $data = [
                    'label' => $softskill->name_of_course,
                    'code' => $softskill->course_id
                ];
            }
        } else {
            $data_softskill = DB::table('V_Softskill')->limit(15)->get()->toArray();
        }

        return json_encode($data);
    }

    public function upload_bukti_kehadiran(BuktisoftskillRequest $request)
    {
        $presensi_softskill = PresensiSoftskill::where(
            [
                ['STUDENTID', '=', session('user_data')['user_id']],
                ['id_matkul', '=', $request['id_praktikum']],
                ['t_akademik', '=', $request['t_akademik']],
                ['semester', '=', $request['semester']],
                ['id_jadwal', '=', $request['id_jadwal']],
            ]
        )->first();

        // dd($presensi_softskill->id);

        // dd($request['id_jadwal']);

        $foto = date('YmdHis') . '.' . $request['bukti_kegiatan']->getClientOriginalExtension();
        // dd($foto);

        if (empty($presensi_softskill->id)) {
            $presensi_softskill = new PresensiSoftskill();
            $presensi_softskill->STUDENTID = session('user_data')['user_id'];
            $presensi_softskill->id_matkul = $request['id_praktikum'];
            $presensi_softskill->id_jadwal = $request['id_jadwal'];
            $presensi_softskill->t_akademik = $request['t_akademik'];
            $presensi_softskill->semester = $request['semester'];
            $presensi_softskill->screenshot = $foto;
            if ($presensi_softskill->save()) {
                $request['bukti_kegiatan']->storeAs('public/bukti_presensi', $foto);
                return redirect()->back()->with('success', ['type' => 'success', 'message' => 'berhasil mengisi presensi']);
            }
        }

        if (!empty($presensi_softskill->id) && empty($presensi_softskill->kehadiran)) {
            $presensi_softskill->screenshot = $foto;
            if ($presensi_softskill->save()) {
                if (Storage::disk('public')->exists('bukti_presensi/' . $presensi_softskill->screenshot)) {
                    Storage::delete('public/bukti_presensi/' . $presensi_softskill->screenshot);
                }
                $request['bukti_kegiatan']->storeAs('public/bukti_presensi', $foto);
                return redirect()->back()->with('success', ['type' => 'success', 'message' => 'berhasil mengisi presensi']);
            }
        }

        return redirect()->back()->withErrors(['type' => 'error', 'message' => 'Anda sudah mengirimkan absensi']);
    }

    public function verifikasi_kehadiran(Request $request)
    {
        $presensi_softskill = PresensiSoftskill::find($request['id']);
        if (empty($presensi_softskill->kehadiran) || $presensi_softskill->kehadiran == 0) {
            $presensi_softskill->kehadiran = 1;
            $presensi_softskill->save();
        } else {
            $presensi_softskill->kehadiran = null;
            $presensi_softskill->save();
        }
    }
}
