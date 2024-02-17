<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        if (session('user_data')) {
            return redirect()->to('/');
        }

        return view('login');
    }

    public function login(Request $request)
    {
        // $rules = [
        //     'username' => 'required',
        //     'password' => 'required'
        // ];

        // $validator = Validator::make($request->all(), $rules);

        // if ($validator->fails()) {
        //     return redirect()->back()->withErrors(["type" => "danger", "message" => "username atau password salah"]);
        // }

        $data = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if ($request->admin) {
            // Admin login attempt
            $user = DB::connection('mysql')
                ->table('users')
                ->where('username', '=', $data['username'])
                ->first();

            // dd($user);

            if ($user) {
                if (Hash::check($data['password'], $user->password)) {
                    $user_data = [
                        "user_id" => $user->id,
                        "username" => $user->username,
                        "fullname" => $user->fullname,
                        "email" => $user->email,
                        "telp" => $user->telp,
                        "role" => $user->role,
                        "isLoggedIn" => true
                    ];

                    Session::put("user_data", $user_data);
                    return redirect('/');
                }
                return redirect()->back()->withErrors(["type" => "danger", "message" => "username atau password salah"]);
            }
            return redirect()->back()->withErrors(["type" => "danger", "message" => "username atau password salah"]);
        } else {
            // Non Admin login attempt

            $params = http_build_query($data);
            $email = $request->username;
            $body = array('http' =>
            array(
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => $params
            ));
            $context = stream_context_create($body);
            $link = file_get_contents('https://sso.umy.ac.id/api/Authentication/Login', false, $context);
            $json = json_decode($link);

            $ceknum = $json->{'code'};

            if ($ceknum == 0) {
                $mahasiswa = DB::connection('sqlsrv')
                    ->table('V_Mahasiswa')
                    ->where('EMAIL', '=', $email)
                    ->first();

                if ($mahasiswa) {
                    $user_data = [
                        "user_id" => $mahasiswa->STUDENTID,
                        "fullname" => $mahasiswa->FULLNAME,
                        "email" => $mahasiswa->EMAIL,
                        "role" => 3,
                        "isLoggedIn" => true
                    ];

                    Session::put("user_data", $user_data);
                    return redirect('/');
                }

                $dosen = DB::table('V_Dosen')
                    ->where('email', '=', $email)
                    ->first();

                if ($dosen) {
                    $user_data = [
                        "user_id" => $dosen->id_pegawai,
                        "fullname" => $dosen->nama,
                        "email" => $dosen->email,
                        "role" => 2,
                        "isLoggedIn" => true
                    ];

                    Session::put("user_data", $user_data);
                    return redirect('/');
                }

                return redirect()->back()->withErrors(["type" => "danger", "message" => "username atau password salah"]);
            }

            // test login mahasiswa

            // $mahasiswa = DB::connection('sqlsrv')
            //     ->table('V_Mahasiswa')
            //     ->where('STUDENTID', '=', $data['username'])
            //     ->first();

            // if ($mahasiswa) {
            //     $user_data = [
            //         "user_id" => $mahasiswa->STUDENTID,
            //         "fullname" => $mahasiswa->FULLNAME,
            //         "email" => $mahasiswa->EMAIL,
            //         "role" => 3,
            //         "isLoggedIn" => true
            //     ];

            //     Session::put("user_data", $user_data);
            //     return redirect('/');
            // }

            return redirect()->back()->withErrors(["type" => "danger", "message" => "username atau password salah"]);
        }
    }

    public function logout()
    {
        Session::flush();
        return redirect('/login');
    }
}
