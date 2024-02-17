<?php

use Illuminate\Support\Facades\Route;

use Bokerface\Survey\SurveyController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PraktikumController;
use App\Http\Controllers\SoftskillController;
use App\Http\Controllers\KuliahlapanganController;
use App\Http\Controllers\KuliahumumController;
use App\Http\Controllers\KurikulumController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\SurveyController as ControllersSurveyController;
use App\Models\KurikulumSoftskill;
use App\Models\Softskill;
use App\View\Components\Dosen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->middleware('customauth');

Route::get('/login', [AuthController::class, 'index']);

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::group(['middleware' => 'customauth'], function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    // Public Praktikum Routes
    Route::get('/jadwal-praktikum', [PraktikumController::class, 'jadwal_praktikum']);
    // Public Kuliah Lapangan Routes
    Route::get('/jadwal-kuliah-lapangan', [KuliahlapanganController::class, 'jadwal_kuliah_lapangan']);
    // Public Kuliah Umum Routes
    Route::get('/jadwal-kuliah-umum', [KuliahumumController::class, 'jadwal_kuliah_umum']);
    // Public Softskills Routes
    Route::get('/jadwal-softskill', [SoftskillController::class, 'jadwal_softskill']);
    // Public Notification Route
    Route::get('notification/check/{id_notification}', [NotificationController::class, 'check']);
    // Public Bukti Presensi
    Route::get('bukti-presensi-softskill/{nama_file}', [ImageController::class, 'bukti_presensi']);

    // Admin & Dosen Routes
    Route::group(['middleware' => 'admin_dosen'], function () {
        // File Laporan
        Route::get('/laporan-praktikum/{nama_file}', [ImageController::class, 'laporan_praktikum']);
        Route::get('/laporan-kuliah-umum/{nama_file}', [ImageController::class, 'laporan_kuliah_umum']);
        Route::get('/laporan-kuliah-lapangan/{nama_file}', [ImageController::class, 'laporan_kuliah_lapangan']);
        // Bukti Pembayaran
        Route::get('/bukti_pembayaran/{file_name}', [ImageController::class, 'bukti_pembayaran']);
        // Edit Kuliah Umum
        Route::get('/jadwal-praktikum/edit-kuliah-umum/{id_kuliah_umum}', [KuliahumumController::class, 'edit_kuliah_umum_view']);
        Route::put('/jadwal-praktikum/edit-jadwal-kuliah-umum', ['before' => 'csrf', KuliahumumController::class, 'update_kuliah_umum']);
        // Edit Kuliah Lapangan
        Route::get('/jadwal-praktikum/edit-jadwal-kuliah-lapangan/{id_kuliah_lapangan}', [KuliahlapanganController::class, 'edit_kuliah_lapangan_view']);
        Route::put('/jadwal-praktikum/edit-jadwal-kuliah-lapangan', ['before' => 'csrf', KuliahlapanganController::class, 'update_kuliah_lapangan']);
    });

    // Admin Only Routes
    Route::group(['middleware' => 'admin'], function () {
        Route::get('/adminonly', function () {
            echo "admin only page";
        });
        // Praktikum Routes
        Route::get('/semua-praktikum', [PraktikumController::class, 'semua_praktikum']);
        Route::get('/praktikum-by-kurikulum-data/{id_kurikulum?}', [PraktikumController::class, 'praktikum_by_kurikulum_data']);
        Route::get('/arsip-praktikum-data', [PraktikumController::class, 'arsip_praktikum_data']);
        Route::get('/arsip-praktikum', [PraktikumController::class, 'arsip_praktikum_view']);
        // Softskill Routes
        Route::get('/jadwal-softskill/tambah-jadwal', [SoftskillController::class, 'tambah_jadwal_softskill']);
        Route::get('/arsip-softskill-data', [SoftskillController::class, 'arsip_softskill_data']);
        Route::get('/arsip-softskill', [SoftskillController::class, 'arsip_softskill_view']);
        Route::get('/peserta-softskill-data', [MahasiswaController::class, 'peserta_softskill_data']);
        Route::get('/softskill-by-kurikulum-data/{id_kurikulum?}', [SoftskillController::class, 'softskill_by_kurikulum_data']);
        Route::post('/save_kurikulum_softskill', ['before' => 'csrf', KurikulumController::class, 'store_kurikulum_tahun_ajaran_softskill']);
        Route::post('/save_jadwal_softskill', ['before' => 'csrf', SoftskillController::class, 'store_jadwal_softskill']);
        Route::get('/softskill-select-data/{nama_softskill?}', [SoftskillController::class, 'vue_select_softskills_data']);
        Route::get('jadwal-softskill/{id}', [SoftskillController::class, 'detail_jadwal_softskill']);
        Route::get('detail-jadwal-softskill-data/{id}', [SoftskillController::class, 'detail_jadwal_softskill_data']);
        Route::post('verifikasi-kehadiran', ['before' => 'csrf', SoftskillController::class, 'verifikasi_kehadiran']);
        // Mahasiswa Routes
        Route::get('/mahasiswa', [MahasiswaController::class, 'peserta_softskill_view']);
        // Dosen Routes
        Route::get('/daftar-dosen', [DosenController::class, 'daftar_dosen']);
        Route::post('/daftar-dosen-data', [DosenController::class, 'daftar_dosen_data']);
        Route::get('/pembayaran-dosen', [DosenController::class, 'daftar_dosen']);
        Route::get('/pembayaran-dosen/{id_dosen}', [DosenController::class, 'pembayaran_dosen']);
        Route::get('/dosen/{id_dosen}', [DosenController::class, 'detail_dosen']);
        Route::put('/edit_dosen',  ['before' => 'csrf', DosenController::class, 'save_profil_dosen']);
        // Kurikulum Routes
        Route::get('/kurikulum', [KurikulumController::class, 'index']);
        Route::get('/kurikulum-praktikum-data', [KurikulumController::class, 'kurikulum_praktikum_data']);
        Route::get('/kurikulum-tahun-ajaran-data', [KurikulumController::class, 'kurikulum_tiap_tahun_ajaran']);
        Route::get('/kurikulum-softskill-data', [KurikulumController::class, 'kurikulum_softskill_data']);
        Route::get('kurikulum/buat-kurikulum-baru', [KurikulumController::class, 'buat_kurikulum']);
        Route::post('kurikulum/buat-kurikulum-baru', ['before' => 'csrf', KurikulumController::class, 'store_kurikulum']);
        // Pembayaran Routes
        Route::post('/simpan_laporan_pembayaran', [PembayaranController::class, 'store_pembayaran', 'before' => 'csrf']);
        // Route::get('/bukti_pembayaran/{file_name}', [ImageController::class, 'bukti_pembayaran']);
        Route::get('/data_pembayaran/{id_dosen}/{id_praktikum}/{id_tahun}/{jenis}/{semester}', [PembayaranController::class, 'show']);
        // Laporan Routes
        Route::get('/cek-laporan/{id_laporan}', [LaporanController::class, 'show']);
        Route::put('/cek-laporan/{id_laporan}', ['before' => 'csrf', LaporanController::class, 'update']);
    });

    // Mahasiswa Only Routes
    Route::group(['middleware' => 'mahasiswa'], function () {
        // Softskills Routes
        Route::post('jadwal-softskill/upload-bukti-kehadiran', ['before' => 'csrf', SoftskillController::class, 'upload_bukti_kehadiran']);
    });

    // Dosen Only Routes
    Route::group(['middleware' => 'dosen'], function () {
        // Kuliah Umum Routes
        Route::get('/jadwal-praktikum/tambah-jadwal-kuliah-umum/{id_praktikum}/{tahun_ajaran}/{semester}', [KuliahumumController::class, 'tambah_kuliah_umum_view']);
        Route::post('/jadwal-praktikum/tambah-jadwal-kuliah-umum', ['before' => 'csrf', KuliahumumController::class, 'tambah_kuliah_umum_store']);
        Route::get('/foto-moderator/{file_name}', [ImageController::class, 'foto_moderator']);
        Route::get('/foto-pembicara/{file_name}', [ImageController::class, 'foto_pembicara']);
        // Pembayaran Routes

        // Kuliah Lapangan Routes
        Route::get('/jadwal-praktikum/tambah-jadwal-kuliah-lapangan/{id_praktikum}/{tahun_ajaran}/{semester}', [KuliahlapanganController::class, 'tambah_kuliah_lapangan_view']);
        Route::post('/jadwal-praktikum/tambah-jadwal-kuliah-lapangan', [KuliahlapanganController::class, 'store_kuliah_lapangan', 'before' => 'csrf']);

        // Laporan Routes
        Route::get('/jadwal-praktikum/buat-laporan/{id_praktikum}/{tahun_ajaran}/{semester}', [LaporanController::class, 'create']);
        Route::post('/jadwal-praktikum/buat-laporan', ['before' => 'csrf', LaporanController::class, 'store']);
        Route::get('/jadwal-praktikum/revisi-laporan/{id_laporan}', [LaporanController::class, 'edit']);
        Route::put('/jadwal-praktikum/revisi-laporan/{id_laporan}', ['before' => 'csrf', LaporanController::class, 'revisi']);
    });
});
