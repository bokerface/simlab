<?php

namespace Bokerface\Survey\Middleware;

use Closure;
use Illuminate\Http\Request;

class Admin
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
        if (session('user_data')['role'] == 1) {
            return $next($request);
        }
        return redirect('/')->withErrors([
            "type" => "danger",
            "message" => "Anda tidak mempunyai hak untuk mengakses halaman ini!"
        ]);
    }
}
