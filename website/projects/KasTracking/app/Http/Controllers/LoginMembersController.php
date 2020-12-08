<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OrganisasiMembers;
use Illuminate\Support\Facades\Cookie;

class LoginMembersController extends Controller
{
    public function cekAnggota(Request $request){
        $anggota = OrganisasiMembers::where('member_id', $request->input('member_id'))->where('keys', $request->input('keys'))->get()->first();

        if(!$anggota){
            return redirect()->back()->with('error', "Akun ini tidak terdaftar di organisasi manapun!");
        }

        Cookie::queue('member_id', $request->member_id, 60);
        Cookie::queue('keys', $request->keys, 60);
        return redirect('member/dashboard');
    }

    public function logout(Request $request){ 
        Cookie::queue('member_id', "", 1);
        Cookie::queue('keys', "", 1);
        return redirect('member');
    }
}
