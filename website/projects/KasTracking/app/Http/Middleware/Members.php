<?php

namespace App\Http\Middleware;
use App\Helpers\Tools;

use Closure;
use Illuminate\Support\Facades\Cookie;

class Members
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
        $anggota = \App\OrganisasiMembers::where('member_id', Cookie::get('member_id'))->where('keys', Cookie::get('keys'))->first();
       
        if(!$anggota){
            Cookie::forget('member_id');
            Cookie::forget('keys');

            return redirect('member')->with('error','Akses ditolak, anggota dengan akun ini tidak terdafar.');
        }

        return $next($request);
    }
}
