@extends('layouts.app-main')

@section('title')
  {{ config('app.name', 'Kas Tracking') }} - Profile
@endsection

@section('internalCSS')
  <link href="{{ asset('../node_modules/dropify/dist/css/dropify.min.css') }}" rel="stylesheet"/>
  <link href="{{ asset('../node_modules/croppie/croppie.css') }}" rel="stylesheet"/>
@endsection

@section('header')
  @if (Session::get('success'))
  <div class="alert alert-success mt-4 mb-0" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <i class="fa fa-check-circle mr-2" aria-hidden="true"></i> 
      {{ Session::get('success') }}
  </div> 
  @elseif(Session::get('error'))
  <div class="alert alert-danger mt-4 mb-0" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>
      {{ Session::get('error') }}
  </div> 
  @endif

  <!--Page header-->
  <div class="page-header">
    <div class="page-leftheader">
      <h4 class="page-title mb-0">Hay, {{ Auth::user()->nama }}</h4>
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">
          <a href="{{ route('/') }}"><i class="fa fa-home mr-2 fs-14"></i>Halaman Utama</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
          <a href="{{ route('profile') }}">Profil</a>
        </li>
        <li class="breadcrumb-item">
          <span>Pengaturan</span>
        </li>
      </ol>
    </div>
    {{-- <div class="page-rightheader">
      <div class="btn btn-list">
        <a href="#" class="btn btn-info">
          <i class="fa fa-comments mr-1"></i> TJ
        </a>
      </div>
    </div> --}}
  </div>
  <!--End Page header-->
@endsection

@section('content')
  <div class="row">

  <div class="col-xl-3 col-lg-4">
    
    <div class="card box-widget widget-user">
      <form id="form_photo_profile" method="POST" action="{{ route('profile/change/pictures') }}">
        @csrf
        <div class="card-header">
          <div class="card-title">Ubah Foto Profile</div>
        </div>
        <div class="widget-user-image mx-auto mt-5">
          <img alt="" class="rounded-circle" src="{{ $url_foto }}">
        </div>

          @if ($errors->has('photo'))
            <div class="alert alert-danger mt-4 mb-0" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              {{ $errors->first('photo') }}
            </div>
          @endif

        <div class="card-body text-center pt-2">
          <input name="photo_profile" id="photo_profile" type="file" class="dropify" data-height="150px">
        </div>

        <input type="hidden" name="photo" id="photo">
      </form>
    </div>

    <div class="card">
      <form method="POST" action="{{ route('profile/change/password') }}">
        @csrf

        <div class="card-header">
          <div class="card-title">Ubah Kata Sandi</div>
        </div>

        <div class="card-body">
          <div class="form-group">
            <label class="form-label">Kata Sandi Baru</label>
            <input type="password" class="form-control{{ $errors->has('new_password') ? ' is-invalid' : '' }}" name="new_password" value="{{ old('new_password') }}">
            @if ($errors->has('new_password'))
            <span class="text-danger" role="alert">
                <strong>{{ $errors->first('new_password') }}</strong>
            </span>
            @endif
          </div>

          <div class="form-group">
            <label class="form-label">Konfirmasi Kata Sandi Baru</label>
            <input type="password" class="form-control{{ $errors->has('new_password') ? ' is-invalid' : '' }}" name="new_password_confirmation">

          </div>

          <div class="form-group">
            <label class="form-label">Konfirmasi Kata Sandi Lama</label>
            <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="{{ old('password') }}">
            @if ($errors->has('password'))
            <span class="text-danger" role="alert">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
            @endif
          </div>

        </div>
        <div class="card-footer text-center">
          <button type="submit" class="btn btn-info">Simpan Perubahan</button>
        </div>

      </form>
    </div>

  </div>

  <div class="col-xl-9 col-lg-8">
    
    <div class="card">
      <div class="card-header">
        <div class="card-title">Ubah Data Diri</div>
      </div>
      <div class="card-body">

        <form method="POST" action="{{ route('profile/change/personal') }}">
          @csrf

          <div class="row">

            <div class="col-sm-6 col-md-6">
              <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
              <input name="nama" type="text" class="form-control{{ $errors->has('nama') ? ' is-invalid' : '' }}" placeholder="Nama lengkap" value="{{ Auth::user()->nama }}">
              </div>
            </div>

            <div class="col-sm-6 col-md-6">
              <div class="form-group">
                <label class="form-label">Tanggal Lahir</label>
                <input name="tanggal_lahir" type="date" class="form-control{{ $errors->has('tanggal_lahir') ? ' is-invalid' : '' }}" placeholder="Tanggal lahir" value="{{ Auth::user()->tanggal_lahir }}">
              </div>
            </div>
            
            <div class="col-sm-12 col-md-12">
              <div class="form-group">
                <label class="form-label">Bio</label>
                <textarea name="bio" type="date" class="form-control{{ $errors->has('bio') ? ' is-invalid' : '' }}" rows="5">{{ Auth::user()->bio }}</textarea>
              </div>
            </div>

            <div class="col-sm-12 col-md-12">
              <div class="form-group ">
                <div class="form-label">Jenis Kelamin</div>
                <div class="form-check form-check-inline">
                  <label class="custom-control custom-radio mr-3" style="cursor: pointer;">
                    <input name="jenis_kelamin" type="radio" class="custom-control-input{{ $errors->has('jenis_kelamin') ? ' is-invalid' : '' }}"  id="jklk" value="Laki-Laki">
                    <span class="custom-control-label">Laki-Laki</span>
                  </label>
                  <label class="custom-control custom-radio" style="cursor: pointer;">
                    <input name="jenis_kelamin" type="radio" class="custom-control-input{{ $errors->has('jenis_kelamin') ? ' is-invalid' : '' }}" id="jkpr" value="Perempuan">
                    <span class="custom-control-label">Perempuan</span>
                  </label>
                </div>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label class="form-label">Provinsi Tempat Tinggal</label>
                <select name="provinsi" class="form-control{{ $errors->has('provinsi') ? ' is-invalid' : '' }}" name="provinsi" id="provinsi" required>
                  <option value="" disabled selected></option>
                  @foreach (json_decode(file_get_contents('json/provinsi.json'), true) as $prov)
                      <option value="{{ $prov['nama'] }}">{{ $prov['nama'] }}</option>
                  @endforeach
                </select>
              </div>
            </div>

          </div>

          <div class="card-footer text-right">
            <button type="submit" class="btn  btn-info">Simpan Perubahan</button>
          </div>

        </form>

      </div>
    </div>

    <div class="card">
      <div class="card-header">
        <div class="card-title">Ubah Data Kontak</div>
      </div>

      <div class="card-body">

        <form method="POST" action="{{ route('profile/change/contact') }}">
        @csrf
        
          <div class="row">

            <div class="col-sm-6 col-md-6">
              <div class="form-group">
                <label class="form-label">Nomor Whatsapp</label>
                <input type="number" class="form-control{{ $errors->has('whatsapp') ? ' is-invalid' : '' }}" placeholder="Nomor whatsapp" name="whatsapp" value="{{ Auth::user()->whatsapp }}">
              </div>
            </div>

            <div class="col-sm-6 col-md-6">
              <div class="form-group">
                <label class="form-label">Alamat Email</label>
                <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Alamat email" name="email" value="{{ Auth::user()->email }}">
              </div>
            </div>

            <div class="col-sm-12 col-md-12">
              <div class="form-group">
                <label class="form-label">Kata Sandi</label>
                <input type="password" class="form-control{{ $errors->has('cpassword') ? ' is-invalid' : '' }}" placeholder="Kata sandi" name="cpassword">
              </div>
            </div>

          </div>

          <div class="card-footer text-right">
            <button type="submit" class="btn  btn-info">Simpan Perubahan</button>
          </div>
  
        </form>
      </div>

    </div>
  </div>

  {{-- MODAL --}}
  <!-- Modal -->
  <div id="upload_modal" class="modal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ubah_photoLabel">Sesuaikan Photo Profil</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row justify-content-md-center">
            <div class="col-md-8 text-center">
              <div id="image_demo" style="width:350px; margin-top:30px"></div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-info pangkas_photo">Simpan Perubahan</button>
        </div>
      </div>
    </div>
  </div>
  {{-- END MODAL --}}
@endsection

@section('internalJS')
  <script src="{{ asset('../node_modules/dropify/dist/js/dropify.min.js') }}"></script>
  <script src="{{ asset('../node_modules/croppie/croppie.min.js') }}"></script>
  <script src="{{ asset('js/main/profile-settings.js') }}"></script>
  <script src="{{ asset('js/main/file-upload.js') }}"></script>
  <script>
    biodataSetValue('{{ Auth::user()->jenis_kelamin }}', '{{ Auth::user()->provinsi }}');
  </script>
@endsection