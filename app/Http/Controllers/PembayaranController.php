<?php

namespace App\Http\Controllers;

use App\Http\Requests\PembayaranRequest;
use App\Libraries\Notification;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    public function show($id_dosen = null, $id_praktikum = null, $id_tahun = null, $jenis = null, $semester = null)
    {
        $data_pembayaran = DB::connection('sqlsrv')
            ->table('pembayaran')
            ->select('*')
            ->where([
                ['id_dosen', '=', $id_dosen],
                ['id_praktikum', '=', $id_praktikum],
                ['id_tahun', '=', $id_tahun],
                ['jenis', '=', $jenis],
                ['semester', '=', $semester],
            ])
            ->first();
        // ->get()
        // ->toArray();


        return response(json_encode($data_pembayaran));
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

                $data = [
                    'id_penerima' => $validated['id_pegawai'],
                    'role_penerima' => 2,
                    'judul' => 'Pembayaran ' . $validated['type'],
                    'isi' => 'Admin Telah Mengirimkan Bukti Pembayaran',
                    'url' => url('jadwal-praktikum')
                ];
                $notif = new Notification();
                $notif->create_notif($data);

                return redirect()->back()->with('success', ['type' => 'success', 'message' => 'Laporan Pembayaran Berhasil']);
            }
            return redirect()->back()->withErrors(["type" => "danger", "message" => "gagal menyimpan data pembayaran"]);
        }
        return redirect()->back()->withErrors(["type" => "danger", "message" => "gagal menyimpan data pembayaran"]);

        // dd($pembayaran->save());
    }
}
