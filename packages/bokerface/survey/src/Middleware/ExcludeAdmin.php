<?php

namespace Bokerface\Survey\Middleware;

use Closure;
use Illuminate\Http\Request;

class ExcludeAdmin
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
        if (session('user_data')['role'] == 2 || session('user_data')['role'] == 3) {
            return $next($request);
        }
        return redirect('/')->withErrors([
            "type" => "danger",
            "message" => "Anda tidak mempunyai hak untuk mengakses halaman ini!"
        ]);
    }
}
