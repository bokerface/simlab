<?php

namespace App\Http\Controllers;

use App\Http\Requests\KonfirmasiLaporanRequest;
use App\Http\Requests\LaporanRequest;
use App\Libraries\Notification;
use App\Models\Dosen;
use App\Models\JadwalPraktikum;
use App\Models\Laporan;
use App\Models\Matkul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id_praktikum, $tahun_ajaran, $semester)
    {
        $praktikum = JadwalPraktikum::where([
            ['COURSE_ID', '=', $id_praktikum],
            ['THAJARANID', '=', $tahun_ajaran],
            ['TERMID', '=', $semester]
        ])->first();

        if (empty($praktikum)) {
            return redirect()->to(url('jadwal-praktikum'))->withErrors(["type" => "danger", "message" => "Praktikum tidak ditemukan"]);
        }

        return view('/pages/dosen/laporan/buat_laporan', ['praktikum' => $praktikum]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LaporanRequest $laporan_request)
    {
        // dd($laporan_request->all());
        $validated_laporan_request = $laporan_request->validated();
        $nama_dosen = Dosen::where('id_pegawai', '=', session('user_data')['user_id'])->first()->nama;
        $nama_praktikum = Matkul::where('course_id', '=', $validated_laporan_request['id_praktikum'])->first()->name_of_course;

        $laporan = new Laporan();
        $laporan->id_praktikum = $validated_laporan_request['id_praktikum'];
        $laporan->tahun = $validated_laporan_request['tahun_ajaran'];
        $laporan->semester = $validated_laporan_request['semester'];
        $laporan->id_dosen = session('user_data')['user_id'];
        // $laporan->tahun = date('Y');

        // dd($validated_laporan_request);

        // Nama Laporan Praktikum
        $laporan_praktikum = date('YmdHis') . '.' . $validated_laporan_request['laporan_praktikum']->getClientOriginalExtension();
        $laporan->laporan_praktikum = $laporan_praktikum;
        // Nama Laporan Kuliah Umum
        $laporan_kuliah_umum = date('YmdHis') . '.' . $validated_laporan_request['laporan_kuliah_umum']->getClientOriginalExtension();
        $laporan->laporan_kuliah_umum = $laporan_kuliah_umum;
        // Nama Laporan Kuliah Lapangan
        $laporan_kuliah_lapangan = date('YmdHis') . '.' . $validated_laporan_request['laporan_kuliah_lapangan']->getClientOriginalExtension();
        $laporan->laporan_kuliah_lapangan = $laporan_kuliah_lapangan;

        if (empty(JadwalPraktikum::where([
            ['COURSE_ID', '=', $validated_laporan_request['id_praktikum']],
            ['THAJARANID', '=', $validated_laporan_request['tahun_ajaran']],
            ['TERMID', '=', $validated_laporan_request['semester']]
        ])->first())) {
            return redirect()->to(url('jadwal-praktikum'))->withErrors(["type" => "danger", "message" => "Praktikum tidak ditemukan"]);
        }

        if ($laporan->save()) {
            $validated_laporan_request['laporan_praktikum']->storeAs('/public/laporan_praktikum', $laporan_praktikum);
            $validated_laporan_request['laporan_kuliah_umum']->storeAs('/public/laporan_kuliah_umum', $laporan_kuliah_umum);
            $validated_laporan_request['laporan_kuliah_lapangan']->storeAs('/public/laporan_kuliah_lapangan', $laporan_kuliah_lapangan);

            $notif = new Notification();
            $attributes = [
                'id_penerima' => 1,
                'role_penerima' => 1,
                'judul' => 'Laporan Praktikum',
                'isi' => "Dosen $nama_dosen telah mengirimkan laporan praktikum $nama_praktikum",
                'url' => url('pembayaran-dosen/' . session('user_data')['user_id'])
            ];
            $notif->create_notif($attributes);
        }

        return redirect()->to(url('/jadwal-praktikum'))->with('success', ['type' => 'success', 'message' => 'Laporan Berhasil Dikirim']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id_laporan)
    {
        // dd($id_laporan);
        $laporan = Laporan::find($id_laporan);
        if (empty($laporan)) {
            return redirect()->to(url('/'))->withErrors(['type' => 'danger', 'message' => 'laporan tidak ditemukan']);
        }
        // dd($laporan->id);
        $praktikum = Matkul::where('course_id', '=', $laporan->id_praktikum)->first();
        return view('/pages/admin/laporan/cek-laporan', ['laporan' => $laporan, 'praktikum' => $praktikum]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $laporan = Laporan::find($id);
        // dd($laporan);

        $praktikum = Matkul::where('course_id', '=', $laporan->id_praktikum)->first();
        return view('/pages/dosen/laporan/revisi_laporan', ['praktikum' => $praktikum, 'laporan' => $laporan]);
    }

    public function revisi(LaporanRequest $revisi_laporan_request, $id)
    {
        $validated_revisi_laporan_request = $revisi_laporan_request->validated();
        $laporan = Laporan::find($id);
        $notif = new Notification();
        $nama_dosen = Dosen::find($laporan->id_dosen)->first()->nama;

        if ($laporan->praktikum_selesai != 1 && isset($validated_revisi_laporan_request['laporan_praktikum'])) {
            // dd($validated_revisi_laporan_request['laporan_praktikum']);

            if (Storage::disk('public')->exists('laporan_praktikum/' . $laporan->laporan_praktikum)) {
                Storage::delete('public/laporan_praktikum/' . $laporan->laporan_praktikum);
            }
            $laporan_praktikum = date('YmdHis') . '.' . $validated_revisi_laporan_request['laporan_praktikum']->getClientOriginalExtension();
            $validated_revisi_laporan_request['laporan_praktikum']->storeAs('/public/laporan_praktikum', $laporan_praktikum);
            $laporan->laporan_praktikum = $laporan_praktikum;
            $laporan->catatan1 = null;

            $attributes = [
                'id_penerima' => 1,
                'role_penerima' => 1,
                'judul' => 'Revisi Laporan',
                'isi' => "Dosen $nama_dosen telah mengirimkan revisi laporan praktikum",
                'url' => url('cek-laporan/' . $laporan->id)
            ];
            $notif->create_notif($attributes);
        }

        if ($laporan->kuliah_umum_selesai != 1 && isset($validated_revisi_laporan_request['laporan_kuliah_umum'])) {
            // dd($validated_revisi_laporan_request['laporan_kuliah_umum']);

            if (Storage::disk('public')->exists('laporan_kuliah_umum/' . $laporan->laporan_kuliah_umum)) {
                Storage::delete('public/laporan_kuliah_umum/' . $laporan->laporan_kuliah_umum);
            }
            $laporan_kuliah_umum = date('YmdHis') . '.' . $validated_revisi_laporan_request['laporan_kuliah_umum']->getClientOriginalExtension();
            $validated_revisi_laporan_request['laporan_kuliah_umum']->storeAs('/public/laporan_kuliah_umum', $laporan_kuliah_umum);
            $laporan->laporan_kuliah_umum = $laporan_kuliah_umum;
            $laporan->catatan2 = null;

            $attributes = [
                'id_penerima' => 1,
                'role_penerima' => 1,
                'judul' => 'Revisi Laporan',
                'isi' => "Dosen $nama_dosen telah mengirimkan revisi laporan kuliah umum",
                'url' => url('cek-laporan/' . $laporan->id)
            ];
            $notif->create_notif($attributes);
        }

        if ($laporan->kuliah_lapangan_selesai != 1 && isset($validated_revisi_laporan_request['laporan_kuliah_lapangan'])) {
            // dd($validated_revisi_laporan_request['laporan_kuliah_lapangan']);

            if (Storage::disk('public')->exists('laporan_kuliah_lapangan/' . $laporan->laporan_kuliah_lapangan)) {
                Storage::delete('public/laporan_kuliah_lapangan/' . $laporan->laporan_kuliah_lapangan);
            }
            $laporan_kuliah_lapangan = date('YmdHis') . '.' . $validated_revisi_laporan_request['laporan_kuliah_lapangan']->getClientOriginalExtension();
            $validated_revisi_laporan_request['laporan_kuliah_lapangan']->storeAs('/public/laporan_kuliah_lapangan', $laporan_kuliah_lapangan);
            $laporan->laporan_kuliah_lapangan = $laporan_kuliah_lapangan;
            $laporan->catatan3 = null;

            $attributes = [
                'id_penerima' => 1,
                'role_penerima' => 1,
                'judul' => 'Revisi Laporan',
                'isi' => "Dosen $nama_dosen telah mengirimkan revisi laporan kuliah lapangan",
                'url' => url('cek-laporan/' . $laporan->id)
            ];
            $notif->create_notif($attributes);
        }

        // dd($laporan->first()->laporan_kuliah_umum);


        $laporan->save();
        return redirect()->to(url('/jadwal-praktikum'))->with('success', ['type' => 'success', 'message' => 'Revisi laporan berhasil disimpan']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, KonfirmasiLaporanRequest $laporan_request, $id)
    {
        $validated_laporan_request = $laporan_request->validated();
        $laporan = Laporan::find($id);
        $notif = new Notification();

        // dd($laporan->id);

        if ($request->laporan_praktikum == 'ok') {
            $laporan->praktikum_selesai = '1';
            $laporan->catatan1 = null;

            $attributes = [
                'id_penerima' => $laporan->id_dosen,
                'role_penerima' => 2,
                'judul' => 'Laporan Diterima',
                'isi' => "Laporan Praktikum yang anda kirimkan diterima oleh admin",
                'url' => url('jadwal-praktikum/revisi-laporan/' . $laporan->id)
            ];
            $notif->create_notif($attributes);
        } elseif ($request->laporan_praktikum == 'revisi') {
            $laporan->praktikum_selesai = null;
            $laporan->catatan1 = $validated_laporan_request['catatan_revisi_praktikum'];

            $attributes = [
                'id_penerima' => $laporan->id_dosen,
                'role_penerima' => 2,
                'judul' => 'Revisi Laporan',
                'isi' => "Laporan Praktikum yang anda kirimkan perlu direvisi",
                'url' => url('jadwal-praktikum/revisi-laporan/' . $laporan->id)
            ];
            $notif->create_notif($attributes);
        }

        if ($request->laporan_kuliah_umum == 'ok') {
            $laporan->kuliah_umum_selesai = '1';
            $laporan->catatan2 = null;

            $attributes = [
                'id_penerima' => $laporan->id_dosen,
                'role_penerima' => 2,
                'judul' => 'Laporan Diterima',
                'isi' => "Laporan Kuliah Umum yang anda kirimkan diterima oleh admin",
                'url' => url('jadwal-praktikum/revisi-laporan/' . $laporan->id)
            ];
            $notif->create_notif($attributes);
        } elseif ($request->laporan_kuliah_umum == 'revisi') {
            $laporan->kuliah_umum_selesai = null;
            $laporan->catatan2 = $validated_laporan_request['catatan_revisi_kuliah_umum'];

            $attributes = [
                'id_penerima' => $laporan->id_dosen,
                'role_penerima' => 2,
                'judul' => 'Revisi Laporan',
                'isi' => "Laporan Kulih Umum yang anda kirimkan perlu direvisi",
                'url' => url('jadwal-praktikum/revisi-laporan/' . $laporan->id)
            ];
            $notif->create_notif($attributes);
        }

        if ($request->laporan_kuliah_lapangan == 'ok') {
            $laporan->kuliah_lapangan_selesai = '1';
            $laporan->catatan3 = null;

            $attributes = [
                'id_penerima' => $laporan->id_dosen,
                'role_penerima' => 2,
                'judul' => 'Laporan Diterima',
                'isi' => "Laporan Kuliah Lapangan yang anda kirimkan diterima oleh admin",
                'url' => url('jadwal-praktikum/revisi-laporan/' . $laporan->id)
            ];
            $notif->create_notif($attributes);
        } elseif ($request->laporan_kuliah_lapangan == 'revisi') {
            $laporan->kuliah_lapangan_selesai = null;
            $laporan->catatan3 = $validated_laporan_request['catatan_revisi_kuliah_lapangan'];

            $attributes = [
                'id_penerima' => $laporan->id_dosen,
                'role_penerima' => 2,
                'judul' => 'Revisi Laporan',
                'isi' => "Laporan Kuliah Lapangan yang anda kirimkan perlu direvisi",
                'url' => url('jadwal-praktikum/revisi-laporan/' . $laporan->id)
            ];
            $notif->create_notif($attributes);
        }

        $laporan->save();

        return redirect()->to('pembayaran-dosen/' . $laporan->first()->id_dosen)->with('success', ['type' => 'success', 'message' => 'Konfirmasi Praktikum Berhasil Dikirim']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
