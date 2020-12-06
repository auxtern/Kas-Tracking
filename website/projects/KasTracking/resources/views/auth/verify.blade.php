@extends('layouts.app-login')

@section('title')
{{ config('app.name', 'Kas Tracking') }} - Verifikasi Email
@endsection

@section('content')
<div class="form-content">
    <div class="form-sent show-it">
        <div class="tick-holder">
            <div class="tick-icon"></div>
        </div>
        <h3>Silahkan melakukan verifikasi alamat email!</h3>
        <p>Sebelum melanjutkan, periksa email Anda untuk menerima tautan verifikasi. Jika Anda tidak menerima email!</p>

        <a class="bg-white p-2 rounded shadow" href="{{ route('verification.resend') }}">Klik di sini untuk meminta yang lain.</a>
    </div>
</div>
@endsection
