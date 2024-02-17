<?php

function profile_pic()
{
    if (session('user_data')['role'] == 3) {
        $id = session('user_data')['user_id'];
        $year = substr($id, 0, 4);
        $pic = "https://krs.umy.ac.id/FotoMhs/$year/$id.jpg";
        return $pic;
    }
    return "https://source.unsplash.com/QAB-WJcbgJk/60x60";
}
