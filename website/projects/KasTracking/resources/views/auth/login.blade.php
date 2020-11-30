@extends('layouts.app-login')

@section('title')
{{ config('app.name', 'Kas Tracking') }} - Masuk
@endsection

@section('content')
<div class="form-content">
    <div class="form-items">
        <a href="{{ route('login') }}" class="d-flex align-items-center text-decoration-none">
            <img  class="mr-3" src="{{ asset('img/kas-tracking.png') }}" style="width: 76px;" alt="">
            <h2 class="text-white">{{ config('app.name', 'Kas Tracking') }}</h2>
        </a>
        <div class="page-links">
            <a href="{{ route('login') }}" class="active">{{ __('Masuk') }}</a>
            <a href="{{ route('register') }}">{{ __('Daftar') }}</a>
        </div>
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <span>Email</span><br>
                <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} mb-0" type="text" name="email" placeholder="" required>
                @if ($errors->has('email'))
                    <span class="text-danger" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            
            <div class="form-group">
                <span>Kata Sandi</span><br>
                <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} mb-0" type="password" name="password" placeholder="" required>
                @if ($errors->has('password'))
                    <span class="text-danger" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
            
            @if (Route::has('password.request'))
                <div class="form-button">
                    <button id="submit" type="submit" class="ibtn">{{ __('Masuk') }}</button> <a href="{{ route('password.request') }}">Lupa kata sandi?</a>
                </div>
            @endif
            
        </form>
    </div>
</div>
@endsection
