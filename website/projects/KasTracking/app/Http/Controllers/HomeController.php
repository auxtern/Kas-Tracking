<?php

namespace App\Http\Controllers;

use App\Helpers\Tools;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['auth', 'verified']);
    }

    /**
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['url_foto'] = Tools::ambilFotoProfil(Auth::user()->foto, Auth::user()->jenis_kelamin); 
        $data['status'] = Tools::ambilStatus(Auth::user()->role);
        return view('main/home', $data);
    }
}
