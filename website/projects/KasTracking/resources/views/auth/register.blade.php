@extends('layouts.app-login')

@section('title')
{{ config('app.name', 'Kas Tracking') }} - Daftar
@endsection

@section('content')
<div class="form-content">
    <div class="form-items">
        <a href="{{ route('login') }}" class="d-flex align-items-center text-decoration-none">
            <img  class="mr-3" src="{{ asset('img/kas-tracking.png') }}" style="width: 76px;" alt="">
            <h2 class="text-white">{{ config('app.name', 'Kas Tracking') }}</h2>
        </a>
        <div class="page-links">
            <a href="{{ route('login') }}">{{ __('Masuk') }}</a>
            <a href="{{ route('register') }}" class="active">{{ __('Daftar') }}</a>
        </div>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <div class="form-group">
                <span>Nama Lengkap</span><br>
                <input class="form-control{{ $errors->has('nama') ? ' is-invalid' : '' }} mb-0" type="text" name="nama" placeholder="" value="{{ old('nama') }}" required>
                @if ($errors->has('nama'))
                    <span class="text-danger" role="alert">
                        <strong>{{ $errors->first('nama') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <span>Tanggal Lahir</span><br>
                <input class="form-control{{ $errors->has('tanggal_lahir') ? ' is-invalid' : '' }} mb-0" type="date" name="tanggal_lahir" placeholder="" value="{{ old('tanggal_lahir') }}"  required>
                @if ($errors->has('tanggal_lahir'))
                    <span class="text-danger" role="alert">
                        <strong>{{ $errors->first('tanggal_lahir') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <span>Jenis Kelamin</span><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input{{ $errors->has('jenis_kelamin') ? ' is-invalid' : '' }}" type="radio" name="jenis_kelamin" id="jk_lakilaki" value="Laki-Laki" required>
                    <label class="form-check-label" for="jk_lakilaki">Laki-Laki</label>
                </div>
                    <div class="form-check form-check-inline">
                    <input class="form-check-input{{ $errors->has('jenis_kelamin') ? ' is-invalid' : '' }}" type="radio" name="jenis_kelamin" id="jk_perempuan" value="Perempuan" required>
                    <label class="form-check-label" for="jk_perempuan">Perempuan</label>
                </div>
                @if ($errors->has('jenis_kelamin'))
                    <span class="text-danger" role="alert">
                        <strong>{{ $errors->first('jenis_kelamin') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <span>Provinsi Tempat Tinggal</span><br>
                <select class="form-control{{ $errors->has('provinsi') ? ' is-invalid' : '' }} mb-0" name="provinsi" required>
                    <option value="" disabled selected></option>
                    @foreach (json_decode(file_get_contents('json/provinsi.json'), true) as $prov)
                        <option value="{{ $prov['nama'] }}">{{ $prov['nama'] }}</option>
                    @endforeach
                </select>
                @if ($errors->has('provinsi'))
                    <span class="text-danger" role="alert">
                        <strong>{{ $errors->first('provinsi') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <span>Nomor Whatsapp</span><br>
                <input class="form-control{{ $errors->has('whatsapp') ? ' is-invalid' : '' }} mb-0" type="number" name="whatsapp" placeholder="" value="{{ old('whatsapp') }}" required>
                @if ($errors->has('whatsapp'))
                    <span class="text-danger" role="alert">
                        <strong>{{ $errors->first('whatsapp') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <span>Alamat Email</span><br>
                <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} mb-0" type="email" name="email" placeholder="email" value="{{ old('email') }}" required>
                @if ($errors->has('email'))
                    <span class="text-danger" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <span>Kata Sandi</span><br>
                <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} mb-0" type="password" name="password" placeholder="" value="{{ old('password') }}" required>
                @if ($errors->has('password'))
                    <span class="text-danger" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <span>Ulangi Kata Sandi</span><br>
                <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} mb-0" type="password" name="password_confirmation" placeholder="" required>
            </div>

            <span class="text-white"> <i class="fa fa-check mr-3"></i>Dengan mendaftar kamu setuju dengan Ketentuan dan Kebijakan Privasi, Kas Tracking.</span><br>
           
            <div class="form-button">
                <button id="submit" type="submit" class="ibtn">{{ __('Daftar') }}</button>
            </div>
        </form>
    </div>
</div>
@endsection
