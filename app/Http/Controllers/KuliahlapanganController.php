<?php

namespace App\Http\Controllers;

use App\Http\Requests\KuliahLapanganRequest;
use App\Models\JadwalPraktikum;
use App\Models\KuliahLapangan;
use App\Models\Matkul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KuliahlapanganController extends Controller
{
    public function jadwal_kuliah_lapangan()
    {
        $kolom = [
            "Acara",
            "Jadwal",
            "Tempat",
            "Tema",
            call_user_func(function () {
                if (session('user_data')['role'] == 1 /*|| session('user_data')['role'] == 2*/) {
                    return "";
                }
            })
        ];

        $jadwal = [];
        foreach (KuliahLapangan::with('matkul')->get()->toArray() as $matkul) {
            $jadwal[] = [
                $matkul['acara'],
                date("d-m-y H:i", strtotime($matkul['tanggal_start'])) . ' s.d ' . date("d-m-y H:i", strtotime($matkul['tanggal_end'])),
                $matkul['instansi'],
                $matkul['tema'],
                call_user_func(function () use ($matkul) {
                    if (session('user_data')['role'] == 1 /*|| session('user_data')['role'] == 2*/) {
                        return  "<a href=" . url('jadwal-praktikum/edit-jadwal-kuliah-lapangan/' . $matkul['id']) . " class='btn btn-primary'>edit</a>";
                    }
                })
            ];
        }

        // $isi = DB::connection('sqlsrv')
        //     ->table('kuliah_lapangan')
        //     ->select(
        //         "name_of_course",
        //         "tanggal_start",
        //         "tanggal_end"
        //     )
        //     ->leftJoin('V_Course', 'V_Course.course_id', '=', 'kuliah_lapangan.id_praktikum')
        //     ->get()
        //     ->toArray();

        return view('pages/admin/kuliah_lapangan/jadwal_kuliah_lapangan', ['kolom' => $kolom, 'isi' => $jadwal]);
    }

    public function tambah_kuliah_lapangan_view($id_praktikum, $tahunajaran, $semester)
    {
        // dd($praktikum);

        $kuliah_lapangan_exists = KuliahLapangan::where('id_praktikum', '=', $id_praktikum)->exists();
        if ($kuliah_lapangan_exists) {
            return redirect()->to('/jadwal-praktikum')->withErrors(["type" => "danger", "message" => "Jadwal Kuliah Lapangan Sudah Ada"]);
        }

        $praktikum_exists = JadwalPraktikum::where('COURSE_ID', '=', $id_praktikum)->exists();
        if (!$praktikum_exists) {
            return redirect()->to('/jadwal-praktikum')->withErrors(["type" => "danger", "message" => "Praktikum Tidak Ditemukan"]);
        }

        $praktikum = JadwalPraktikum::where([
            ['COURSE_ID', '=', $id_praktikum],
            ['THAJARANID', '=', $tahunajaran],
            ['TERMID', '=', $semester]
        ])->first();

        // dd($praktikum->TERMID);

        return view('pages/dosen/kuliah_lapangan/tambah_kuliah_lapangan', ['praktikum' => $praktikum]);
    }

    public function store_kuliah_lapangan(KuliahLapanganRequest $kuliah_lapangan_request)
    {
        // dd($kuliah_lapangan_request->all());
        $validated_kuliah_lapangan = $kuliah_lapangan_request->validated();

        $is_kuliah_umum_exist = KuliahLapangan::where('id_praktikum', '=', $validated_kuliah_lapangan['id_praktikum'])->exists();

        if ($is_kuliah_umum_exist) {
            return redirect()->to('/jadwal-praktikum')->withErrors(["type" => "danger", "message" => "Jadwal Kuliah Lapangan Sudah Ada"]);
        }

        $kuliah_lapangan = new KuliahLapangan();
        $kuliah_lapangan->acara = $validated_kuliah_lapangan['acara'];
        $kuliah_lapangan->tanggal_start = $validated_kuliah_lapangan['tanggal_mulai'];
        $kuliah_lapangan->tanggal_end = $validated_kuliah_lapangan['tanggal_selesai'];
        $kuliah_lapangan->instansi = $validated_kuliah_lapangan['instansi'];
        $kuliah_lapangan->id_praktikum = $validated_kuliah_lapangan['id_praktikum'];
        $kuliah_lapangan->tahun_ajaran = $validated_kuliah_lapangan['tahun_ajaran'];
        $kuliah_lapangan->semester = $validated_kuliah_lapangan['semester'];
        $kuliah_lapangan->tema = $validated_kuliah_lapangan['tema'];
        $kuliah_lapangan->save();

        return redirect()->to('/jadwal-praktikum')->with('success', ["type" => "success", "message" => "Jadwal Kuliah Lapangan Baru Berhasil Ditambahkan"]);
    }

    public function edit_kuliah_lapangan_view($id_kuliah_lapangan)
    {
        # code...
        $kuliah_lapangan = KuliahLapangan::find($id_kuliah_lapangan)->first();
        $praktikum = Matkul::where('course_id', '=', $kuliah_lapangan->id_praktikum);
        return view('pages/dosen/kuliah_lapangan/edit_kuliah_lapangan', [
            'praktikum' => $praktikum->first(),
            'kuliah_lapangan' => $kuliah_lapangan
        ]);
    }

    public function update_kuliah_lapangan(KuliahLapanganRequest $kuliah_lapangan_request)
    {
        // dd($kuliah_lapangan_request->all());

        $validated_kuliah_lapangan = $kuliah_lapangan_request->validated();
        $kuliah_lapangan = KuliahLapangan::find($kuliah_lapangan_request->id_kuliah_lapangan);
        $kuliah_lapangan->acara = $validated_kuliah_lapangan['acara'];
        $kuliah_lapangan->tanggal_start = $validated_kuliah_lapangan['tanggal_mulai'];
        $kuliah_lapangan->tanggal_end = $validated_kuliah_lapangan['tanggal_selesai'];
        $kuliah_lapangan->instansi = $validated_kuliah_lapangan['instansi'];
        $kuliah_lapangan->id_praktikum = $validated_kuliah_lapangan['id_praktikum'];
        $kuliah_lapangan->tahun_ajaran = $validated_kuliah_lapangan['tahun_ajaran'];
        $kuliah_lapangan->semester = $validated_kuliah_lapangan['semester'];
        $kuliah_lapangan->tema = $validated_kuliah_lapangan['tema'];
        $kuliah_lapangan->save();

        if (session('user_data')['role'] == 1) {
            return redirect()->to('jadwal-kuliah-lapangan')->with('success', ["type" => "success", "message" => "Jadwal Kuliah Lapangan Berhasil Diubah"]);
        }

        return redirect()->to('jadwal-praktikum')->with('success', ["type" => "success", "message" => "Jadwal Kuliah Lapangan Berhasil Diubah"]);
    }
}
