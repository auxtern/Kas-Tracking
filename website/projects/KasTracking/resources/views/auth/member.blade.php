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
        <div class="text-white mt-2">
            <h5>Masuk Sebagai Anggota</h5>
        </div>
        <form method="POST" action="{{ route('member') }}">
            @csrf

            <div class="form-group">
                <span>ID Anggota</span><br>
                <input class="form-control{{ $errors->has('member_id') ? ' is-invalid' : '' }} mb-0" type="text" name="member_id" placeholder="" value="{{ old('member_id') }}" required>
                @if ($errors->has('member_id'))
                    <span class="text-danger" role="alert">
                        <strong>{{ $errors->first('member_id') }}</strong>
                    </span>
                @endif
            </div>
            
            <div class="form-group">
                <span>Keys</span><br>
                <input class="form-control{{ $errors->has('keys') ? ' is-invalid' : '' }} mb-0" type="password" name="keys" placeholder="" value="{{ old('keys') }}" required>
                @if ($errors->has('keys'))
                    <span class="text-danger" role="alert">
                        <strong>{{ $errors->first('keys') }}</strong>
                    </span>
                @endif
            </div>
            
            @if (Route::has('password.request'))
                <div class="form-button">
                    <button id="submit" type="submit" class="ibtn">{{ __('Masuk') }}</button>
                </div>
            @endif

            <a class="text-white" href="{{ route('login') }}"><i class="fa fa-angle-double-left"></i> Bendahara? masuk sebagai bendahara</a>
            
        </form>
    </div>
</div>
@endsection
