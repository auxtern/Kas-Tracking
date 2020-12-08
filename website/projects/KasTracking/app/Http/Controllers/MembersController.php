<?php

namespace App\Http\Controllers;

use App\OrganisasiMembers;
use App\Organisasi;
use App\Helpers\Tools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class MembersController extends Controller
{
    
    /**
     * Periksa akses masuk anggota
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('members');
    }

    
    public function dashboard(Request $request){

        $data['cmember'] = OrganisasiMembers::where('member_id',  Cookie::get('member_id'))->get()->first();
        $data['organisasi'] = Organisasi::where('organisasi_id',  $data['cmember']->organisasi_id)->get()->first();
       
        $data['url_foto'] = Tools::ambilFotoProfil("", $data['cmember']->jenis_kelamin);
        $data['status'] = "Anggota";

        return view('member.dashboard', $data);
    }

    public function tracking(Request $request){

        $data['cmember'] = OrganisasiMembers::where('member_id',  Cookie::get('member_id'))->get()->first();
        $data['organisasi'] = Organisasi::where('organisasi_id',  $data['cmember']->organisasi_id)->get()->first();
       
        $data['url_foto'] = Tools::ambilFotoProfil("", $data['cmember']->jenis_kelamin);
        $data['status'] = "Anggota";

        return view('member.tracking', $data);
    }

}
