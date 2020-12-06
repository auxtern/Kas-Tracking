<?php

namespace App\Http\Controllers;

use App\Helpers\Tools;
use App\Organisasi;
use App\OrganisasiUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OrganisasiController extends Controller
{

    /**
     * Mengolah data yang diperlukan saat controller dibuat
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['auth', 'verified']);
    }


    /**
     * Menampilkan data organisasi yang diikuti
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $data['url_foto'] = Tools::ambilFotoProfil($user->foto, $user->jenis_kelamin); 
        $data['status'] = Tools::ambilStatus($user->role);
        $data['organisasi'] = Organisasi::where("user_id", $user->id);

        return view('main.organisasi.index', $data);
    }

    /**
     * Menampilkan form untuk membuat organisasi
     *
     * @return \Illuminate\Http\Response
     */
    public function createView()
    {
        $user = Auth::user();
        
        $data['url_foto'] = Tools::ambilFotoProfil($user->foto, $user->jenis_kelamin); 
        $data['status'] = Tools::ambilStatus($user->role);
        return view("main.organisasi.create", $data);
    }


    /**
     * Menambahkan data organisasi ke database
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $this->validate($request, [
            'nama' => 'required|string|min:6|max:200',
            'lokasi' => 'required|string|min:6|max:200',
        ]);

        // Ambil data user yang login
        $user = Auth::user();

        // Buat data baru
        $organisasi = new Organisasi();
        $organisasi->user_id = $user->id;
        $organisasi->nama = strip_tags($request->input('nama'));
        $organisasi->lokasi = strip_tags($request->input('lokasi'));
        $organisasi->save();

        // Tambahkan user pembuat ke organisasi members
        $orgUsers = new OrganisasiUsers();
        $orgUsers->user_id = $user->id;
        $orgUsers->organisasi_id = $organisasi->organisasi_id;
        $orgUsers->save();

        return redirect('organisasi');
    }



}
