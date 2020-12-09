<!DOCTYPE html>
<html>
  <head>
    <!-- Meta data -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title -->
    <title>@yield('title')</title>

    <!--Favicon -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('img/kas-tracking.png') }}" />

    <!--Bootstrap css -->
    <link href="{{ asset('../node_modules/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet"/>

    <!-- Style css -->
    <link href="{{ asset('css/main/main.css') }}" rel="stylesheet"/>

    <!-- Perfect Scroolbal -->
    <link href="{{ asset('../node_modules/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet"/>

    <!---Icons css-->
    <link href="{{ asset('../node_modules/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet"/>

    <!-- Simplebar css-->
    <link href="{{ asset('../node_modules/simplebar/dist/simplebar.min.css') }}" rel="stylesheet"/>

    <!-- Growl css-->
    <link href="{{ asset('lib/jquery.growl.css') }}" rel="stylesheet"/>

    <!-- Color Skin css -->
    <link href="{{ asset('css/main/theme1.css') }}" rel="stylesheet"/>


    @yield('internalCSS')

  </head>

  <body class="app sidebar-mini">

    <!---Global-loader-->
    <div id="global-loader">
      <img src="{{ asset('svg/main/loader.svg') }}" alt="loader" />
    </div>
    <!--- End Global-loader-->

    <!-- Page -->
    <div class="page">

      <div class="page-main">

        <!-- aside -->
        <aside class="app-sidebar">
          <div class="app-sidebar__logo">
            <a class="header-brand" href="{{ route('member') }}">
              <img src="{{ asset('img/kas-tracking-text.png') }}" class="header-brand-img desktop-lgo" alt=""/>
              <img src="{{ asset('img/kas-tracking-text.png') }}" class="header-brand-img dark-logo" alt=""/>
              <img src="{{ asset('img/kas-tracking.png') }}" class="header-brand-img mobile-logo" alt=""/>
              <img src="{{ asset('img/kas-tracking.png') }}" class="header-brand-img darkmobile-logo" alt=""/>
            </a>
          </div>
          <div class="app-sidebar__user">
            <div class="dropdown user-pro-body text-center">
              <div class="user-pic">
                <img src="{{ $url_foto }}" alt="user-img" class="avatar-xl rounded-circle mb-1"/>
              </div>
              <div class="user-info">
                <h5 class="mb-1">
                  {{ $cmember->nama }}
                </h5>
                <span class="badge badge-success-light mt-2">{{ $status }}</span>
              </div>
            </div>

            <div class="user-info">
                <ul class="list-group text-left mt-3">
                    <li class="list-group-item justify-content-between">
                        <strong class="text-muted">Jenis Iuran</strong>
                        <span class="badgetext badge badge-info badge-pill">
                            {{ $organisasi->jenis_iuran }}
                        </span>
                    </li>
                    <li class="list-group-item justify-content-between">
                        <strong class="text-muted">Jumlah Iuran</strong>
                        <span class="badgetext badge badge-secondary badge-pill">
                            {{ App\Helpers\Tools::formatRupiah($organisasi->jumlah_iuran) }}
                        </span>
                    </li>
                </ul>
            </div>

          </div>

          <ul class="side-menu app-sidebar3">

            <li class="side-item side-item-category mt-4">Menu Organisasi</li>

            <li class="slide">
                <a class="side-menu__item {{ (Route::currentRouteName() == 'member/dashboard') ? 'active' : 'bg-white' }}" href="{{ route('member/dashboard') }}">
                <i data-feather="grid" class="side-menu__icon"></i>
                    <span class="side-menu__label">Dasbor</span>
                </a>
            </li>


            <li class="slide">
                <a class="side-menu__item {{ (Route::currentRouteName() == 'member/tracking') ? 'active' : 'bg-white' }}" href="{{ route('member/tracking', ['organisasi_id'=>$organisasi->organisasi_id]) }}">
                <i data-feather="dollar-sign" class="side-menu__icon"></i>
                    <span class="side-menu__label">Keuangan</span>
                    <span class="badge badge-success side-badge">@yield('nMoney')</span>
                </a>
            </li>

          </ul>
        </aside>
        <!-- aside closed -->

        <!-- App-Content -->
        <div class="app-content main-content">
          <div class="side-app">

            <!--app header-->
            <div class="app-header header">
              <div class="container-fluid">
                <div class="d-flex">
                  <a class="header-brand" href="index.htm">
                    <img src="#logo.png" class="header-brand-img desktop-lgo" alt=""/>
                    <img src="#logo1.png" class="header-brand-img dark-logo" alt=""/>
                    <img src="#favicon.png" class="header-brand-img mobile-logo" alt=""/>
                    <img src="#favicon1.png" class="header-brand-img darkmobile-logo" alt=""/>
                  </a>

                  <div class="app-sidebar__toggle" data-toggle="sidebar">
                    <a class="open-toggle" href="#">
                      <i data-feather="menu" class="feather feather-align-left header-icon"></i>
                    </a>
                  </div>

                  <div class="d-flex order-lg-2 ml-auto">
                    <div class="dropdown header-fullscreen">
                      <a class="nav-link icon full-screen-link p-0" id="fullscreen-button">
                        <i data-feather="minimize" class="header-icon"></i>
                      </a>
                    </div>

                    <div class="dropdown header-message">
                      {{-- <a class="nav-link icon" data-toggle="dropdown">
                        <i data-feather="bell" class="header-icon"></i>
                        <span class="badge badge-success side-badge">3</span>
                      </a> --}}

                      <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow animated">
                        <div class="dropdown-header shadow">
                          <h6 class="mb-0">Notifikasi</h6>
                        </div>

                        <div class="header-dropdown-list notifikasi-menu" id="notifikasi-menu">
                          <a class="dropdown-item border-bottom" href="#">
                            <div class="d-flex align-items-center">
                              <div class="">
                                <span class="avatar avatar-md brround align-self-center cover-image" data-image-src="">
                                </span>
                              </div>
                              <div class="d-flex">
                                <div class="pl-3">
                                  <h6 class="mb-1">-</h6>
                                  <p class="fs-13 mb-1">
                                    -
                                  </p>
                                  <div class="small text-muted">
                                    -
                                  </div>
                                </div>
                              </div>
                            </div>
                          </a>
                        </div>

                        <div class="text-center pt-3 pb-2 border-top">
                          <a href="#" class="">See All Messages</a>
                        </div>

                      </div>
                    </div>



                    <div class="dropdown profile-dropdown">
                        <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
                          <span>
                            <img src="{{ $url_foto }}" alt="img" class="avatar avatar-md brround"/>
                          </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow animated">
                          <div class="text-center">
                              <span class="text-center user py-2 font-weight-bold">
                                  {{ $cmember->nama }}
                                  <br>
                                  <span class="badge badge-success-light mt-2">{{ $status }}</span>
                            <div class="dropdown-divider"></div>
                          </div>

                          <a class="dropdown-item d-flex" href="{{ route('member/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i data-feather="log-out" class="text-icon mr-3"></i>
                            <div class="">Keluar</div>
                          </a>
                          <form id="logout-form" action="{{ route('member/logout') }}" method="POST" style="display: none;">
                            @csrf
                          </form>

                        </div>
                      </div>


                  </div>
                </div>
              </div>
            </div>
            <!--/app header-->

            {{-- PAGE HEADER --}}
              @yield('header')
            {{-- END PAGE HEADER --}}

            {{-- PAGE CONTENT --}}
              @yield('content')
            {{-- END PAGE CONTENT --}}
          </div>
        </div>
        <!-- End app-content-->

      </div>

      <!--Footer-->
      <footer class="footer">
        <div class="container">
          <div class="row align-items-center flex-row-reverse">
            <div class="col-md-12 col-sm-12 text-center">
              Copyright©{{ date("Y") }}
              <a href="{{ route('home') }}">Kas Tracking</a>.
            </div>
          </div>
        </div>
      </footer>
      <!-- End Footer-->

    </div>
    <!-- End Page -->

    <!-- Back to top -->
	<a href="index.htm#top" id="back-to-top">
		<i class="fa fa-angle-double-up"></i>
	</a>

    <!-- JS -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('../node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('../node_modules/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('../node_modules/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('../node_modules/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('../node_modules/peity/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('../node_modules/echarts/dist/echarts.min.js') }}"></script>
    <script src="{{ asset('../node_modules/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('../node_modules/simplebar/dist/simplebar.min.js') }}"></script>
    <script src="{{ asset('../node_modules/feather-icons/dist/feather.min.js') }}"></script>
    <script src="{{ asset('lib/jquery.growl.js') }}"></script>

    <!-- Internal JS -->
    @yield('internalJS')
    <script src="{{ asset('js/main/chart.js') }}"></script>
    <script src="{{ asset('js/main/main.js') }}"></script>
  </body>
</html>
