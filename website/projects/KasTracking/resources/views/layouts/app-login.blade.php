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
    
    <!--Bootstrap css -->
    <link href="{{ asset('../node_modules/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet"/> 
    
    <!---Icons css-->
    <link href="{{ asset('../node_modules/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet"/> 

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

<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/login/login.js') }}"></script>
</body>
</html>