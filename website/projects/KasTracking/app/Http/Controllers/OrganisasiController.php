<?php

namespace App\Http\Controllers;

use App\Helpers\Tools;
use App\Organisasi;
use App\User;
use App\OrganisasiUsers;
use App\OrganisasiMembers;
use App\OrganisasiLogs;
use App\OrganisasiTracking;
use App\UsersNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
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

        $data['org_members'] = OrganisasiMembers::where('organisasi_id', $organisasi_id)->get();

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


    // ================================================================
    // POST HENDLER
    // ================================================================

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
            'jenis_iuran' => 'required',
            'status_iuran' => 'required',
            'jumlah_iuran' => 'required|min:0',
        ]);

        // Ambil data user yang login
        $user = Auth::user();

        // Buat data baru
        $organisasi = new Organisasi();
        $organisasi->user_id = $user->id;
        $organisasi->nama = strip_tags($request->input('nama'));
        $organisasi->lokasi = strip_tags($request->input('lokasi'));
        $organisasi->jenis_iuran = strip_tags($request->input('jenis_iuran'));
        $organisasi->status_iuran = strip_tags($request->input('status_iuran'));
        $organisasi->jumlah_iuran = strip_tags($request->input('jumlah_iuran'));
        // $organisasi->token = bin2hex(random_bytes(32));
        $organisasi->save();

        // Tambahkan user pembuat ke organisasi members
        $orgUsers = new OrganisasiUsers();
        $orgUsers->user_id = $user->id;
        $orgUsers->organisasi_id = $organisasi->organisasi_id;
        $orgUsers->save();

        // Tambahkan log organisasi
        $orgUsers = new OrganisasiLogs();
        $orgUsers->user_id = $user->id;
        $orgUsers->organisasi_id = $organisasi->organisasi_id;
        $orgUsers->pesan = "Organisasi " . $organisasi->nama . " dibuat.";
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
            'jenis_iuran' => 'required',
            'status_iuran' => 'required',
            'jumlah_iuran' => 'required|min:0',
        ]);

        // Ambil data user yang login
        $user = Auth::user();

        $organisasi = Organisasi::where('user_id', $user->id)->where('organisasi_id', $request->input('organisasi_id'))->get()->first();

        if(!$organisasi){
            return redirect()->back()->with('error', 'Gagal menyimpan perubahan!');
        }

        // perbarui data baru
        $organisasi->nama = strip_tags($request->input('nama'));
        $organisasi->lokasi = strip_tags($request->input('lokasi'));
        $organisasi->jenis_iuran = strip_tags($request->input('jenis_iuran'));
        $organisasi->status_iuran = strip_tags($request->input('status_iuran'));
        $organisasi->jumlah_iuran = strip_tags($request->input('jumlah_iuran'));
        // $organisasi->token = bin2hex(random_bytes(32));
        $organisasi->save();


        // Tambahkan notifikasi
        $orgLogs = new OrganisasiLogs();
        $orgLogs->user_id = $user->id;
        $orgLogs->organisasi_id = $organisasi->organisasi_id;
        $orgLogs->pesan = "memperbarui data organisasi: " . $organisasi->nama .".";
        $orgLogs->save();

        return redirect()->back()->with('success', 'Berhasil menyimpan perubahan!');
    }

    /**
     * Mengubah bendahara utama
     *
     * @return \Illuminate\Http\Response
     */
    public function change(Request $request)
    {

        $this->validate($request, [
            'user_id' => 'required',
            'password' => 'required',
        ]);

        // Ambil data user yang login
        $user = Auth::user();

        $newBendahara = User::where('id', $request->input('user_id'))->get()->first();
        if(!$newBendahara){
            return redirect()->back()->with('error', 'Pengguna tidak terdaftar!');
        }

      
        if(!Hash::check($request->input('password'), $user->password)){
            return redirect()->back()->with('error', 'Kata sandi tidak benar!');
        }

        $organisasi = Organisasi::where('user_id', $user->id)->where('organisasi_id', $request->input('organisasi_id'))->get()->first();

        if(!$organisasi){
            return redirect()->back()->with('error', 'Gagal menyimpan perubahan!');
        }

        $inOrg = OrganisasiUsers::where('organisasi_id', $organisasi->organisasi_id)->where('user_id', $request->input('user_id'))->get()->first();

        if(!$inOrg){
            return redirect()->back()->with('error', 'Pengguna tidak terdaftar sebagai asisten bendahara di organisasi ini!');
        }

        // perbarui data baru
        $organisasi->user_id = strip_tags($request->input('user_id'));
        // $organisasi->token = bin2hex(random_bytes(32));
        $organisasi->save();


        // Tambahkan notifikasi
        $userNotif = new UsersNotification();
        $userNotif->user_id = $user->id;
        $userNotif->pesan = $user->nama . " menyerahkan jabatan bendahara utama organisasi ". $organisasi->nama ." kepada kamu.";
        $userNotif->save();

        // Tambahkan notifikasi
        $orgLogs = new OrganisasiLogs();
        $orgLogs->user_id = $user->id;
        $orgLogs->organisasi_id = $organisasi->organisasi_id;
        $orgLogs->pesan = "menyerahkan jabatan bendahara utama kepada: " . $newBendahara->nama .".";
        $orgLogs->save();

        return redirect('organisasi/manage/' . $organisasi->organisasi_id)->with('success', 'Berhasil menyimpan perubahan!');
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

        $orgLogs = new OrganisasiLogs();
        $orgLogs->user_id = $user->id;
        $orgLogs->organisasi_id = $organisasi_id;
        $orgLogs->pesan = "menambahkan asisten bendahara baru dengan nama: " . $userAdd->nama;
        $orgLogs->save();

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

        // Alihkan data pembuat anggota ke bendahara utama
        DB::select('update organisasi_members SET user_id = ? where user_id = ? and organisasi_id = ?', [$user->id, $request->input('user_id'), $organisasi_id]);

        // Alihkan data pembuat anggota ke bendahara utama
        DB::select('update organisasi_tracking SET user_id = ? where user_id = ? and organisasi_id = ?', [$user->id, $request->input('user_id'), $organisasi_id]);

        DB::select('delete from organisasi_users where user_id = ? and organisasi_id = ?', [$request->input('user_id'), $organisasi_id]);

        $userNotif = new UsersNotification();
        $userNotif->user_id = $request->input('user_id');
        $userNotif->pesan = $user->nama . " mengeluarkan kamu dari organisasi " . $organisasi->nama . " dengan alasan: " . $request->input('alasan');
        $userNotif->save();

        $orgLogs = new OrganisasiLogs();
        $orgLogs->user_id = $user->id;
        $orgLogs->organisasi_id = $organisasi_id;
        $orgLogs->pesan = "mencopot jabatan asisten bendahara untuk: " . $userAdd->nama;
        $orgLogs->save();

        return redirect()->back()->with('success', 'Berhasil mengeluarkan bendahara!');
    }


        /**
     * Menambahkan data organisasi ke database
     *
     * @return \Illuminate\Http\Response
     */
    public function members(Request $request, $organisasi_id)
    {
        // Ambil data user yang login
        $user = Auth::user();

        // Ambil data organisasi
        $organisasi = Organisasi::where('organisasi_id', $organisasi_id)->get()->first();


        if(!$organisasi){
            return redirect()->back()->with('error', 'Organisasi tidak ditemukan!');
        }


        $validator = Validator::make($request->all(), [
            'member_id' => 'required|string|min:1|max:200',
            'nama' => 'required|string|min:6|max:150',
            'jenis_kelamin' => 'required',
            'tipe_pembayaran' => 'required',
            'whatsapp' => 'nullable|unique:organisasi_members',
            'email' => 'nullable|unique:organisasi_members',
            'keys' => 'required|string|min:6|max:20',
        ]);

        if ($validator->fails()){
            return redirect()->back()->with('error', 'Data anggota yang akan ditambahkan tidak valid!');
        }

        $userInOrg = OrganisasiUsers::where('user_id', $user->id)->where('organisasi_id', $organisasi_id)->get()->first();
        if(!$userInOrg){
            return redirect()->back()->with('error', 'Kamu tidak memiliki akses untuk organisasi ini!');
        }

        // Tambahkan user pembuat ke organisasi members
        $orgMembers = new OrganisasiMembers();
        $orgMembers->member_id = "m" . $organisasi_id . "_" . $request->input('member_id');
        $orgMembers->user_id = $user->id;
        $orgMembers->organisasi_id = $organisasi_id;
        $orgMembers->nama = $request->input('nama');
        $orgMembers->jenis_kelamin = $request->input('jenis_kelamin');
        $orgMembers->tipe_pembayaran = $request->input('tipe_pembayaran');
        if($request->input('whatsapp') != ""){
            $orgMembers->whatsapp = $request->input('whatsapp');
        }
        if($request->input('email') != ""){
            $orgMembers->email = $request->input('email');
        }
        $orgMembers->keys = $request->input('keys');
        $orgMembers->save();

        $orgLogs = new OrganisasiLogs();
        $orgLogs->user_id = $user->id;
        $orgLogs->organisasi_id = $organisasi_id;
        $orgLogs->pesan = "menambahkan anggota baru dengan nama: " . $request->input('nama');
        $orgLogs->save();

        return redirect()->back()->with('success', 'Berhasil menambahkan anggota!');
    }


    public function membersUpdate(Request $request, $organisasi_id)
    {
        // Ambil data user yang login
        $user = Auth::user();

        // Ambil data organisasi
        $organisasi = Organisasi::where('organisasi_id', $organisasi_id)->get()->first();


        if(!$organisasi){
            return redirect()->back()->with('error', 'Organisasi tidak ditemukan!');
        }

        $member_id = $request->input('member_id');

        $validator = Validator::make($request->all(), [
            'member_id' => 'required|string|min:1|max:200',
            'nama' => 'required|string|min:6|max:150',
            'jenis_kelamin' => 'required',
            'tipe_pembayaran' => 'required',
            'whatsapp' => 'nullable|unique:organisasi_members,whatsapp,'.$member_id . ',member_id',
            'email' => 'nullable|unique:organisasi_members,email,'. $member_id . ',member_id',
            'keys' => 'required|string|min:6|max:20',
        ]);

        if ($validator->fails()){
            return redirect()->back()->with('error', 'Data anggota yang akan diperbarui tidak valid!');
        }

        $userInOrg = OrganisasiUsers::where('user_id', $user->id)->where('organisasi_id', $organisasi_id)->get()->first();
        if(!$userInOrg){
            return redirect()->back()->with('error', 'Kamu tidak memiliki akses untuk organisasi ini!');
        }

        // Tambahkan user pembuat ke organisasi members
        $orgMembers = OrganisasiMembers::where('member_id', $request->input('member_id'))->where('organisasi_id', $organisasi_id)->get()->first();

        if(!$orgMembers){
            return redirect()->back()->with('error', 'Anggota tidak terdaftar di organisasi ini!');
        }

        $orgMembers->nama = $request->input('nama');
        $orgMembers->jenis_kelamin = $request->input('jenis_kelamin');
        $orgMembers->tipe_pembayaran = $request->input('tipe_pembayaran');
        if($request->input('whatsapp') != ""){
            $orgMembers->whatsapp = $request->input('whatsapp');
        }
        if($request->input('email') != ""){
            $orgMembers->email = $request->input('email');
        }
        $orgMembers->keys = $request->input('keys');
        $orgMembers->save();


        $orgLogs = new OrganisasiLogs();
        $orgLogs->user_id = $user->id;
        $orgLogs->organisasi_id = $organisasi_id;
        $orgLogs->pesan = "memperbarui data anggota dengan nama: " . $request->input('nama');
        $orgLogs->save();

        return redirect()->back()->with('success', 'Berhasil memperbarui data anggota!');
    }


            /**
     * Menambahkan data tracking ke database
     *
     * @return \Illuminate\Http\Response
     */
    public function trackingAdd(Request $request, $organisasi_id)
    {
        // Ambil data user yang login
        $user = Auth::user();

        // Ambil data organisasi
        $organisasi = Organisasi::where('organisasi_id', $organisasi_id)->get()->first();


        if(!$organisasi){
            return redirect()->back()->with('error', 'Organisasi tidak ditemukan!');
        }


        $validator = Validator::make($request->all(), [
            'member_id' => 'required',
            'kategori' => 'required',
        ]);

        if ($validator->fails()){
            return redirect()->back()->with('error', 'Data yang dikirimkan tidak valid!');
        }

        $userInOrg = OrganisasiUsers::where('user_id', $user->id)->where('organisasi_id', $organisasi_id)->get()->first();
        if(!$userInOrg){
            return redirect()->back()->with('error', 'Kamu tidak memiliki akses untuk organisasi ini!');
        }

        $memberInOrg = OrganisasiMembers::where('member_id', $request->input('member_id'))->where('organisasi_id', $organisasi_id)->get()->first();
        if(!$memberInOrg){
            return redirect()->back()->with('error', 'Anggota tidak terdaftar di organisasi ini!');
        }

        $orgTracking = new OrganisasiTracking();
        $orgTracking->user_id = $user->id;
        $orgTracking->organisasi_id = $organisasi_id;
        $orgTracking->member_id = $request->input('member_id');
        $orgTracking->kategori = $request->input('kategori');
        $orgTracking->nominal = $organisasi->jumlah_iuran;

        if($request->input('kategori') == "Pemasukan"){
            $catatan = "Iuran telah dibayarkan.";
        }else{
            $catatan = "Pembayaran iuran tertunggak.";
        }
        $orgTracking->catatan = $catatan;
        $orgTracking->save();


        $orgLogs = new OrganisasiLogs();
        $orgLogs->user_id = $user->id;
        $orgLogs->organisasi_id = $organisasi_id;
        if($request->input('kategori') == "Pemasukan"){
            $pesan = "menerima pembayaran iuran sebesar ". $organisasi->jumlah_iuran ." dari anggota: ". $memberInOrg->nama .".";
        }else{
            $pesan = "menandai, pembayaran iuran tertunggak sebesar ". $organisasi->jumlah_iuran ." untuk anggota: ". $memberInOrg->nama .".";
        }
        $orgLogs->pesan = $pesan;
        $orgLogs->save();

        return redirect()->back()->with('success', 'Berhasil menyimpan data!');
    }


            /**
     * Menambahkan data tracking ke database
     *
     * @return \Illuminate\Http\Response
     */
    public function trackingAddc(Request $request, $organisasi_id)
    {
        // Ambil data user yang login
        $user = Auth::user();

        // Ambil data organisasi
        $organisasi = Organisasi::where('organisasi_id', $organisasi_id)->get()->first();


        if(!$organisasi){
            return redirect()->back()->with('error', 'Organisasi tidak ditemukan!');
        }


        $validator = Validator::make($request->all(), [
            'member_id' => 'required',
            'kategori' => 'required',
            'nominal' => 'required|min:0',
            'catatan' => 'required',
        ]);

        if ($validator->fails()){
            return redirect()->back()->with('error', 'Data yang dikirimkan tidak valid!');
        }

        $userInOrg = OrganisasiUsers::where('user_id', $user->id)->where('organisasi_id', $organisasi_id)->get()->first();
        if(!$userInOrg){
            return redirect()->back()->with('error', 'Kamu tidak memiliki akses untuk organisasi ini!');
        }

        $memberInOrg = OrganisasiMembers::where('member_id', $request->input('member_id'))->where('organisasi_id', $organisasi_id)->get()->first();
        if(!$memberInOrg){
            return redirect()->back()->with('error', 'Anggota tidak terdaftar di organisasi ini!');
        }

        $orgTracking = new OrganisasiTracking();
        $orgTracking->user_id = $user->id;
        $orgTracking->organisasi_id = $organisasi_id;
        $orgTracking->member_id = $request->input('member_id');
        $orgTracking->kategori = $request->input('kategori');
        $orgTracking->nominal = $request->input('nominal');
        $orgTracking->catatan = $request->input('catatan');
        $orgTracking->save();

        $orgLogs = new OrganisasiLogs();
        $orgLogs->user_id = $user->id;
        $orgLogs->organisasi_id = $organisasi_id;

        if($request->input('kategori') == "Pengeluaran"){
            $orgLogs->pesan = "menambahkan catatan ". $request->input('kategori') ." keuangan dengan nominal ". Tools::formatRupiah($request->input('nominal')) ." dan catatan: " . $request->input('catatan');
        }else{
            $orgLogs->pesan = "menambahkan catatan ". $request->input('kategori') ." keuangan dari anggota ".  $memberInOrg->nama ." dengan nominal ". Tools::formatRupiah($request->input('nominal')) ." dan catatan: " . $request->input('catatan');
        }

        $orgLogs->save();

        return redirect()->back()->with('success', 'Berhasil menyimpan data!');
    }


    /**
     * Mengubah data tracking ke database
     *
     * @return \Illuminate\Http\Response
     */
    public function trackingUpdatec(Request $request, $organisasi_id)
    {
        // Ambil data user yang login
        $user = Auth::user();

        // Ambil data organisasi
        $organisasi = Organisasi::where('organisasi_id', $organisasi_id)->get()->first();


        if(!$organisasi){
            return redirect()->back()->with('error', 'Organisasi tidak ditemukan!');
        }


        $validator = Validator::make($request->all(), [
            'tracking_id' => 'required',
            'kategori' => 'required',
            'nominal' => 'required|min:0',
            'catatan' => 'required',
        ]);

        if ($validator->fails()){
            return redirect()->back()->with('error', 'Data yang dikirimkan tidak valid!');
        }

        $userInOrg = OrganisasiUsers::where('user_id', $user->id)->where('organisasi_id', $organisasi_id)->get()->first();
        if(!$userInOrg){
            return redirect()->back()->with('error', 'Kamu tidak memiliki akses untuk organisasi ini!');
        }

        $memberInOrg = OrganisasiMembers::where('tracking_id', $request->input('tracking_id'))->where('organisasi_id', $organisasi_id)->get()->first();
        if(!$memberInOrg){
            return redirect()->back()->with('error', 'Anggota tidak terdaftar di organisasi ini!');
        }

        $orgTracking = OrganisasiTracking::where('tracking_id', $request->input('tracking_id'))->get()->first();
        $orgTracking->kategori = $request->input('kategori');
        $orgTracking->nominal = $request->input('nominal');
        $orgTracking->catatan = $request->input('catatan');
        $orgTracking->save();

        $orgLogs = new OrganisasiLogs();
        $orgLogs->user_id = $user->id;
        $orgLogs->organisasi_id = $organisasi_id;

        if($request->input('kategori') == "Pengeluaran"){
            $orgLogs->pesan = "memperbarui catatan ". $request->input('kategori') ." keuangan dengan nominal ". Tools::formatRupiah($request->input('nominal')) ." dan catatan: " . $request->input('catatan');
        }else{
            $orgLogs->pesan = "memperbarui catatan ". $request->input('kategori') ." keuangan dari anggota ".  $memberInOrg->nama ." dengan nominal ". Tools::formatRupiah($request->input('nominal')) ." dan catatan: " . $request->input('catatan');
        }


        $orgLogs->save();

        return redirect()->back()->with('success', 'Berhasil memperbarui data!');
    }


}
