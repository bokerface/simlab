<?php

namespace App\Http\Controllers;

use App\Http\Requests\PembayaranRequest;
use App\Http\Requests\SaveProfilDosenRequest;
use App\Libraries\Notification;
use Illuminate\Http\Request;

use App\Models\Dosen;
use App\Models\JadwalPraktikum;
use App\Models\Laporan;
use App\Models\Pembayaran;
use App\Models\Rekening;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DosenController extends Controller
{
    public function daftar_dosen()
    {
        if (request()->is('daftar-dosen')) {
            $title = "Daftar Dosen";
        } elseif (request()->is('pembayaran-dosen')) {
            $title = "Pembayaran Dosen Semester Genap 2021/2022";
        }

        $kolom = [
            'NIK',
            'Nama',
        ];

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

        $semester = 1;

        $daftar_dosen = DB::connection('sqlsrv')
            ->table('V_Course')
            ->select('V_Dosen.id_pegawai', 'V_Dosen.nik', 'V_Dosen.nama')
            ->leftJoin('V_Course_Sched', 'V_Course_Sched.COURSE_ID', '=', 'V_Course.course_id')
            ->leftJoin('V_Dosen', 'V_Dosen.id_pegawai', '=', 'V_Course_Sched.ID_PEGAWAI')
            ->where([
                ['V_Course_Sched.TERMID', '=', $semester],
                ['V_Course_Sched.THAJARANID', '=', date('Y')]
            ])
            ->distinct()
            ->get()
            ->toArray();

        // dd($daftar_dosen);

        $semua_jadwal = JadwalPraktikum::select('ID_PEGAWAI')
            ->where([
                ['THAJARANID', '=', $cur_year],
                ['TERMID', '=', $semester],
                ['DEPARTMENT_ID', '=', 52],
                ['FACULTY_ID', '=', 5]
            ])
            ->distinct()
            ->get()
            ->toArray();

        $dosen_aktif = [];
        if (isset($semua_jadwal)) {
            foreach ($semua_jadwal as $jadwal) {
                if ($jadwal['ID_PEGAWAI']) {
                    $dosen_aktif[] = [
                        'nik' => call_user_func(function () use ($jadwal) {
                            return Dosen::where('id_pegawai', '=', $jadwal['ID_PEGAWAI'])->first()->nik;
                        }),
                        'nama' => call_user_func(function () use ($jadwal) {
                            $nama_dosen = Dosen::where('id_pegawai', '=', $jadwal['ID_PEGAWAI'])->first()->nama;
                            request()->is('daftar-dosen') ? $url = url('/dosen' . '/' . $jadwal['ID_PEGAWAI']) : $url = url('/pembayaran-dosen' . '/' . $jadwal['ID_PEGAWAI']);
                            return "<a href=$url>" . $nama_dosen . "</a>";
                        })
                    ];
                }
            }
        }

        // dd($dosen_aktif);

        // foreach ($daftar_dosen as $daftar_dosen) {
        //     if (isset($daftar_dosen->id_pegawai)) {
        //         dump($daftar_dosen);
        //     }
        // }

        // die();

        // $new_dosen = [];
        // if (isset($daftar_dosen)) {
        //     foreach ($daftar_dosen as $dosen) {
        //         if (isset($dosen->id_pegawai)) {
        //             request()->is('daftar-dosen') ? $url = url('/dosen' . '/' . $dosen->id_pegawai) : $url = url('/pembayaran-dosen' . '/' . $dosen->id_pegawai);
        //             $new_dosen[] = [
        //                 'nik' => $dosen->nik,
        //                 'nama' => "<a href=$url>" . $dosen->nama . "</a>",
        //             ];
        //         }
        //     }
        // }

        return view('pages/admin/dosen/daftar_dosen', ['kolom' => $kolom, 'isi' => $dosen_aktif, 'title' => $title]);
    }

    public function detail_dosen($id_dosen = null)
    {
        $data = Dosen::with('rekening')->find($id_dosen)->toArray();

        return view('pages/admin/dosen/detail_dosen', ['data' => $data]);
    }

    public function save_profil_dosen(SaveProfilDosenRequest $request)
    {
        $validated = $request->validated();
        // dd($validated);

        // dd($request->all());
        $rekening_dosen = Rekening::find($validated['id_pegawai']);

        // dd($rekening_dosen);

        // dd($rekening_dosen);
        if (!$rekening_dosen) {
            $rekening_dosen = new Rekening();
            $rekening_dosen->id_pegawai = $validated['id_pegawai'];
            $rekening_dosen->no_rek = $validated['rekening'];
            $rekening_dosen->bank = $validated['bank'];
            $rekening_dosen->cabang = $validated['cabang'];
            $rekening_dosen->nama_rekening = $validated['pemegang_rekening'];
            $rekening_dosen->telepon = $validated['no_telp'];
            $rekening_dosen->whatsapp = $validated['no_wa'];
            $rekening_dosen->save();

            return redirect()->back();
        } else {
            $rekening_dosen->no_rek = $validated['rekening'];
            $rekening_dosen->bank = $validated['bank'];
            $rekening_dosen->cabang = $validated['cabang'];
            $rekening_dosen->nama_rekening = $validated['pemegang_rekening'];
            $rekening_dosen->cabang = $validated['cabang'];
            $rekening_dosen->telepon = $validated['no_telp'];
            $rekening_dosen->whatsapp = $validated['no_wa'];
            $rekening_dosen->save();

            return redirect()->back();
        }
    }

    public function pembayaran_dosen($id_dosen)
    {
        $rekening_dosen = Dosen::with('rekening')->find($id_dosen)->toArray();

        // if (in_array(date('n'), [8, 9, 10, 11, 12])) {

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

        $semester = 1;

        $daftar_praktikum = DB::connection('sqlsrv')
            ->table('V_Course_Sched')
            ->select('V_Course_Sched.COURSE_ID', 'V_Course.name_of_course', 'V_Course_Sched.THAJARANID', 'V_Course_Sched.TERMID')
            ->leftJoin('V_Course', 'V_Course.course_id', '=', 'V_Course_Sched.COURSE_ID')
            ->where([
                ['V_Course_Sched.ID_PEGAWAI', '=', $id_dosen],
                ['V_Course_Sched.TERMID', '=', $semester],
                ['V_Course_Sched.THAJARANID', '=', $cur_year]
            ])
            ->distinct()
            ->get()
            ->toArray();

        // dd($daftar_praktikum);

        $new_praktikum = [];
        foreach ($daftar_praktikum as $praktikum) {
            if (isset($praktikum->name_of_course)) {
                $new_praktikum[] = [
                    'nama_praktikum' => $praktikum->name_of_course,
                    'id_praktikum' => $praktikum->COURSE_ID,
                    'tahun_ajaran' => $praktikum->THAJARANID,
                    'semester' => $praktikum->TERMID,
                    'laporan' => call_user_func(function () use ($praktikum, $id_dosen) {
                        return Laporan::where([
                            ['id_dosen', '=', $id_dosen],
                            ['id_praktikum', '=', $praktikum->COURSE_ID],
                            ['tahun', '=', $praktikum->THAJARANID],
                            ['semester', '=', $praktikum->TERMID]
                        ])->first();
                    }),
                ];
            }
        }

        // dd($new_praktikum);

        $data_laporan = Laporan::where('id_dosen', '=', $id_dosen)->first();

        // dd($data_laporan->laporan_praktikum);

        return view('pages/admin/dosen/pembayaran_dosen', [
            'data' => $rekening_dosen,
            'praktikum' => $new_praktikum,
            'laporan' => $data_laporan
        ]);
    }

    public function store_pembayaran(PembayaranRequest $request)
    {

        $validated = $request->validated();
        $image = $validated['file_bukti'];
        $imageName = date('YmdHis') . "." . $image->getClientOriginalExtension();

        $pembayaran = new Pembayaran();
        $pembayaran->tanggal = $validated['tanggal'];
        $pembayaran->file_bukti = $imageName;
        $pembayaran->nominal = $validated['nominal'];
        $pembayaran->id_dosen = $validated['id_pegawai'];
        $pembayaran->id_praktikum = $validated['id_praktikum'];
        $pembayaran->jenis = $validated['type'];
        $pembayaran->metode = $validated['metode'];
        $pembayaran->id_tahun = $validated['tahun_ajaran'];
        $pembayaran->semester = $validated['semester'];
        // $pembayaran->save();

        $data_pembayaran = DB::connection('sqlsrv')
            ->table('pembayaran')
            ->select('*')
            ->where([
                ['id_dosen', '=', $validated['id_pegawai']],
                ['id_praktikum', '=', $validated['id_praktikum']],
                ['id_tahun', '=', $validated['tahun_ajaran']],
                ['jenis', '=', $validated['type']],
                ['semester', '=', $validated['semester']],
            ])
            ->first();

        if (!$data_pembayaran) {
            if ($pembayaran->save()) {
                // $image->move(public_path('bukti_pembayaran'), $imageName);
                $image->storeAs('/public/bukti_pembayaran', $imageName);
                return redirect()->back()->with('success', ['type' => 'success', 'message' => 'Laporan Pembayaran Berhasil']);
            }
            // return redirect()->back()->withErrors(["type" => "danger", "message" => "gagal menyimpan data pembayaran"]);
        }
        return redirect()->back()->withErrors(["type" => "danger", "message" => "gagal menyimpan data pembayaran"]);

        // dd($pembayaran->save());
    }
}
