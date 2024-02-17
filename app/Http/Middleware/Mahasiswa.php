<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Mahasiswa
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (session('user_data')['role'] == 3) {
            return $next($request);
        }
        return redirect()->to('/')->withErrors([
            "type" => "danger",
            "message" => "Anda tidak mempunyai hak untuk mengakses halaman ini!"
        ]);
    }
}
