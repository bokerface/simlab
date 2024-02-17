<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function bukti_pembayaran($filename)
    {
        $exist = Storage::disk('public')->exists('bukti_pembayaran/' . $filename);
        if ($exist) {
            $content = Storage::get('public/bukti_pembayaran/' . $filename);
            $mime = Storage::mimeType('public/bukti_pembayaran/' . $filename);
            $response = Response::make($content, 200);
            $response->header("Content-Type", $mime);
            return $response;
        }
        return "file not exists";
    }

    public function foto_moderator($filename)
    {
        $exist = Storage::disk('public')->exists('foto_moderator/' . $filename);
        if ($exist) {
            $content = Storage::get('public/foto_moderator/' . $filename);
            $mime = Storage::mimeType('public/foto_moderator/' . $filename);
            $response = Response::make($content, 200);
            $response->header("Content-Type", $mime);
            return $response;
        }
        return "file not exists";
    }

    public function foto_pembicara($filename)
    {
        $exist = Storage::disk('public')->exists('foto_pembicara/' . $filename);
        if ($exist) {
            $content = Storage::get('public/foto_pembicara/' . $filename);
            $mime = Storage::mimeType('public/foto_pembicara/' . $filename);
            $response = Response::make($content, 200);
            $response->header("Content-Type", $mime);
            return $response;
        }
        return "file not exists";
    }

    public function laporan_praktikum($filename)
    {
        $exist = Storage::disk('public')->exists('laporan_praktikum/' . $filename);
        if ($exist) {
            $content = Storage::get('public/laporan_praktikum/' . $filename);
            $mime = Storage::mimeType('public/laporan_praktikum/' . $filename);
            $response = Response::make($content, 200);
            $response->header("Content-Type", $mime);
            return $response;
        }
        return "file not exists";
    }

    public function laporan_kuliah_umum($filename)
    {
        $exist = Storage::disk('public')->exists('laporan_kuliah_umum/' . $filename);
        if ($exist) {
            $content = Storage::get('public/laporan_kuliah_umum/' . $filename);
            $mime = Storage::mimeType('public/laporan_kuliah_umum/' . $filename);
            $response = Response::make($content, 200);
            $response->header("Content-Type", $mime);
            return $response;
        }
        return "file not exists";
    }

    public function laporan_kuliah_lapangan($filename)
    {
        $exist = Storage::disk('public')->exists('laporan_kuliah_lapangan/' . $filename);
        if ($exist) {
            $content = Storage::get('public/laporan_kuliah_lapangan/' . $filename);
            $mime = Storage::mimeType('public/laporan_kuliah_lapangan/' . $filename);
            $response = Response::make($content, 200);
            $response->header("Content-Type", $mime);
            return $response;
        }
        return "file not exists";
    }

    public function bukti_presensi($filename)
    {
        $exist = Storage::disk('public')->exists('bukti_presensi/' . $filename);
        if ($exist) {
            $content = Storage::get('public/bukti_presensi/' . $filename);
            $mime = Storage::mimeType('public/bukti_presensi/' . $filename);
            $response = Response::make($content, 200);
            $response->header("Content-Type", $mime);
            return $response;
        }
        return "file not exists";
    }
}
