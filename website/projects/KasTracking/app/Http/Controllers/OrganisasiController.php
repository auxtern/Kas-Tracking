<?php

namespace App\Http\Controllers;

use App\Helpers\Tools;
use App\Organisasi;
use App\User;
use App\OrganisasiUsers;
use App\UsersNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        $data['organisasi'] = Organisasi::whereIn('organisasi_id', function($q) use ($user){
            $q->from('organisasi_users')->select('organisasi_id')->where('user_id', $user->id);
        })->get()->toArray();

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
     * Menampilkan halaman pengolahan keuangan organisasi
     *
     * @return \Illuminate\Http\Response
     */
    public function manage($organisasi_id)
    {
        $user = Auth::user();

        // Periksa apakah user merupakan bendahara organisasi yang dibuka
        $nMatch = OrganisasiUsers::where('user_id', $user->id)->where('organisasi_id', $organisasi_id)->get()->count();
        if($nMatch <= 0){
            return redirect("organisasi");
        }

        $data['organisasi'] = Organisasi::where('organisasi_id', $organisasi_id)->get()->first();

        $data['url_foto'] = Tools::ambilFotoProfil($user->foto, $user->jenis_kelamin); 
        $data['status'] = Tools::ambilStatus($user->role);
        return view("main.organisasi.manage.dashboard", $data);
    }


    /**
     * Menampilkan daftar bendahara dari organisasi
     *
     * @return \Illuminate\Http\Response
     */
    public function manageUsers($organisasi_id)
    {
        $user = Auth::user();

        // Periksa apakah user merupakan bendahara organisasi yang dibuka
        $nMatch = OrganisasiUsers::where('user_id', $user->id)->where('organisasi_id', $organisasi_id)->get()->count();
        if($nMatch <= 0){
            return redirect("organisasi");
        }

        $data['organisasi'] = Organisasi::where('organisasi_id', $organisasi_id)->get()->first();

        $data['bendaharas'] = User::whereIn('id', function($q) use ($organisasi_id){
            $q->from('organisasi_users')->select('user_id')->where('organisasi_id', $organisasi_id);
        })->get()->toArray();


        $data['url_foto'] = Tools::ambilFotoProfil($user->foto, $user->jenis_kelamin); 
        $data['status'] = Tools::ambilStatus($user->role);
        return view("main.organisasi.manage.users", $data);
    }


    /**
     * Menampilkan daftar anggota dari organisasi
     *
     * @return \Illuminate\Http\Response
     */
    public function manageMembers($organisasi_id)
    {
        $user = Auth::user();

        // Periksa apakah user merupakan bendahara organisasi yang dibuka
        $nMatch = OrganisasiUsers::where('user_id', $user->id)->where('organisasi_id', $organisasi_id)->get()->count();
        if($nMatch <= 0){
            return redirect("organisasi");
        }

        $data['organisasi'] = Organisasi::where('organisasi_id', $organisasi_id)->get()->first();

        $data['url_foto'] = Tools::ambilFotoProfil($user->foto, $user->jenis_kelamin); 
        $data['status'] = Tools::ambilStatus($user->role);
        return view("main.organisasi.manage.members", $data);
    }


    /**
     * Menampilkan data keuangan dari organisasi
     *
     * @return \Illuminate\Http\Response
     */
    public function manageMoney($organisasi_id)
    {
        $user = Auth::user();

        // Periksa apakah user merupakan bendahara organisasi yang dibuka
        $nMatch = OrganisasiUsers::where('user_id', $user->id)->where('organisasi_id', $organisasi_id)->get()->count();
        if($nMatch <= 0){
            return redirect("organisasi");
        }

        $data['organisasi'] = Organisasi::where('organisasi_id', $organisasi_id)->get()->first();

        $data['url_foto'] = Tools::ambilFotoProfil($user->foto, $user->jenis_kelamin); 
        $data['status'] = Tools::ambilStatus($user->role);
        return view("main.organisasi.manage.money", $data);
    }


    /**
     * Menampilkan halaman pengaturan
     *
     * @return \Illuminate\Http\Response
     */
    public function manageSettings($organisasi_id)
    {
        $user = Auth::user();

        // Periksa apakah user merupakan bendahara organisasi yang dibuka
        $nMatch = Organisasi::where('user_id', $user->id)->where('organisasi_id', $organisasi_id)->get()->count();

        if($nMatch <= 0){
            return redirect("organisasi");
        }

        $data['organisasi'] = Organisasi::where('organisasi_id', $organisasi_id)->get()->first();

        $data['url_foto'] = Tools::ambilFotoProfil($user->foto, $user->jenis_kelamin); 
        $data['status'] = Tools::ambilStatus($user->role);
        return view("main.organisasi.manage.settings", $data);
    }


    // POST HENDLER
    // ----------------------------------------

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
        $organisasi->token = bin2hex(random_bytes(32));
        $organisasi->save();

        // Tambahkan user pembuat ke organisasi members
        $orgUsers = new OrganisasiUsers();
        $orgUsers->user_id = $user->id;
        $orgUsers->organisasi_id = $organisasi->organisasi_id;
        $orgUsers->save();

        return redirect('organisasi')->with('success', 'Berhasil membuat organisasi!');
    }


    

    /**
     * Menambahkan data organisasi ke database
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $this->validate($request, [
            'organisasi_id' => 'required',
            'nama' => 'required|string|min:6|max:200',
            'lokasi' => 'required|string|min:6|max:200',
        ]);

        // Ambil data user yang login
        $user = Auth::user();

        $organisasi = Organisasi::where('user_id', $user->id)->where('organisasi_id', $request->input('organisasi_id'))->get()->first();

        if(!$organisasi){
            return redirect()->back()->with('error', 'Gagal menyimpan perubahan!');
        }

        // Buat data baru
        $organisasi->nama = strip_tags($request->input('nama'));
        $organisasi->lokasi = strip_tags($request->input('lokasi'));
        $organisasi->token = bin2hex(random_bytes(32));
        $organisasi->save();

        return redirect()->back()->with('success', 'Berhasil menyimpan perubahan!');
    }



    /**
     * Menambahkan data organisasi ke database
     *
     * @return \Illuminate\Http\Response
     */
    public function users(Request $request, $organisasi_id)
    {
        // Ambil data user yang login
        $user = Auth::user();

        // Ambil data organisasi
        $organisasi = Organisasi::where('organisasi_id', $organisasi_id)->get()->first();
    

        if($organisasi->count() <= 0){
            return redirect()->back()->with('error', 'Organisasi tidak ditemukan!');
        }

        if($organisasi->user_id != $user->id){
            return redirect()->back()->with('error', 'Kamu tidak memiliki hak akses untuk menambahkan bendahara di organisasi ini!');
        }

        $this->validate($request, [
            'user_id' => 'required',
        ]);

        $userAdd = User::where('id', $request->input('user_id'))->get()->first();
        if(!$userAdd){
            return redirect()->back()->with('error', 'Pengguna tidak ditemukan!');
        }

        $userInOrg = OrganisasiUsers::where('user_id', $request->input('user_id'))->where('organisasi_id', $organisasi_id)->get()->first();
        if($userInOrg){
            return redirect()->back()->with('success', 'Pengguna telah menjadi bendahara di organisasi ini!');
        }

        // Tambahkan user pembuat ke organisasi members
        $orgUsers = new OrganisasiUsers();
        $orgUsers->user_id = $request->input('user_id');
        $orgUsers->organisasi_id = $organisasi_id;
        $orgUsers->save();

        $userNotif = new UsersNotification();
        $userNotif->user_id = $request->input('user_id');
        $userNotif->pesan = $user->nama . " menjadikan kamu asisten bendahara di organisasi " . $organisasi->nama;
        $userNotif->save();

        return redirect()->back()->with('success', 'Berhasil menambahkan bendahara!');
    }


    /**
     * Menambahkan data organisasi ke database
     *
     * @return \Illuminate\Http\Response
     */
    public function usersDelete(Request $request, $organisasi_id)
    {
        // Ambil data user yang login
        $user = Auth::user();

        // Ambil data organisasi
        $organisasi = Organisasi::where('organisasi_id', $organisasi_id)->get()->first();
    
        if($organisasi->count() <= 0){
            return redirect()->back()->with('error', 'Organisasi tidak ditemukan!');
        }

        if($organisasi->user_id != $user->id){
            return redirect()->back()->with('error', 'Kamu tidak memiliki hak akses untuk mengeluarkan bendahara di organisasi ini!');
        }

        $this->validate($request, [
            'user_id' => 'required',
            'alasan' => 'required|min:6|max:150',
        ]);

        $userAdd = User::where('id', $request->input('user_id'))->get()->first();
        if(!$userAdd){
            return redirect()->back()->with('error', 'Pengguna tidak ditemukan!');
        }

        DB::select('delete from organisasi_users where user_id = ? and organisasi_id = ?', [$request->input('user_id'), $organisasi_id]);

        $userNotif = new UsersNotification();
        $userNotif->user_id = $request->input('user_id');
        $userNotif->pesan = $user->nama . " mengeluarkan kamu dari organisasi " . $organisasi->nama . " dengan alasan: " . $request->input('alasan');
        $userNotif->save();

        return redirect()->back()->with('success', 'Berhasil mengeluarkan bendahara!');
    }



}
