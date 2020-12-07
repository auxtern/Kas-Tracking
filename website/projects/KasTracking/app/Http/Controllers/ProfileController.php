<?php

namespace App\Http\Controllers;

use App\Organisasi;
use App\Helpers\Tools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        $data['url_foto'] = Tools::ambilFotoProfil($user->foto, $user->jenis_kelamin); 
        $data['status'] = Tools::ambilStatus($user->role);

        $data['organisasi'] = Organisasi::whereIn('organisasi_id', function($q) use ($user){
            $q->from('organisasi_users')->select('organisasi_id')->where('user_id', $user->id);
        })->get()->toArray();

        return view('main/profile/index', $data);
    }

    public function settings()
    {
        $data['url_foto'] = Tools::ambilFotoProfil(Auth::user()->foto, Auth::user()->jenis_kelamin); 
        $data['status'] = Tools::ambilStatus(Auth::user()->role);
        return view('main/profile/settings', $data);
    }


    // POST DATA
    // -------------------------------------------

    public function changePassword(Request $request)
    {

        $this->validate($request, [
            'new_password' => 'required|min:6|confirmed',
            'password' => 'required|min:6',
        ]);

        if(!Hash::check($request->input('password'), Auth::user()->password)){
            $v = Validator::make([], []);
            $v->getMessageBag()->add('password', 'Wrong old password!');
            return back()->withErrors($v)->withInput();
        }

        $user = Auth::user();
        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        DB::insert('insert into password_resets (email, token, created_at) values (?, ?, ?)', [$user->email, $user->remember_token, date("Y-m-d H:i:s")]);

        return back()->with('success', 'Kata Sandi berhasil diperbarui.');
    }

    public function changePictures(Request $request)
    {

        $this->validate($request, [
            'photo_profile' => 'required',
			'photo' => 'required',
        ]);
        
        
        $image_parts = explode(";base64,", $request->input('photo'));
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $file_name = 'img/profile/_'. Auth::user()->id .'_' . time() . '.' . $image_type;

        file_put_contents($file_name, $image_base64);

        // Storage::disk('public')->put($file_name, $image_base64);

        if(! file_exists($file_name)){
            return back()->with('error', 'Foto profile gagal diperbarui. ' . $file_name);
        }
        
        $base_url = url('/') . "/";
        $user = Auth::user();

        $lokasi_file_lama = str_replace($base_url, '',$user->foto);
        if(file_exists($lokasi_file_lama)){
            unlink($lokasi_file_lama);
        }
        
        $user->foto = $base_url . $file_name;
        $user->save();

        return back()->with('success', 'Foto profile berhasil diperbarui.');
    }

    public function changePersonal(Request $request)
    {

        $this->validate($request, [
            'nama' => 'required|string|max:150|min:6',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'provinsi' => 'required',
        ]);

    
        $user = Auth::user();
        $user->nama = $request->input('nama');
        $user->tanggal_lahir = $request->input('tanggal_lahir');
        $user->bio = $request->input('bio');
        $user->jenis_kelamin = $request->input('jenis_kelamin');
        $user->provinsi = $request->input('provinsi');
        $user->save();

       
        return back()->with('success', 'Data Diri berhasil diperbarui.');
    }


    public function changeContact(Request $request)
    {

        $user = Auth::user();

        $this->validate($request, [
            'whatsapp' => 'required|string|min:8|max:20|unique:users,whatsapp,' . $user->id,
            'email' => 'required|string|min:8|max:150|unique:users,email,' . $user->id,
            'cpassword' => 'required|min:6',
        ]);

        if(!Hash::check($request->input('cpassword'), Auth::user()->password)){
            $v = Validator::make([], []);
            $v->getMessageBag()->add('password', 'Wrong password confirmation!');
            return back()->withErrors($v)->withInput();
        }
    
        
        $user->whatsapp = $request->input('whatsapp');
        $user->email = $request->input('email');
        $user->save();

       
        return back()->with('success', 'Data Kontak berhasil diperbarui.');
    }


}
