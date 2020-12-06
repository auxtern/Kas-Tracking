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
            <a href="{{ route('/') }}"><i class="fa fa-home mr-2 fs-14"></i>Dashboard</a>
          </li>
          <li class="breadcrumb-item">
            <span>Profile</span>
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

                            <div class="main-profile-contact-list d-lg-flex">
                                <div class="media mr-3">
                                    <div class="media-icon bg-info text-white mr-3 mt-1">
                                        <i class="fa fa-users"></i>
                                    </div>
                                    <div class="media-body">
                                        <small class="text-muted">Anggota</small>
                                        <div class="font-weight-normal1">
                                            500
                                        </div>
                                    </div>
                                </div>
                                <div class="media mr-3">
                                    <div class="media-icon bg-info text-white mr-3 mt-1">
                                        <i class="fas fa-money-check-alt"></i>
                                    </div>
                                    <div class="media-body">
                                        <small class="text-muted">Uang Tersimpan</small>
                                        <div class="font-weight-normal1">
                                            Rp. 100,000,000.00
                                        </div>
                                    </div>
                                </div>
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
                            <li><a href="#tab-8" data-toggle="tab" class="fs-14">Anggota</a></li>
                            <li><a href="#tab-9" data-toggle="tab" class="fs-14">Linimasa</a></li>
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
                            <div class="card-body">
                                <h5 class="font-weight-bold">Bio</h5>
                                <div class="main-profile-bio mb-0">
                                    <p>{{ Auth::user()->bio }}</p>
                                </div>
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
                                <div class="col-lg-6">
                                    <div class="d-flex align-items-center border p-3 mb-3 br-7">
                                        <div class="avatar avatar-lg brround d-block cover-image" data-image-src="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/images/users/7.jpg">
                                        </div>
                                        <div class="wrapper ml-3">
                                            <p class="mb-0 mt-1 text-dark font-weight-semibold">Denis Rosenblum</p>
                                            <small>Project Manager</small>
                                        </div>
                                        <div class="float-right ml-auto">
                                            <a href="#" class="btn btn-primary btn-sm"><i class="si si-eye mr-1"></i>View</a>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="col-md-12">
                                    <a class="btn btn-block btn-light" href="#"><i class="fe fe-chevron-down"></i> See All</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab-9">
                        <ul class="timelineleft pb-5">
                            <li class="timeleft-label"><span class="bg-danger">10 May. 2020</span></li>
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
                            <li>
                                <i class="fa fa-comments bg-warning"></i>
                                <div class="timelineleft-item">
                                    <span class="time"><i class="fa fa-clock-o text-danger"></i> 27 mins ago</span>
                                    <h3 class="timelineleft-header"><a href="#">Jay White</a> commented on your post</h3>
                                    <div class="timelineleft-body">
                                        Take me to your leader!
                                        Switzerland is small and neutral!
                                        We are more like Germany, ambitious and misunderstood!
                                    </div>
                                    <div class="timelineleft-footer">
                                        <a class="btn btn-info text-white btn-flat btn-sm">View comment</a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <i class="fa fa-video-camera bg-pink"></i>
                                <div class="timelineleft-item">
                                    <span class="time"><i class="fa fa-clock-o text-danger"></i> 1 hour ago</span>
                                    <h3 class="timelineleft-header"><a href="#">Mr. John</a> shared a video</h3>
                                    <div class="timelineleft-body">
                                        <div class="embed-responsive embed-responsive-16by9 w-75">
                                            <iframe class="embed-responsive-item" src="#" allowfullscreen=""></iframe>
                                        </div>
                                        <div class="timelineleft-body mt-3">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dignissim neque condimentum lacus dapibus.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dignissim neque condimentum lacus dapibus.Lorem ipsum dolor sit amet
                                        </div>
                                    </div>
                                    <div class="timelineleft-footer">
                                        <a href="#" class="btn btn-sm bg-warning text-white">See comments</a>
                                    </div>
                                </div>
                            </li>
                            <li class="timeleft-label">
                                <span class="bg-success"> 3 Jan. 2014</span>
                            </li>
                            <li>
                                <i class="fa fa-camera bg-orange"></i>
                                <div class="timelineleft-item">
                                    <span class="time"><i class="fa fa-clock-o text-danger"></i> 2 days ago</span>
                                    <h3 class="timelineleft-header"><a href="#">Mina Lee</a> uploaded new photos</h3>
                                    <div class="timelineleft-body">
                                        <img src="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/images/photos/1.jpg" alt="..." class="margin mt-2 mb-2">
                                        <img src="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/images/photos/2.jpg" alt="..." class="margin mt-2 mb-2 ">
                                        <img src="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/images/photos/3.jpg" alt="..." class="margin mt-2 mb-2 ">
                                        <img src="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/images/photos/4.jpg" alt="..." class="margin mt-2 mb-2">
                                    </div>
                                </div>
                            </li>
                            <li>
                                <i class="fa fa-video-camera bg-pink"></i>
                                <div class="timelineleft-item">
                                    <span class="time"><i class="fa fa-clock-o text-danger"></i> 5 days ago</span>
                                    <h3 class="timelineleft-header"><a href="#">Mr. Doe</a> shared a video</h3>
                                    <div class="timelineleft-body">
                                        <div class="embed-responsive embed-responsive-16by9 w-75">
                                            <iframe class="embed-responsive-item" src="#" allowfullscreen=""></iframe>
                                        </div>
                                    </div>
                                    <div class="timelineleft-footer">
                                        <a href="#" class="btn btn-sm bg-warning text-white">See comments</a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <i class="fa fa-clock-o bg-success pb-3"></i>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection