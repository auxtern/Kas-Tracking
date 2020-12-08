@extends('layouts.app-main')

@section('title')
{{ config('app.name', 'Kas Tracking') }} - Profile
@endsection

@section('header')
    <!--Page header-->
    <div class="page-header">
      <div class="page-leftheader">
        <h4 class="page-title mb-0">Hay, {{ Auth::user()->nama }}</h4>
        <ol class="breadcrumb">
          <li class="breadcrumb-item active" aria-current="page">
            <a href="{{ route('/') }}"><i class="fa fa-home mr-2 fs-14"></i>Halaman Utama</a>
          </li>
          <li class="breadcrumb-item">
            <span>Profil</span>
          </li>
        </ol>
      </div>
      {{-- <div class="page-rightheader">
        <div class="btn btn-list">
          <a href="#" class="btn btn-info">
            <i class="fa fa-comments mr-1"></i> TJ
          </a>
        </div>
      </div> --}}
    </div>
    <!--End Page header-->
@endsection

@section('content')
    <div class="main-proifle">
        <div class="row">
            <div class="col-lg-8">
                <div class="box-widget widget-user">
                    <div class="widget-user-image1 d-sm-flex">
                    <img alt="" class="rounded-circle border p-0 img-profile" src="{{ $url_foto }}">
                        <div class="mt-1 ml-lg-5">
                            <h4 class="pro-user-username font-weight-bold mb-1">
                                {{ Auth::user()->nama }}
                                <br>
                            </h4>
                            <h5 class="text-muted mb-1">
                                {{ Auth::user()->organisasi }}
                            </h5>
                            <span class="badge badge-success">{{ $status }}</span>

                            <div class="mt-3">
                                <span class="text-muted">bergabung sejak <strong>{{ date("d M y", strtotime(Auth::user()->created_at)) }}</strong></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-auto">
                <div class="text-lg-right btn-list mt-4 mt-lg-0">
                <a href="{{ route('profile/settings') }}" class="btn btn-primary">Pengaturan</a>
                </div>
            </div>
        </div>
        <div class="profile-cover">
            <div class="wideget-user-tab">
                <div class="tab-menu-heading p-0">
                    <div class="tabs-menu1 px-3">
                        <ul class="nav">
                            <li><a href="#tab-7" class="active fs-14" data-toggle="tab">Tentang</a></li>
                            <li><a href="#tab-8" data-toggle="tab" class="fs-14">Organisasi</a></li>
                            {{-- <li><a href="#tab-9" data-toggle="tab" class="fs-14">Linimasa</a></li> --}}
                        </ul>
                    </div>
                </div>
            </div>
        </div><!-- /.profile-cover -->
    </div>

    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="border-0">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab-7">
                        <div class="card">
                            <div class="card-body mt-3">
                                {{-- <h5 class="font-weight-bold">Data Diri</h5> --}}
                                <div>
                                    <ul class="list-group mb-3">
                                        <li class="list-group-item active">ID Pengguna</li>
                                        <li class="list-group-item">{{ Auth::user()->id }}</li>
                                        <li class="list-group-item active">Tanggal Lahir</li>
                                        <li class="list-group-item">{{ date("d-m-Y", strtotime( Auth::user()->tanggal_lahir)) }}</li>
                                        <li class="list-group-item active">Jenis Kelamin</li>
                                        <li class="list-group-item">{{ Auth::user()->jenis_kelamin }}</li>
                                        <li class="list-group-item active">Provinsi Tempat Tinggal</li>
                                        <li class="list-group-item">{{ Auth::user()->provinsi }}</li>
                                        <li class="list-group-item active">Bio</li>
                                        <li class="list-group-item">{{ Auth::user()->bio }}</li>
                                    </ul>
                                </div><!-- main-profile-contact-list -->
                            </div>
                            <div class="card-body border-top">
                                <h5 class="font-weight-bold">Kontak</h5>
                                <div class="main-profile-contact-list d-lg-flex">
                                    <div class="media mr-4">
                                        <div class="media-icon bg-success text-white mr-3 mt-1">
                                            <i class="fab fa-whatsapp"></i>
                                        </div>
                                        <div class="media-body">
                                            <small class="text-muted">Whatsapp</small>
                                            <div class="font-weight-normal1">
                                                +62 {{ Auth::user()->whatsapp }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="media mr-4">
                                        <div class="media-icon bg-warning text-white mr-3 mt-1">
                                            <i class="fas fa-envelope"></i>
                                        </div>
                                        <div class="media-body">
                                            <small class="text-muted">Email</small>
                                            <div class="font-weight-normal1">
                                                {{ Auth::user()->email }}
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- main-profile-contact-list -->
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="tab-8">
                        <div class="card p-5">
                            <div class="row">

                                @foreach ($organisasi as $item)
                                    <div class="col-lg-4">
                                        <div class="d-flex align-items-center border border-primary justify-content-between  py-3">
                                            <div class="wrapper mx-3">
                                                <p class="mb-0 mt-1 font-weight-semibold">
                                                    {{ $item['nama'] }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="tab-9">
                        <ul class="timelineleft pb-5">
                            <li class="timeleft-label">
                                <span class="bg-danger">10 May. 2020</span></li>
                            <li>
                                <i class="fa fa-envelope bg-primary"></i>
                                <div class="timelineleft-item">
                                    <span class="time"><i class="fa fa-clock-o text-danger"></i> 12:05</span>
                                    <h3 class="timelineleft-header"><a href="#">Support Team</a> <span>sent you an email</span></h3>
                                    <div class="timelineleft-body">
                                        Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                                        weebly ning heekya handango imeem plugg dopplr jibjab, movity
                                        jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                                        quora plaxo ideeli hulu weebly balihoo...
                                    </div>
                                    <div class="timelineleft-footer">
                                        <a class="btn btn-primary text-white btn-sm">Read more</a>
                                        <a class="btn btn-secondary text-white btn-sm ">Delete</a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <i class="fa fa-user bg-secondary"></i>
                                <div class="timelineleft-item">
                                    <span class="time"><i class="fa fa-clock-o text-danger"></i> 5 mins ago</span>
                                    <h3 class="timelineleft-header no-border"><a href="#">Sarah Young</a> accepted your friend request</h3>
                                </div>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
