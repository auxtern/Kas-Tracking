<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- FAVICON --}}
    <link rel="shortcut icon" type="image/png" href="{{ asset('img/kas-tracking.png') }}" />

    <title>@yield('title')</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/login/login.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/login/login-theme.css') }}">

</head>
<body>
<div class="form-body">
    <div class="row">
        <div class="img-holder position-fixed">
            <div class="bg"></div>
            <div class="info-holder">
                <img src="{{ asset('svg/login/login-graphic.svg') }}" alt="">
                <h3 class="text-justify font-weight-light">Jadilah bendahara yang jujur, dengan menerapkan transparansi data informasi terkait pemasukan dan pengeluaran dana di lingkungan organisasi kamu!</h3>
            </div>
        </div>
        <div class="form-holder">
            @yield('content')
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.5.4/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="{{ asset('js/login/login.js') }}"></script>
</body>
</html>