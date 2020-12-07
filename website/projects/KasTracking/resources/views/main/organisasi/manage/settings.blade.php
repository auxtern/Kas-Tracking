@extends('layouts.app-main')

@section('title')
{{ config('app.name', 'Kas Tracking') }} - Pengaturan Organisasi
@endsection

@section('side-menu')
  <li class="side-item side-item-category mt-4">Menu Organisasi</li>

  <li class="slide">
    <a class="side-menu__item bg-white" href="{{ route('organisasi/manage', ['organisasi_id'=>$organisasi['organisasi_id']]) }}">
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
    <a class="side-menu__item active" href="{{ route('organisasi/manage/settings', ['organisasi_id'=>$organisasi['organisasi_id']]) }}">
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
          <li class="breadcrumb-item active" aria-current="page">
            <a href="{{ route('organisasi/manage', ["organisasi_id"=>$organisasi['organisasi_id']]) }}">Dasbor</a>
          </li>
          <li class="breadcrumb-item" aria-current="page">
            <span>Pengaturan</span>
          </li>
        </ol>
      </div>
    </div>
    <!--End Page header-->
@endsection

@section('content')
<div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
  <div class="card">
    <div class="card-header">
      <h4 class="card-title">Perbarui Data</h4>
    </div>
    <div class="card-body">

      <form method="POST" action="{{ route('organisasi/update') }}" class="form-horizontal">
        @csrf
        
        <input name="organisasi_id" type="hidden" value="{{ $organisasi['organisasi_id'] }}">

        <div class="form-group row">
          <label for="nama" class="col-md-3 form-label">Nama</label>
          <div class="col-md-9">
            <input name="nama" type="text" class="form-control{{ $errors->has('nama') ? ' is-invalid' : '' }}" id="nama" placeholder="Nama organisasi..." value="{{ $organisasi['nama'] }}">
            @if ($errors->has('nama'))
            <span class="text-danger" role="alert">
                <strong>{{ $errors->first('nama') }}</strong>
            </span>
            @endif
          </div>
        </div>

        <div class="form-group row">
          <label for="lokasi" class="col-md-3 form-label">Lokasi</label>
          <div class="col-md-9">
            <input name="lokasi" type="text" class="form-control{{ $errors->has('lokasi') ? ' is-invalid' : '' }}" id="lokasi" placeholder="Lokasi organisasi..." value="{{ $organisasi['lokasi'] }}">
            @if ($errors->has('lokasi'))
            <span class="text-danger" role="alert">
                <strong>{{ $errors->first('lokasi') }}</strong>
            </span>
            @endif
          </div>
        </div>


        
        <div class="form-group row">
          <label for="jenis_iuran" class="col-md-3 form-label">Jenis Iuran</label>
          <div class="col-md-9">
            <select name="jenis_iuran" class="form-control{{ $errors->has('jenis_iuran') ? ' is-invalid' : '' }}" name="jenis_iuran" id="jenis_iuran" required>
              <option value="{{ $organisasi['jenis_iuran'] }}" selected>{{ $organisasi['jenis_iuran'] }}</option>
              <option value="Terkadang">Terkadang</option>
              <option value="Mingguan">Mingguan</option>
              <option value="Bulanan">Bulanan</option>
            </select>
          </div>
        </div>


        <div class="form-group row">
          <label class="col-md-3 form-label">Status Iuran</label>
          <div class="col-md-9">
            <div class="form-check form-check-inline">
              <label class="custom-control custom-radio mr-3" style="cursor: pointer;">
                <input name="status_iuran" type="radio" class="custom-control-input{{ $errors->has('status_iuran') ? ' is-invalid' : '' }}" {{ ($organisasi['status_iuran'] == 'Aktif') ? 'checked' : '' }} value="Aktif">
                <span class="custom-control-label">Aktif</span>
              </label>
              <label class="custom-control custom-radio" style="cursor: pointer;">
                <input name="status_iuran" type="radio" class="custom-control-input{{ $errors->has('status_iuran') ? ' is-invalid' : '' }}" {{ ($organisasi['status_iuran'] == 'Tidak Aktif') ? 'checked' : '' }} value="Tidak Aktif">
                <span class="custom-control-label">Tidak Aktif</span>
              </label>
            </div>
          </div>
        </div>


        <div class="form-group row">
          <label for="jumlah_iuran" class="col-md-3 form-label">Jumlah Iuran</label>
          <div class="col-md-9">
            <input name="jumlah_iuran" type="number" class="form-control{{ $errors->has('jumlah_iuran') ? ' is-invalid' : '' }}" id="jumlah_iuran" placeholder="Jumlah iuran organisasi..." value="{{ $organisasi['jumlah_iuran'] }}">
            @if ($errors->has('jumlah_iuran'))
            <span class="text-danger" role="alert">
                <strong>{{ $errors->first('jumlah_iuran') }}</strong>
            </span>
            @endif
          </div>
        </div>

        <div class="text-right">
            <button type="submit" class="btn btn-info">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection


@section('internalJS')
  @if (Session::has('success'))
  <script>
    $.growl.notice({
      title: "Sukses",
      message: "{{ Session::get('success')}}"
    });
</script>
  @endif
@endsection


