@extends('layouts.app-login')

@section('content')
<div class="form-content">
@if (session('status'))
    <div class="form-sent show-it">
        <div class="tick-holder">
            <div class="tick-icon"></div>
        </div>
        <h3>Link Reset Berhasil Terkirim</h3>
        <p>Periksa inbox email kamu, untuk melakukan pengaturan ulang kata sandi!</p>

        <a href="{{ route('login') }}">Kembali ke halaman utama</a>
    </div>
@else
    <div class="form-items">
        <a href="{{ route('login') }}" class="d-flex align-items-center text-decoration-none">
            <img  class="mr-3" src="{{ asset('img/kas-tracking.png') }}" style="width: 76px;" alt="">
            <h2 class="text-white">{{ config('app.name', 'Kas Tracking') }}</h2>
        </a>
        <h3>Reset Kata Sandi</h3>
        <p class="mb-3">Untuk mengatur ulang kata sandi Anda, masukkan alamat email yang Anda gunakan untuk masuk ke Kas Tracking.</p>

        <form method="POST" action="{{ route('password.email') }}">
        @csrf
        
            <div class="form-group">
                <span>Alamat Email</span><br>
                <input class="form-control mb-0" type="text" name="email" placeholder="" required>
                @if ($errors->has('email'))
                    <span class="text-danger" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-button full-width">
                <button id="submit" type="submit" class="ibtn">Kirim Link Reset</button>
            </div>
        </form>
    </div>
@endif
</div>
@endsection
