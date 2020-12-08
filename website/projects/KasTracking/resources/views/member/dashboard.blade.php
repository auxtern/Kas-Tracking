@extends('layouts.app-member')


@section('title')
    {{ config('app.name', 'Kas Tracking') }} - Dasbor Organisasi
@endsection


@section('header')
    <!--Page header-->
    <div class="page-header">
      <div class="page-leftheader">
        <h4 class="page-title mb-0">{{ $organisasi->nama }}</h4>
        <ol class="breadcrumb">
          <li class="breadcrumb-item active" aria-current="page">
            <a href="{{ route('organisasi') }}"><i class="fa fa-layer-group mr-2 fs-14"></i>Organisasi</a>
          </li>
          <li class="breadcrumb-item" aria-current="page">
            <span>Dasbor</span>
          </li>
        </ol>
      </div>
    </div>
    <!--End Page header-->
@endsection

@section('content')

    <!-- Row-1 -->
    <div class="row">

      @php
        $mPemasukan = App\OrganisasiTracking::where('organisasi_id', $organisasi->organisasi_id)->where('kategori', 'Pemasukan')->sum('nominal');

        $mPengeluaran = App\OrganisasiTracking::where('organisasi_id', $organisasi->organisasi_id)->where('kategori', 'Pengeluaran')->sum('nominal');

        $nPemasukan = App\Helpers\Tools::formatRupiah($mPemasukan);
        $nPengeluaran = App\Helpers\Tools::formatRupiah($mPengeluaran);
        $nSisa = App\Helpers\Tools::formatRupiah($mPemasukan - $mPengeluaran);
      @endphp
      
      <div class="col-xl-3 col-lg-6 col-md-6 col-xm-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Total Pemasukan</h3>
          </div>
          <div class="card-body">
            <h4 class="mb-1 number-font text-success">{{ $nPemasukan }}</h4>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-lg-6 col-md-6 col-xm-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Total Pengeluaran</h3>
          </div>
          <div class="card-body">
            <h4 class="mb-1 number-font text-danger">{{ $nPengeluaran }}</h4>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-lg-6 col-md-6 col-xm-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Sisa Dana Tersimpan</h3>
          </div>
          <div class="card-body">
            <h4 class="mb-1 number-font text-info">
                {{ $nSisa }}
            </h4>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-lg-6 col-md-6 col-xm-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Total Anggota</h3>
          </div>
          <div class="card-body">
            <h4 class="mb-1 number-font text-info">
              {{ App\OrganisasiMembers::where('organisasi_id', $organisasi->organisasi_id)->get()->count() }}
            </h4>
          </div>
        </div>
      </div>

    </div>
    <!-- End Row-1 -->

    <!-- Row-2 -->
    <div class="row">
      <div class="col-xl-8 col-lg-8 col-md-12 col-nm">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Analisa Keuangan Bulanan</h3>
          </div>
          <div class="card-body">

            @php
              $bulanSekarang = date("m");
              $tahunSekarang = date("Y");

              $nPemasukanBulanan = App\Helpers\Tools::trackingBulanan($organisasi->organisasi_id, $bulanSekarang, $tahunSekarang, "Pemasukan");

              $nPengeluaranBulanan = App\Helpers\Tools::trackingBulanan($organisasi->organisasi_id, $bulanSekarang, $tahunSekarang, "Pengeluaran");


              $arrReports['bulan'] = "";
              $arrReports['pemasukan'] = "";
              $arrReports['pengeluaran'] = "";

              for($i=11; $i>=0; $i--){
                $inBulan = date('m', strtotime("-$i month"));
                $inTahun = date('Y', strtotime("-$i month"));

                $split = "";
                if($i != 11) $split = ",";

                $arrReports['bulan'] .= $split . "'" . date('M', strtotime("-$i month")). "'";
              
                $arrReports['pemasukan'] .=  $split . "'" . App\Helpers\Tools::trackingBulanan($organisasi->organisasi_id, $inBulan, $inTahun, "Pemasukan"). "'";
              
                $arrReports['pengeluaran'] .= $split . "'" . App\Helpers\Tools::trackingBulanan($organisasi->organisasi_id, $inBulan, $inTahun, "Pengeluaran"). "'";
              }
            @endphp

            <h5 class="text-muted"><em>Laporan Bulanan ini</em></h5>
            <div class="row mb-4">
              <div class="col-xl-5 col-6">
                <p class="mb-1">Pemasukan</p>
                <h3 class="mb-0 fs-20 number-font1 text-success">
                  {{ App\Helpers\Tools::formatRupiah($nPemasukanBulanan) }}
                </h3>
              </div>

              <div class="col-xl-5 col-6">
                <p class="mb-1">Pengeluaran</p>
                <h3 class="mb-0 fs-20 number-font1 text-danger">
                  {{ App\Helpers\Tools::formatRupiah($nPengeluaranBulanan) }}
                </h3>
              </div>
            </div>
            
            <h5 class="text-muted"><em>Laporan Bulanan</em></h5>

            <div id="echartReports" class="chart-tasks chart-dropshadow text-center" style="max-height: 500px;"></div>
            
            <div class="text-center mt-2">
              <span class="mr-4"><span class="dot-label bg-success"></span>Pemasukan</span>
              <span><span class="dot-label bg-danger"></span>Pengeluaran</span>
            </div>

          </div>

        </div>
      </div>

      <div class="col-xl-4 col-lg-4 col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Aktivitas Terbaru</h3>
          </div>

          <div class="card-body">
            <div class="latest-timeline scrollbar3" id="scrollbar3">
              <ul class="timeline mb-0">
                @php
                    $dataLogs = App\OrganisasiLogs::where('organisasi_id', $organisasi->organisasi_id)->orderBy('log_id', 'desc')->take(100)->get(); 
                @endphp
                @foreach ($dataLogs as $log)
                  <li class="mt-0">
                    <div class="d-flex">
                      <span class="time-data">{{ App\Helpers\Tools::tanggalHariIndonesia($log->created_at) }}</span>
                      </span>
                    </div>
                    <p class="text-muted fs-12">
                        <span class="text-success">
                          ({{ App\User::select('nama')->where('id', $log->user_id)->get()->first()->nama }})
                        </span>
                        {{ $log->pesan }}
                    </p>
                  </li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
      </div>

    </div>
    <!-- End Row-2 -->
@endsection

@section('internalCSS')
   <link rel="stylesheet" href="{{ asset('css/main/org-dasbor.css') }}">
@endsection

@section('internalJS')
  <script src="{{ asset('js/main/theme1.js') }}"></script>
  <script>
    var dataX = [<?=$arrReports['bulan']?>];
    var dataPemasukan = [<?=$arrReports['pemasukan']?>];
    var dataPengeluaran = [<?=$arrReports['pengeluaran']?>];
    reportChart(dataX, dataPemasukan, dataPengeluaran, "echartReports");
  </script>
@endsection