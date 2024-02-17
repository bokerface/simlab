<?php

namespace App\Http\Controllers;

use App\Models\Notif;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function check($id_notif)
    {
        $notif = Notif::find($id_notif);
        if ($notif->role_penerima == session('user_data')['role'] && $notif->id_penerima == session('user_data')['user_id']) {
            $notif->checked = true;
            $notif->save();
            return redirect()->to($notif->url);
        }
    }
}
