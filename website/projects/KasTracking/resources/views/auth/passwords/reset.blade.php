@extends('layouts.app-login')

@section('title')
{{ config('app.name', 'Kas Tracking') }} - Reset Kata Sandi
@endsection

@section('content')
<div class="form-content">
    <div class="form-items">
        <a href="{{ route('login') }}" class="d-flex align-items-center text-decoration-none">
            <img  class="mr-3" src="{{ asset('img/kas-tracking.png') }}" style="width: 76px;" alt="">
            <h2 class="text-white">{{ config('app.name', 'Kas Tracking') }}</h2>
        </a>
        <h3>Buat Kata Sandi Baru</h3>

        <form method="POST" action="{{ route('password.update') }}">
        @csrf

            <input type="hidden" name="token" value="{{ $token }}">
        
            <div class="form-group">
                <span>Alamat Email</span><br>
                <input class="form-control mb-0" type="text" name="email" placeholder="" value="{{ $email ?? old('email') }}" required autofocus>
                @if ($errors->has('email'))
                    <span class="text-danger" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <span>Kata Sandi Baru</span><br>
                <input class="form-control mb-0" type="password" name="password" placeholder="" required>
                @if ($errors->has('password'))
                    <span class="text-danger" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>


            <div class="form-group">
                <span>Ulangi Kata Sandi</span><br>
                <input class="form-control mb-0" type="password" name="password_confirmation" placeholder="" required>
            </div>


            <div class="form-button full-width">
                <button id="submit" type="submit" class="ibtn">Reset Kata Sandi</button>
            </div>
        </form>
    </div>
</div>
@endsection
