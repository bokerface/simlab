<?php

namespace App\View\Composers;

use App\Models\Notif;
use Illuminate\View\View;

class NotifComposer
{
    public function compose(View $view)
    {
        $notif = Notif::where([
            ['id_penerima', '=', session('user_data')['user_id']],
            ['role_penerima', '=', session('user_data')['role']],
            ['checked', '=', null]
        ]);
        $number_of_notif = $notif->count();

        $notification_list = $notif->get()->toArray();
        // $notification_list = [];
        // foreach ($notif->get()->toArray() as $notif) {
        //     $notification_list[]=[

        //     ];
        // }

        $view->with([
            'number_of_notif' => $number_of_notif,
            'notification_list' => $notification_list
        ]);
    }
}
