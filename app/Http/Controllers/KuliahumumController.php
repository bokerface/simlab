<?php

namespace App\Http\Controllers;

use App\Http\Requests\KuliahUmumRequest;
use App\Http\Requests\ModeratorRequest;
use App\Http\Requests\PembicaraRequest;
use App\Models\JadwalPraktikum;
use App\Models\KuliahUmum;
use App\Models\Matkul;
use App\Models\Pembicara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class KuliahumumController extends Controller
{
    public function jadwal_kuliah_umum()
    {
        $kolom = [
            "Nama Praktikum",
            "Tanggal",
            "Jam",
            "Pembicara",
            "Tempat",
            call_user_func(function () {
                if (session('user_data')['role'] == 1 /*|| session('user_data')['role'] == 2*/) {
                    return "";
                }
            })
        ];

        $jadwal = [];
        foreach (KuliahUmum::with('matkul')->get()->toArray() as $matkul) {
            $jadwal[] = [
                $matkul['matkul']['name_of_course'],
                $matkul['tanggal'],
                date("H:i", strtotime($matkul['jam_mulai'])) . '-' . date("H:i", strtotime($matkul['jam_selesai'])),
                // $matkul['pembicara'],
                // '',
                call_user_func(function () use ($matkul) {
                    $daftar_pembicara = Pembicara::where([
                        ['id_kuliah_umum', '=', $matkul['id']],
                        ['tipe', '=', 'p']
                    ])
                        ->get()
                        ->toArray();
                    foreach ($daftar_pembicara as $pembicara) {
                        $new_pembicara[] = "-" . $pembicara['nama'] . "<br>";
                    }
                    return implode(" ", $new_pembicara);
                }),
                $matkul['tempat'],
                call_user_func(function () use ($matkul) {
                    if (session('user_data')['role'] == 1 /*|| session('user_data')['role'] == 2*/) {
                        return  "<a href=" . url('jadwal-praktikum/edit-kuliah-umum/' . $matkul['id']) . " class='btn btn-primary'>edit</a>";
                    }
                })
            ];
        }

        // dd($jadwal);

        // $isi = DB::connection('sqlsrv')
        //     ->table('kuliah_umum')
        //     ->select('*')
        //     ->leftJoin('V_Course', 'V_Course.course_id', '=', 'kuliah_umum.id_praktikum')
        //     ->leftJoin('V_Kurikulum_Matakuliah', 'V_Kurikulum_Matakuliah.course_id', '=', 'V_Course.course_id')
        //     ->get()
        //     ->toArray();

        return view('pages/admin/kuliah_lapangan/jadwal_kuliah_lapangan', ['kolom' => $kolom, 'isi' => $jadwal]);
    }

    public function tambah_kuliah_umum_view($id_praktikum, $tahunajaran, $semester)
    {
        $is_praktikum_exists = JadwalPraktikum::where('COURSE_ID', '=', $id_praktikum);
        if (!$is_praktikum_exists->exists()) {
            return redirect()->to(url('jadwal-praktikum'))->withErrors(["type" => "danger", "message" => "praktikum tidak ditemukan"]);
        }

        $praktikum = JadwalPraktikum::where([
            ['COURSE_ID', '=', $is_praktikum_exists->first()->COURSE_ID],
            ['THAJARANID', '=', $tahunajaran],
            ['TERMID', '=', $semester]
        ])->first();

        // dd($praktikum);

        return view('pages/dosen/kuliah_umum/tambah_kuliah_umum', ['praktikum' => $praktikum]);
    }

    public function tambah_kuliah_umum_store(Request $request, KuliahUmumRequest $kuliah_umum_request, ModeratorRequest $mod_request, PembicaraRequest $pem_request)
    {
        $validated_kuliah_umum = $kuliah_umum_request->validated();
        $validated_moderator = $mod_request->validated();
        $validated_pembicara = $pem_request->validated();

        $kuliah_umum = new KuliahUmum();
        $kuliah_umum->tanggal = $validated_kuliah_umum['tanggal'];
        $kuliah_umum->jam_mulai = $validated_kuliah_umum['jam_mulai'];
        $kuliah_umum->jam_selesai = $validated_kuliah_umum['jam_selesai'];
        $kuliah_umum->tema = $validated_kuliah_umum['tema'];
        $kuliah_umum->id_praktikum = $validated_kuliah_umum['id_praktikum'];
        $kuliah_umum->tahun_ajaran = $validated_kuliah_umum['tahun_ajaran'];
        $kuliah_umum->semester = $validated_kuliah_umum['semester'];
        $kuliah_umum->tempat = $validated_kuliah_umum['tempat'];

        $is_kuliah_umum_exists = KuliahUmum::where('id_praktikum', '=', $validated_kuliah_umum['id_praktikum'])->exists();
        if (!$is_kuliah_umum_exists) {
            if ($kuliah_umum->save()) {

                $foto_moderator = date('YmdHis') . '.' . $validated_moderator['foto_moderator']->getClientOriginalExtension();
                $moderator = new Pembicara();
                $moderator->nama = $validated_moderator['nama_moderator'];
                $moderator->foto = $foto_moderator;
                $moderator->tipe = "m";
                $moderator->id_kuliah_umum = $kuliah_umum->id;
                $moderator->save();
                $validated_moderator['foto_moderator']->storeAs('/public/foto_moderator', $foto_moderator);

                $foto_pembicara_1 = date('YmdHis') . '.' . $validated_pembicara['foto_pembicara_1']->getClientOriginalExtension();
                $pembicara_1 = new Pembicara();
                $pembicara_1->nama = $validated_pembicara['nama_pembicara_1'];
                $pembicara_1->jabatan = $validated_pembicara['jabatan_pembicara_1'];
                $pembicara_1->instansi = $validated_pembicara['instansi_pembicara_1'];
                $pembicara_1->tipe = "p";
                $pembicara_1->id_kuliah_umum = $kuliah_umum->id;
                $pembicara_1->foto = $foto_pembicara_1;
                $pembicara_1->save();
                $validated_pembicara['foto_pembicara_1']->storeAs('/public/foto_pembicara', $foto_pembicara_1);

                if ($validated_pembicara['nama_pembicara_2'] != null) {
                    $foto_pembicara_2 = date('YmdHis') . '.' . $validated_pembicara['foto_pembicara_2']->getClientOriginalExtension();
                    $pembicara_2 = new Pembicara();
                    $pembicara_2->nama = $validated_pembicara['nama_pembicara_2'];
                    $pembicara_2->jabatan = $validated_pembicara['jabatan_pembicara_2'];
                    $pembicara_2->instansi = $validated_pembicara['instansi_pembicara_2'];
                    $pembicara_2->tipe = "p";
                    $pembicara_2->id_kuliah_umum = $kuliah_umum->id;
                    $pembicara_2->foto = $foto_pembicara_2;
                    $pembicara_2->save();
                    $validated_pembicara['foto_pembicara_2']->storeAs('/public/foto_pembicara', $foto_pembicara_2);
                }

                if ($validated_pembicara['nama_pembicara_3'] != null) {
                    $foto_pembicara_3 = date('YmdHis') . '.' . $validated_pembicara['foto_pembicara_3']->getClientOriginalExtension();
                    $pembicara_3 = new Pembicara();
                    $pembicara_3->nama = $validated_pembicara['nama_pembicara_3'];
                    $pembicara_3->jabatan = $validated_pembicara['jabatan_pembicara_3'];
                    $pembicara_3->instansi = $validated_pembicara['instansi_pembicara_3'];
                    $pembicara_3->tipe = "p";
                    $pembicara_3->id_kuliah_umum = $kuliah_umum->id;
                    $pembicara_3->foto = $foto_pembicara_3;
                    $pembicara_3->save();
                    $validated_pembicara['foto_pembicara_3']->storeAs('/public/foto_pembicara', $foto_pembicara_3);
                }

                return redirect()->to(url('/jadwal-praktikum'))->with(['type' => 'success', 'message' => 'kuliah umum berhasil ditambahkan']);
            }
        }

        return redirect()->back()->withErrors(['type' => 'danger', 'message' => 'kuliah umum sudah ada']);
    }

    public function edit_kuliah_umum_view($id_kuliah_umum)
    {
        $kuliah_umum = KuliahUmum::where('id', '=', $id_kuliah_umum);
        // dd($kuliah_umum->get()->toArray());

        $is_praktikum_exists = JadwalPraktikum::where('COURSE_ID', '=', $kuliah_umum->first()->id_praktikum);
        if (!$is_praktikum_exists->exists()) {
            return redirect()->to(url('jadwal-praktikum'))->withErrors(["type" => "danger", "message" => "praktikum tidak ditemukan"]);
        }

        $praktikum = Matkul::where('course_id', '=', $is_praktikum_exists->first()->COURSE_ID)->first();

        $detail_kuliah_umum = [
            'kuliah_umum' => $kuliah_umum->get()->toArray(),
            'moderator' => call_user_func(function () use ($id_kuliah_umum) {
                return DB::table('t_pembicara')
                    ->where([
                        ['id_kuliah_umum', '=', $id_kuliah_umum],
                        ['tipe', '=', 'm']
                    ])
                    ->orderBy('id')
                    ->get()
                    ->toArray();
            }),
            'pembicara' => call_user_func(function () use ($id_kuliah_umum) {
                $pembicara = DB::table('t_pembicara')
                    ->where([
                        ['id_kuliah_umum', '=', $id_kuliah_umum],
                        ['tipe', '=', 'p']
                    ])
                    ->orderBy('id')
                    ->get()
                    ->toArray();

                array_unshift($pembicara, "");
                unset($pembicara[0]);
                return $pembicara;
            })
        ];

        // dd($detail_kuliah_umum);
        return view('pages/dosen/kuliah_umum/edit_kuliah_umum', ['praktikum' => $praktikum, 'data' => $detail_kuliah_umum]);
    }

    public function update_kuliah_umum(Request $request, KuliahUmumRequest $kuliah_request, ModeratorRequest $mod_request, PembicaraRequest $pem_request)
    {
        // dd($request->all());
        $validated_kuliah_umum = $kuliah_request->validated();
        $validated_moderator = $mod_request->validated();
        $validated_pembicara = $pem_request->validated();

        $kuliah_umum = KuliahUmum::find($request->id_kuliah_umum);
        $kuliah_umum->tempat = $validated_kuliah_umum['tempat'];
        $kuliah_umum->tanggal = $validated_kuliah_umum['tanggal'];
        $kuliah_umum->jam_mulai = $validated_kuliah_umum['jam_mulai'];
        $kuliah_umum->jam_selesai = $validated_kuliah_umum['jam_selesai'];
        $kuliah_umum->tema = $validated_kuliah_umum['tema'];
        $kuliah_umum->tahun_ajaran = $validated_kuliah_umum['tahun_ajaran'];
        $kuliah_umum->semester = $validated_kuliah_umum['semester'];

        if ($kuliah_umum->save()) {

            $mod = Pembicara::find($request->id_moderator);
            $mod->nama = $validated_moderator['nama_moderator'];
            if (isset($validated_moderator['foto_moderator'])) {
                if ($validated_moderator['foto_moderator'] != '' || $validated_moderator['foto_moderator'] != $mod->foto) {
                    if (Storage::disk('public')->exists('foto_moderator/' . $mod->foto)) {
                        Storage::delete('public/foto_moderator/' . $mod->foto);
                    }
                    $foto_moderator = date('YmdHis') . '.' . $validated_moderator['foto_moderator']->getClientOriginalExtension();
                    $mod->foto = $foto_moderator;
                    $validated_moderator['foto_moderator']->storeAs('/public/foto_moderator', $foto_moderator);
                }
            }
            $mod->save();

            $pembicara_1 = Pembicara::find($request->id_pembicara_1);
            $pembicara_1->nama = $validated_pembicara['nama_pembicara_1'];
            $pembicara_1->jabatan = $validated_pembicara['jabatan_pembicara_1'];
            $pembicara_1->instansi = $validated_pembicara['instansi_pembicara_1'];
            if (isset($validated_pembicara['foto_pembicara_1'])) {
                if ($validated_pembicara['foto_pembicara_1'] != '' || $validated_pembicara['foto_pembicara_1'] != $pembicara_1->foto) {
                    if (Storage::disk('public')->exists('foto_pembicara/' . $pembicara_1->foto)) {
                        Storage::delete('public/foto_pembicara/' . $pembicara_1->foto);
                    }
                    $foto_pembicara_1 = date('YmdHis') . '.' . $validated_pembicara['foto_pembicara_1']->getClientOriginalExtension();
                    $pembicara_1->foto = $foto_pembicara_1;
                    $validated_pembicara['foto_pembicara_1']->storeAs('/public/foto_pembicara', $foto_pembicara_1);
                }
            }
            $pembicara_1->save();

            if (isset($request->id_pembicara_2)) {
                $pembicara_2 = Pembicara::find($request->id_pembicara_2);
                $pembicara_2->nama = $validated_pembicara['nama_pembicara_2'];
                $pembicara_2->jabatan = $validated_pembicara['jabatan_pembicara_2'];
                $pembicara_2->instansi = $validated_pembicara['instansi_pembicara_2'];
                if (isset($validated_pembicara['foto_pembicara_2'])) {
                    if ($validated_pembicara['foto_pembicara_2'] != '' || $validated_pembicara['foto_pembicara_2'] != $pembicara_2->foto) {
                        if (Storage::disk('public')->exists('foto_pembicara/' . $pembicara_2->foto)) {
                            Storage::delete('public/foto_pembicara/' . $pembicara_2->foto);
                        }
                        $foto_pembicara_2 = date('YmdHis') . '.' . $validated_pembicara['foto_pembicara_2']->getClientOriginalExtension();
                        $pembicara_2->foto = $foto_pembicara_2;
                        $validated_pembicara['foto_pembicara_2']->storeAs('/public/foto_pembicara', $foto_pembicara_2);
                    }
                }
                $pembicara_2->save();
            } elseif ($validated_pembicara['nama_pembicara_2']) {
                $pembicara_2 = new Pembicara();
                $pembicara_2->id_kuliah_umum = $request->id_kuliah_umum;
                $pembicara_2->nama = $validated_pembicara['nama_pembicara_2'];
                $pembicara_2->jabatan = $validated_pembicara['jabatan_pembicara_2'];
                $pembicara_2->instansi = $validated_pembicara['instansi_pembicara_2'];
                $pembicara_2->tipe = "p";
                if (isset($validated_pembicara['foto_pembicara_2'])) {
                    if ($validated_pembicara['foto_pembicara_2'] != '' || $validated_pembicara['foto_pembicara_2'] != $pembicara_2->foto) {
                        if (Storage::disk('public')->exists('foto_pembicara/' . $pembicara_2->foto)) {
                            Storage::delete('public/foto_pembicara/' . $pembicara_2->foto);
                        }
                        $foto_pembicara_2 = date('YmdHis') . '.' . $validated_pembicara['foto_pembicara_2']->getClientOriginalExtension();
                        $pembicara_2->foto = $foto_pembicara_2;
                        $validated_pembicara['foto_pembicara_2']->storeAs('/public/foto_pembicara', $foto_pembicara_2);
                    }
                }
                $pembicara_2->save();
            }

            if (isset($request->id_pembicara_3)) {
                $pembicara_3 = Pembicara::find($request->id_pembicara_3);
                $pembicara_3->nama = $validated_pembicara['nama_pembicara_3'];
                $pembicara_3->jabatan = $validated_pembicara['jabatan_pembicara_3'];
                $pembicara_3->instansi = $validated_pembicara['instansi_pembicara_3'];
                if (isset($validated_pembicara['foto_pembicara_2'])) {
                    if ($validated_pembicara['foto_pembicara_3'] != '' || $validated_pembicara['foto_pembicara_3'] != $pembicara_3->foto) {
                        if (Storage::disk('public')->exists('foto_pembicara/' . $pembicara_3->foto)) {
                            Storage::delete('public/foto_pembicara/' . $pembicara_3->foto);
                        }
                        $foto_pembicara_3 = date('YmdHis') . '.' . $validated_pembicara['foto_pembicara_3']->getClientOriginalExtension();
                        $pembicara_3->foto = $foto_pembicara_3;
                        $validated_pembicara['foto_pembicara_3']->storeAs('/public/foto_pembicara', $foto_pembicara_3);
                    }
                }
                $pembicara_3->save();
            } elseif ($validated_pembicara['nama_pembicara_3']) {
                $pembicara_3 = new Pembicara();
                $pembicara_3->id_kuliah_umum = $request->id_kuliah_umum;
                $pembicara_3->nama = $validated_pembicara['nama_pembicara_3'];
                $pembicara_3->jabatan = $validated_pembicara['jabatan_pembicara_3'];
                $pembicara_3->instansi = $validated_pembicara['instansi_pembicara_3'];
                $pembicara_3->tipe = "p";
                if (isset($validated_pembicara['foto_pembicara_3'])) {
                    if ($validated_pembicara['foto_pembicara_3'] != '' || $validated_pembicara['foto_pembicara_3'] != $pembicara_3->foto) {
                        if (Storage::disk('public')->exists('foto_pembicara/' . $pembicara_3->foto)) {
                            Storage::delete('public/foto_pembicara/' . $pembicara_3->foto);
                        }
                        $foto_pembicara_3 = date('YmdHis') . '.' . $validated_pembicara['foto_pembicara_3']->getClientOriginalExtension();
                        $pembicara_3->foto = $foto_pembicara_3;
                        $validated_pembicara['foto_pembicara_3']->storeAs('/public/foto_pembicara', $foto_pembicara_3);
                    }
                }
                $pembicara_3->save();
            }
        }
        if (session('user_data')['role'] == 1) {
            return redirect()->to('jadwal-kuliah-umum')->with('success', ["type" => "success", "message" => "Jadwal Kuliah Lapangan Berhasil Diubah"]);
        }

        // return redirect()->back();
        return redirect()->to(url('jadwal-praktikum'));
    }
}
