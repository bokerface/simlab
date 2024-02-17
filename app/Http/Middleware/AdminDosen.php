<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminDosen
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
        if (session('user_data')['role'] == 1 || session('user_data')['role'] == 2) {
            return $next($request);
        }
        return redirect('/')->withErrors([
            "type" => "danger",
            "message" => "Anda tidak mempunyai hak untuk mengakses halaman ini!"
        ]);
    }
}
