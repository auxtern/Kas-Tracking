<?php

namespace App\Http\Controllers;
use App\Helpers\Tools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'admin']);
    }

    public function users(){

        $user = Auth::user();
        $data['url_foto'] = Tools::ambilFotoProfil($user->foto, $user->jenis_kelamin);
        $data['status'] = Tools::ambilStatus($user->role);

        return view('admin.users', $data);
    }

    public function organisasi(){

        $user = Auth::user();
        $data['url_foto'] = Tools::ambilFotoProfil($user->foto, $user->jenis_kelamin);
        $data['status'] = Tools::ambilStatus($user->role);

        return view('admin.organisasi', $data);
    }


}
