@extends('layouts.app-main')

@section('title')
{{ config('app.name', 'Kas Tracking') }} - Dashboard
@endsection

@section('header')
    <!--Page header-->
    <div class="page-header">
      <div class="page-leftheader">
        <h4 class="page-title mb-0">Hay, {{ Auth::user()->nama }}</h4>
        <ol class="breadcrumb">
          <li class="breadcrumb-item" aria-current="page">
            <span><i class="fa fa-home mr-2 fs-14"></i>Dashboard</span>
          </li>
        </ol>
      </div>
      <div class="page-rightheader">
        <div class="btn btn-list">
          <a href="#" class="btn btn-info">
            <i class="fa fa-comments mr-1"></i> TJ
          </a>
        </div>
      </div>
    </div>
    <!--End Page header-->
@endsection

@section('content')
    <!-- Row-1 -->
    <div class="row">
      <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden dash1-card border-0">
          <div class="card-body">
            <p class="mb-1">Total Pemasukan</p>
            <h2 class="mb-1 number-font">Rp.50,000</h2>
            {{-- <small class="fs-12 text-muted">laporan selama satu bulan</small> --}}
            {{-- <span class="ratio bg-info">85%</span> --}}
          </div>
          <div id="spark2"></div>
        </div>
      </div>
      <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden dash1-card border-0">
          <div class="card-body">
            <p class="mb-1">Total Pengeluaran</p>
            <h2 class="mb-1 number-font">Rp.2,590</h2>
            {{-- <small class="fs-12 text-muted">laporan selama satu bulan</small> --}}
            {{-- <span class="ratio bg-danger">62%</span> --}}
          </div>
          <div id="spark3"></div>
        </div>
      </div>
      <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden dash1-card border-0">
          <div class="card-body">
            <p class="mb-1">Sisa Dana Tersimpan</p>
            <h2 class="mb-1 number-font">Rp.1,954</h2>
            {{-- <small class="fs-12 text-muted">Compared to Last Month</small> --}}
            {{-- <span class="ratio bg-warning">53%</span> --}}
          </div>
          <div id="spark4"></div>
        </div>
      </div>
      <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden dash1-card border-0">
          <div class="card-body">
            <p class="mb-1">Total Anggota</p>
            <h2 class="mb-1 number-font">2,000</h2>
            {{-- <small class="fs-12 text-muted">laporan selama satu bulan</small> --}}
            {{-- <span class="ratio bg-success">-10%</span> --}}
          </div>
          <div id="spark1"></div>
        </div>
      </div>
    </div>
    <!-- End Row-1 -->

    <!-- Row-2 -->
    <div class="row">
      <div class="col-xl-8 col-lg-8 col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Analisa Keuangan</h3>
            <div class="card-options">
              <div class="btn-group p-0">
                <button class="btn btn-outline-light btn-sm" type="button">
                  Minggu
                </button>
                <button class="btn btn-light btn-sm" type="button">
                  Bulan
                </button>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="row mb-3">

              <div class="col-xl-3 col-6">
                <p class="mb-1">Pemasukan</p>
                <h3 class="mb-0 fs-20 number-font1">Rp.52,618</h3>
                <p class="fs-12 text-muted">
                  <span class="text-danger mr-1"><i class="fa fa-arrow-down"></i>0.9%</span>minggu ini
                </p>
              </div>

              <div class="col-xl-3 col-6">
                <p class="mb-1">Pengeluaran</p>
                <h3 class="mb-0 fs-20 number-font1">Rp.26,197</h3>
                <p class="fs-12 text-muted">
                  <span class="text-success mr-1"><i class="fa fa-arrow-up"></i>0.15%</span>minggu ini
                </p>
              </div>

            </div>

            <div id="echart1" class="chart-tasks chart-dropshadow text-center"></div>
            
            <div class="text-center mt-2">
              <span class="mr-4"><span class="dot-label bg-success"></span>Pemasukan</span>
              <span><span class="dot-label bg-danger"></span>Pengeluaran</span>
            </div>

          </div>

        </div>
      </div>

      <div class="col-xl-4 col-lg-4 col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Aktivitas Terbaru</h3>
            <div class="card-options">
              <a
                href="#"
                class="option-dots"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
                ><i class="fa fa-ellipsis-h fs-20"></i
              ></a>
              <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="#">Hari ini</a>
                <a class="dropdown-item" href="#">Minggu Lalu</a> 
                <a class="dropdown-item" href="#">Bulan Lalu</a> 
                <a class="dropdown-item" href="#">Tahun Lalu</a> 
              </div>
            </div>

          </div>

          <div class="card-body">
            <div class="latest-timeline scrollbar3" id="scrollbar3">
              <ul class="timeline mb-0">
                <li class="mt-0">
                  <div class="d-flex">
                    <span class="time-data">Task Finished</span
                    ><span class="ml-auto text-muted fs-11"
                      >09 June 2020</span
                    >
                  </div>
                  <p class="text-muted fs-12">
                    <span class="text-info">Joseph Ellison</span>
                    finished task on<a
                      href="#"
                      class="font-weight-semibold"
                    >
                      Project Management</a
                    >
                  </p>
                </li>
                <li>
                  <div class="d-flex">
                    <span class="time-data">New Comment</span
                    ><span class="ml-auto text-muted fs-11"
                      >05 June 2020</span
                    >
                  </div>
                  <p class="text-muted fs-12">
                    <span class="text-info">Elizabeth Scott</span>
                    Product delivered<a
                      href="#"
                      class="font-weight-semibold"
                    >
                      Service Management</a
                    >
                  </p>
                </li>
                <li>
                  <div class="d-flex">
                    <span class="time-data">Target Completed</span
                    ><span class="ml-auto text-muted fs-11"
                      >01 June 2020</span
                    >
                  </div>
                  <p class="text-muted fs-12">
                    <span class="text-info">Sonia Peters</span> finished
                    target on<a
                      href="#"
                      class="font-weight-semibold"
                    >
                      this month Sales</a
                    >
                  </p>
                </li>
                <li>
                  <div class="d-flex">
                    <span class="time-data">Revenue Sources</span
                    ><span class="ml-auto text-muted fs-11"
                      >26 May 2020</span
                    >
                  </div>
                  <p class="text-muted fs-12">
                    <span class="text-info">Justin Nash</span> source
                    report on<a
                      href="#"
                      class="font-weight-semibold"
                    >
                      Generated</a
                    >
                  </p>
                </li>
                <li>
                  <div class="d-flex">
                    <span class="time-data">Dispatched Order</span
                    ><span class="ml-auto text-muted fs-11"
                      >22 May 2020</span
                    >
                  </div>
                  <p class="text-muted fs-12">
                    <span class="text-info">Ella Lambert</span> ontime
                    order delivery
                    <a
                      href="#"
                      class="font-weight-semibold"
                      >Service Management</a
                    >
                  </p>
                </li>
                <li>
                  <div class="d-flex">
                    <span class="time-data">New User Added</span
                    ><span class="ml-auto text-muted fs-11"
                      >19 May 2020</span
                    >
                  </div>
                  <p class="text-muted fs-12">
                    <span class="text-info">Nicola Blake</span> visit
                    the site<a
                      href="#"
                      class="font-weight-semibold"
                    >
                      Membership allocated</a
                    >
                  </p>
                </li>
                <li>
                  <div class="d-flex">
                    <span class="time-data">Revenue Sources</span
                    ><span class="ml-auto text-muted fs-11"
                      >15 May 2020</span
                    >
                  </div>
                  <p class="text-muted fs-12">
                    <span class="text-info">Richard Mills</span> source
                    report on<a
                      href="#"
                      class="font-weight-semibold"
                    >
                      Generated</a
                    >
                  </p>
                </li>
                <li class="mb-0">
                  <div class="d-flex">
                    <span class="time-data">New Order Placed</span
                    ><span class="ml-auto text-muted fs-11"
                      >11 May 2020</span
                    >
                  </div>
                  <p class="text-muted fs-12">
                    <span class="text-info">Steven Hart</span> is proces
                    the order<a
                      href="#"
                      class="font-weight-semibold"
                    >
                      #987</a
                    >
                  </p>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>

    </div>
    <!-- End Row-2 -->
@endsection


@section('internalJS')
  <script src="{{ asset('js/main/theme1.js') }}"></script>
@endsection


