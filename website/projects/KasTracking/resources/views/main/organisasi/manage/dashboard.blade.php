@extends('layouts.app-main')

@section('title')
{{ config('app.name', 'Kas Tracking') }} - Dasbor Organisasi
@endsection

@section('side-menu')
  <li class="side-item side-item-category mt-4">Menu Organisasi</li>

  <li class="slide">
    <a class="side-menu__item ative" href="{{ route('organisasi/manage', ['organisasi_id'=>$organisasi['organisasi_id']]) }}">
    <i data-feather="grid" class="side-menu__icon"></i>
        <span class="side-menu__label">Dasbor</span>
    </a>
  </li>

    <li class="slide">
      <a class="side-menu__item bg-white" href="{{ route('organisasi/manage/users', ['organisasi_id'=>$organisasi['organisasi_id']]) }}">
      <i data-feather="star" class="side-menu__icon"></i>
          <span class="side-menu__label">Bendahara</span>
          <span class="badge badge-success side-badge">@yield('nUsers')</span>
      </a>
    </li>

  

  <li class="slide">
    <a class="side-menu__item bg-white" href="{{ route('organisasi/manage/members', ['organisasi_id'=>$organisasi['organisasi_id']]) }}">
    <i data-feather="users" class="side-menu__icon"></i>
        <span class="side-menu__label">Anggota</span>
        <span class="badge badge-success side-badge">@yield('nMembers')</span>
    </a>
  </li>

  <li class="slide">
    <a class="side-menu__item bg-white" href="{{ route('organisasi/manage/money', ['organisasi_id'=>$organisasi['organisasi_id']]) }}">
    <i data-feather="dollar-sign" class="side-menu__icon"></i>
        <span class="side-menu__label">Keuangan</span>
        <span class="badge badge-success side-badge">@yield('nMoney')</span>
    </a>
  </li>

  @if ($organisasi['user_id'] == Auth::user()->id)
  <li class="slide">
    <a class="side-menu__item bg-white" href="{{ route('organisasi/manage/settings', ['organisasi_id'=>$organisasi['organisasi_id']]) }}">
    <i data-feather="settings" class="side-menu__icon"></i>
        <span class="side-menu__label">Pengaturan</span>
    </a>
  </li>
  @endif

@endsection

@section('header')
    <!--Page header-->
    <div class="page-header">
      <div class="page-leftheader">
        <h4 class="page-title mb-0">{{ $organisasi['nama'] }}</h4>
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

      <div class="col-xl-3 col-lg-6 col-md-6 col-xm-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Total Pemasukan</h3>
          </div>
          <div class="card-body">
            <h4 class="mb-1 number-font text-success">Rp0,00</h4>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-lg-6 col-md-6 col-xm-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Total Pengeluaran</h3>
          </div>
          <div class="card-body">
            <h4 class="mb-1 number-font text-danger">Rp0,00</h4>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-lg-6 col-md-6 col-xm-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Sisa Dana Tersimpan</h3>
          </div>
          <div class="card-body">
            <h4 class="mb-1 number-font text-info">Rp0,00</h4>
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
              {{ App\OrganisasiMembers::where('organisasi_id', $organisasi['organisasi_id'])->get()->count() }}
            </h4>
          </div>
        </div>
      </div>

    </div>
    <!-- End Row-1 -->

    <!-- Row-2 -->
    <div class="row">
      <div class="col-xl-8 col-lg-8 col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Analisa Keuangan Bulanan</h3>
          </div>
          <div class="card-body">

            <h5 class="text-muted"><em>Laporan Bulan ini</em></h5>
            <div class="row mb-4">
              <div class="col-xl-3 col-6">
                <p class="mb-1">Pemasukan</p>
                <h3 class="mb-0 fs-20 number-font1 text-success">Rp0,00</h3>
              </div>

              <div class="col-xl-3 col-6">
                <p class="mb-1">Pengeluaran</p>
                <h3 class="mb-0 fs-20 number-font1 text-danger">Rp0,00</h3>
              </div>
            </div>

            <div id="echart1" class="chart-tasks chart-dropshadow text-center"></div>
            
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
                    $dataLogs = App\OrganisasiLogs::where('organisasi_id', $organisasi['organisasi_id'])->orderBy('log_id', 'desc')->take(100)->get(); 
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


@section('internalJS')
  <script src="{{ asset('js/main/theme1.js') }}"></script>
@endsection


