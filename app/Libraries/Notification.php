<?php

namespace App\Libraries;

use App\Models\Notif;

class Notification
{

    public function create_notif($attributes)
    {
        $notif = new Notif();
        $notif->id_penerima = $attributes['id_penerima'];
        $notif->role_penerima = $attributes['role_penerima'];
        $notif->judul = $attributes['judul'];
        $notif->isi = $attributes['isi'];
        $notif->url = $attributes['url'];
        return $notif->save();
    }
}
