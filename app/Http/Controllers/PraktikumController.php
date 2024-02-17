<?php

namespace App\Http\Controllers;

use App\Http\Requests\KuliahUmumRequest;
use App\Http\Requests\ModeratorRequest;
use App\Http\Requests\PembicaraRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

use App\Models\DaftarMatkul;
use App\Models\JadwalPraktikum;
use App\Models\Krs;
use App\Models\KuliahLapangan;
use App\Models\KuliahUmum;
use App\Models\Laporan;
use App\Models\Matkul;
use App\Models\Pembayaran;
use App\Models\Pembicara;
use Yajra\DataTables\Facades\DataTables;

class PraktikumController extends Controller
{
    public function jadwal_praktikum()
    {
        // $cur_year = date("Y");

        if (date('n') < 6) {
            $cur_year = date("Y") - 1;
        } else {
            $cur_year = date("Y");
        }

        if (in_array(date('n'), [8, 9, 10, 11, 12, 1])) {
            $semester = 1;
            $semester_nama = "Ganjil";
        } else {
            $semester = 2;
            $semester_nama = "Genap";
        }

        $cur_year = 2021;
        $semester = 1;

        // $semester = "libur";

        if (session('user_data')['role'] == 1) {
            $jadwal = DB::connection('sqlsrv')
                ->table('V_Course_Sched')
                ->select(
                    'V_Course.name_of_course as praktikum',
                    'V_Course.course_id as id_praktikum',
                    'V_Course_Sched.TERMID',
                    'V_Course_Sched.THAJARANID',
                    'V_Course_Sched.COURSE_ID',
                    // 'V_Course.name_of_course',
                    // DB::raw("FORMAT(JAM_AWAL,'hh:mm') as jam_mulai"),
                    // DB::raw("FORMAT(JAM_AKHIR,'hh:mm') as jam_selesai"),
                    // 'RUANGAN_ID',
                )
                ->leftJoin('V_Course', 'V_Course.course_id', '=', 'V_Course_Sched.COURSE_ID')
                ->where([
                    ['TERMID', '=', $semester],
                    ['THAJARANID', '=', $cur_year],
                    ['V_Course_Sched.DEPARTMENT_ID', '=', 52],
                    ['V_Course_Sched.FACULTY_ID', '=', 5]
                ])
                ->distinct()
                ->get()
                ->toArray();

            $isi = [];

            foreach ($jadwal as $jadwal) {
                $isi[] = [
                    'praktikum' => $jadwal->praktikum,
                    'id_praktikum' => $jadwal->id_praktikum,
                    'jadwal' => call_user_func(function () use ($jadwal) {
                        $data = JadwalPraktikum::select(
                            'INDEX_CLASS_ID',
                            // 'SESSI_ID',
                            'HARI_ID',
                            DB::raw("FORMAT(JAM_AWAL,'hh:mm') as jam_mulai"),
                            DB::raw("FORMAT(JAM_AKHIR,'hh:mm') as jam_selesai"),
                            'RUANGAN_ID'
                        )
                            ->where([
                                ['COURSE_ID', '=', $jadwal->id_praktikum],
                                ['THAJARANID', '=', $jadwal->THAJARANID],
                                ['TERMID', '=', $jadwal->TERMID],
                                ['DEPARTMENT_ID', '=', 52],
                                ['FACULTY_ID', '=', 5]
                            ])
                            ->orderBy('HARI_ID')
                            ->distinct()
                            ->get()
                            ->toArray();

                        $hari = [
                            1 =>
                            'Minggu',
                            'Senin',
                            'Selasa',
                            'Rabu',
                            'Kamis',
                            'Jumat',
                            'Sabtu',
                        ];

                        $jadwal_praktikum = [];
                        if ($data) {
                            foreach ($data as $jadwal) {
                                $jadwal_praktikum[] = [

                                    "<h6><b>Kelas : " . $jadwal['INDEX_CLASS_ID'] . "</b></h6>" .
                                        "<ul>" .
                                        "<li>Hari : " . $hari[$jadwal['HARI_ID']] . "</li>" .
                                        // "<li>Sesi : " . $jadwal['SESSI_ID'] . "</li>" .
                                        "<li>Jam : " . $jadwal['jam_mulai'] . " - " . $jadwal['jam_selesai'] . "</li>" .
                                        "<li>Ruang : " . $jadwal['RUANGAN_ID'] . "</li>" .
                                        "</ul>"
                                ];
                            }
                        }

                        return $jadwal_praktikum;
                    })
                ];
            }

            // dd($isi);

            $kolom = [
                'Nama Praktikum',
                'Jadwal',
                // 'Jam mulai',
                // 'Jam selesai',
                // 'Tempat',
            ];

            return view('pages/admin/praktikum/jadwal_praktikum', [
                'kolom' => $kolom,
                'isi' => $isi,
                'semester_nama' => $semester_nama
            ]);
        } elseif (session('user_data')['role'] == 2) {
            $data = DB::table('V_Course')
                ->select('name_of_course', 'THAJARANID', 'TERMID', 'ID_PEGAWAI', 'V_Course.course_id')
                ->LeftJoin('V_Course_Sched', 'V_Course_Sched.COURSE_ID', '=', 'V_Course.course_id')
                ->where([
                    ['V_Course_Sched.id_pegawai', '=', session('user_data')['user_id']],
                    // ['V_Course_Sched.ID_PEGAWAI', '=', 1619],
                    ['V_Course_Sched.THAJARANID', '=', $cur_year],
                    ['V_Course_Sched.TERMID', '=', $semester]
                ])
                ->distinct()
                ->get()
                ->toArray();

            // dd($data);

            $detailpraktikum = [];
            if ($data) {
                foreach ($data as $praktikum) {
                    $hari = [
                        1 =>
                        'Senin',
                        'Selasa',
                        'Rabu',
                        'Kamis',
                        'Jumat',
                        'Sabtu',
                        'Minggu',
                    ];
                    $detailpraktikum[] = [
                        'nama_praktikum' => $praktikum->name_of_course,
                        'tahun_ajaran' => $praktikum->THAJARANID,
                        'semester' => $praktikum->TERMID,
                        'id_praktikum' => $praktikum->course_id,
                        'jadwal_kuliah_umum' => call_user_func(
                            function () use ($praktikum, $semester, $cur_year) {
                                return DB::table('kuliah_umum')
                                    ->where([
                                        ['id_praktikum', '=', $praktikum->course_id],
                                        ['tahun_ajaran', '=', $cur_year],
                                        ['semester', '=', $semester]
                                    ])
                                    ->get()
                                    ->toArray();
                            }
                        ),
                        'jadwal_praktikum' => call_user_func(
                            function () use ($praktikum, $hari, $semester, $cur_year) {
                                $data = DB::table('V_Course_Sched')
                                    ->select(
                                        'name_of_course',
                                        'TERMID',
                                        'HARI_ID',
                                        DB::raw("FORMAT(JAM_AWAL,'HH:mm') as jam_mulai"),
                                        DB::raw("FORMAT(JAM_AKHIR,'HH:mm') as jam_selesai"),
                                        'INDEX_CLASS_ID',
                                        // 'SESSI_ID',
                                        'RUANGAN_ID'
                                    )
                                    ->leftJoin('V_Course', 'V_Course.course_id', '=', 'V_Course_Sched.COURSE_ID')
                                    ->where([
                                        ['V_Course_Sched.COURSE_ID', '=', $praktikum->course_id],
                                        ['V_Course_Sched.THAJARANID', '=', $cur_year],
                                        ['V_Course_Sched.TERMID', '=', $semester]
                                    ])
                                    ->distinct()
                                    ->get()
                                    ->toArray();

                                foreach ($data as $jadwal) {
                                    $praktikum_jadwal[] = [
                                        'nama_praktikum' => $jadwal->name_of_course,
                                        'semester' => $jadwal->TERMID,
                                        'hari' => $hari[$jadwal->HARI_ID],
                                        'jam_mulai' => $jadwal->jam_mulai,
                                        'jam_selesai' => $jadwal->jam_selesai,
                                        // 'sessi' => $jadwal->SESSI_ID,
                                        'kelas' => $jadwal->INDEX_CLASS_ID,
                                        'ruang' => $jadwal->RUANGAN_ID
                                    ];
                                }
                                return $praktikum_jadwal;
                            }
                        ),
                        'jadwal_kuliah_lapangan' => call_user_func(function () use ($praktikum, $semester, $cur_year) {
                            return DB::table('kuliah_lapangan')
                                ->where([
                                    ['id_praktikum', '=', $praktikum->course_id],
                                    ['tahun_ajaran', '=', $cur_year],
                                    ['semester', '=', $semester]
                                ])
                                ->get()
                                ->toArray();
                        }),
                        'laporan' => call_user_func(function () use ($praktikum) {
                            return Laporan::where([
                                ['id_dosen', '=', session('user_data')['user_id']],
                                ['id_praktikum', '=', $praktikum->course_id],
                            ])->first();
                        }),
                        'pembayaran' => call_user_func(function () use ($praktikum) {
                            return Pembayaran::where([
                                ['id_dosen', '=', session('user_data')['user_id']],
                                ['id_praktikum', '=', $praktikum->course_id]
                            ])
                                ->get()
                                ->toArray();
                        })
                    ];
                }
            }

            // dd($detailpraktikum);

            return view('pages/dosen/praktikum/jadwal_praktikum', [
                'data' => $detailpraktikum,
                'semester_nama' => $semester_nama
            ]);
        } elseif (session('user_data')['role'] == 3) {

            $jadwal = DB::table('V_Student_Course_Krs')
                ->select(
                    'V_Student_Course_Krs.course_id as id_praktikum',
                    'V_Course.name_of_course as praktikum',
                    'V_Student_Course_Krs.thajaranid',
                    'V_Student_Course_Krs.termid',
                )->leftJoin('V_Course', 'V_Course.course_id', '=', 'V_Student_Course_Krs.course_id')
                ->where(
                    [
                        ['V_Student_Course_Krs.studentid', '=', session('user_data')['user_id']],
                        ['V_Student_Course_Krs.thajaranid', '=', $cur_year]
                    ]
                )
                ->whereNotIn('V_Student_Course_Krs.course_id', [
                    'SPB002',
                    'SPB004',
                    'UMY701',
                    'UMY702',
                    'MKJW40',
                    'MKJW39',
                ])
                ->whereNotIn('V_Course.course_type_id', [1, 6])
                ->get()
                ->toArray();

            // dd($jadwal);

            $isi = [];

            foreach ($jadwal as $jadwal) {
                $isi[] = [
                    'praktikum' => $jadwal->praktikum,
                    'semester' => $jadwal->termid,
                    'course_id' => $jadwal->id_praktikum,
                    'jadwal' => call_user_func(function () use ($jadwal) {
                        $data = JadwalPraktikum::select(
                            'INDEX_CLASS_ID',
                            // 'SESSI_ID',
                            'HARI_ID',
                            DB::raw("FORMAT(JAM_AWAL,'hh:mm') as jam_mulai"),
                            DB::raw("FORMAT(JAM_AKHIR,'hh:mm') as jam_selesai"),
                            'RUANGAN_ID'
                        )
                            ->where([
                                ['COURSE_ID', '=', $jadwal->id_praktikum],
                                ['THAJARANID', '=', $jadwal->thajaranid],
                                ['TERMID', '=', $jadwal->termid],
                                ['DEPARTMENT_ID', '=', 52],
                                ['FACULTY_ID', '=', 5]
                            ])
                            ->distinct()
                            ->orderBy('INDEX_CLASS_ID')
                            ->get()
                            ->toArray();

                        $hari = [
                            1 =>
                            'Minggu',
                            'Senin',
                            'Selasa',
                            'Rabu',
                            'Kamis',
                            'Jumat',
                            'Sabtu',
                        ];

                        $jadwal_praktikum = [];

                        if ($data) {
                            foreach ($data as $jadwal) {
                                $jadwal_praktikum[] = [
                                    'kelas' => $jadwal['INDEX_CLASS_ID'],
                                    'hari' => $hari[$jadwal['HARI_ID']],
                                    'jam_mulai' => $jadwal['jam_mulai'],
                                    'jam_selesai' => $jadwal['jam_selesai'],
                                    'ruang' => $jadwal['RUANGAN_ID'],
                                    // 'sesi' => $jadwal['SESSI_ID']
                                ];
                            }
                        }

                        return $jadwal_praktikum;
                    })
                ];
            }

            // dd($isi);

            return view('pages/mahasiswa/praktikum/jadwal_praktikum', [
                'jadwal' => $isi,
                'semester_nama' => $semester_nama
            ]);
        }
    }

    public function semua_praktikum()
    {
        $kolom = [
            'Praktikum',
            'Kode',
            'Semester',
            'Tahun Akademik'
        ];

        // $daftar_matkul = DaftarMatkul::all('nama_matkul', 'kode', 'semester')->toArray();
        $data = Matkul::select('name_of_course', 'V_Course.course_id', 'TERMID', 'THAJARANID')
            ->leftJoin('V_Course_Sched', 'V_Course_Sched.COURSE_ID', '=', 'V_Course.course_id')
            ->where([
                ['THAJARANID', '=', date('Y')]
            ])
            ->distinct()
            ->get()
            ->toArray();
        $daftar_matkul = [];
        foreach ($data as $matkul) {
            if ($matkul['THAJARANID']) {
                $daftar_matkul[] = [
                    $matkul['name_of_course'],
                    $matkul['course_id'],
                    $matkul['TERMID'],
                    $matkul['THAJARANID'],
                ];
            }
        }
        // dd($data);
        return view('pages/admin/praktikum/semua_praktikum', ['kolom' => $kolom, 'isi' => $daftar_matkul]);
    }

    public function praktikum_by_kurikulum_data($id_kurikulum)
    {
        $data = DB::connection('sqlsrv')
            ->table('V_Kurikulum_Matakuliah')
            ->select('*')
            ->leftJoin('V_Course', 'V_Course.course_id', '=', 'V_Kurikulum_Matakuliah.course_id')
            ->where('V_Kurikulum_Matakuliah.implemented_curriculum', '=', $id_kurikulum)
            // ->orderBy('study_level')
            ->get()
            ->toArray();

        return json_encode($data);
    }

    public function arsip_praktikum_view()
    {
        return view('pages/admin/praktikum/arsip_praktikum');
    }

    public function arsip_praktikum_data()
    {
        $data = DB::table('V_Course_Sched')
            ->select('V_Course.name_of_course', 'THAJARANID', 'TERMID')
            // ->select('*')
            ->rightJoin('V_Course', 'V_Course.course_id', '=', 'V_Course_Sched.course_id')
            ->distinct()
            // ->limit(20)
            ->where([
                ['V_Course_Sched.THAJARANID', '<', date("Y")],
                ['V_Course_Sched.DEPARTMENT_ID', '=', 52]
            ]);

        return Datatables::of($data)->make(true);
    }
}
