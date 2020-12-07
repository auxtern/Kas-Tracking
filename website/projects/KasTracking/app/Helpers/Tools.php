<?php

namespace App\Helpers;

class Tools
{

    
    public static function tanggalHariIndonesia($value)
    {
        \Carbon\Carbon::setLocale('id');
        return \Carbon\Carbon::parse($value)->format('l, d F Y');
        // return \Carbon\Carbon::now()->translatedFormat('l j F Y H:i:s');
    }


    public static function ambilFotoProfil($foto, $jenis_kelamin){
        if($foto){
            return $foto;
        }else if($jenis_kelamin == "Laki-Laki"){
            return asset('svg/man.svg');
        }else if($jenis_kelamin == "Perempuan"){
            return asset('svg/woman.svg');
        }else{
            return asset('img/kas-tracking.png');
        }
    }

    public static function ambilStatus($role){
        switch($role){
            case 99: return "Admin";
            case 90: return "Bendahara";
            case 1: return "Anggota";
            case 0: return "-";
        }
    }

}



