<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::user()->role != 99){
            return redirect()->back()->with('error','Akses ditolak, akun ini tidak terdaftar sebagai admin!.');
        }

        return $next($request);
    }
}
