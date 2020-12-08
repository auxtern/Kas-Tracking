<?php

namespace App\Helpers;
use App\OrganisasiTracking;

class Tools
{

    public static function formatRupiah($nominal){

        return "Rp" . number_format((int)$nominal, 0, ',', '.') . ",00";
    }

    public static function trackingBulanan($organisasi_id, $bulan, $tahun, $kategori){
        $jumlah = OrganisasiTracking::where('organisasi_id', $organisasi_id)->where('kategori', $kategori)->whereRaw('extract(month from updated_at) = ?', $bulan)->whereRaw('extract(year from updated_at) = ?', $tahun)->sum('nominal');

        return $jumlah;
    }
    
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



