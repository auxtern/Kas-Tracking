@extends('layouts.app-main')

@section('title')
{{ config('app.name', 'Kas Tracking') }} - Keungan Organisasi
@endsection

@section('side-menu')
  <li class="side-item side-item-category mt-4">Menu Organisasi</li>

  <li class="slide">
    <a class="side-menu__item bg-white" href="{{ route('organisasi/manage', ['organisasi_id'=>$organisasi['organisasi_id']]) }}">
    <i data-feather="grid" class="side-menu__icon"></i>
        <span class="side-menu__label">Dasbor</span>
    </a>
  </li>


    <li class="slide">
      <a class="side-menu__item bg-white" href="{{ route('organisasi/manage/users', ['organisasi_id'=>$organisasi['organisasi_id']]) }}">
      <i data-feather="star" class="side-menu__icon"></i>
          <span class="side-menu__label">Bendahara</span>
          <span class="badge badge-success side-badge">@yield('nUsers')</span>
      </a>
    </li>

  

  <li class="slide">
    <a class="side-menu__item bg-white" href="{{ route('organisasi/manage/members', ['organisasi_id'=>$organisasi['organisasi_id']]) }}">
    <i data-feather="users" class="side-menu__icon"></i>
        <span class="side-menu__label">Anggota</span>
        <span class="badge badge-success side-badge">@yield('nMembers')</span>
    </a>
  </li>

  <li class="slide">
    <a class="side-menu__item active" href="{{ route('organisasi/manage/money', ['organisasi_id'=>$organisasi['organisasi_id']]) }}">
    <i data-feather="dollar-sign" class="side-menu__icon"></i>
        <span class="side-menu__label">Keuangan</span>
        <span class="badge badge-success side-badge">@yield('nMoney')</span>
    </a>
  </li>

  @if ($organisasi['user_id'] == Auth::user()->id)
  <li class="slide">
    <a class="side-menu__item bg-white" href="{{ route('organisasi/manage/settings', ['organisasi_id'=>$organisasi['organisasi_id']]) }}">
    <i data-feather="settings" class="side-menu__icon"></i>
        <span class="side-menu__label">Pengaturan</span>
    </a>
  </li>
  @endif

@endsection

@section('header')
    <!--Page header-->
    <div class="page-header">
      <div class="page-leftheader">
        <h4 class="page-title mb-0">{{ $organisasi['nama'] }}</h4>
        <ol class="breadcrumb">
          <li class="breadcrumb-item active" aria-current="page">
            <a href="{{ route('organisasi') }}"><i class="fa fa-layer-group mr-2 fs-14"></i>Organisasi</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            <a href="{{ route('organisasi/manage', ["organisasi_id"=>$organisasi['organisasi_id']]) }}">Dasbor</a>
          </li>
          <li class="breadcrumb-item" aria-current="page">
            <span>Keuangan</span>
          </li>
        </ol>
      </div>
    </div>
    <!--End Page header-->
@endsection

@section('content')

    <div class="panel panel-primary">
      <div class="tab-menu-heading bg-white shadow">
        <div class="tabs-menu ">
          <!-- Tabs -->
          <ul class="nav panel-tabs">
            <li class=""><a href="#tab1" class="active" data-toggle="tab">Pemasukan</a></li>
            <li><a href="#tab2" data-toggle="tab">Pengeluaran</a></li>
            <li><a href="#tab3" data-toggle="tab">Belum Membayar Iuran</a></li>
          </ul>
        </div>
      </div>

      <div class="panel-body tabs-menu-body bg-white shadow mt-3 card card-header">
        <div class="tab-content">
          <div class="tab-pane active " id="tab1">
            <p>page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like</p>
            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et</p>
          </div>
          <div class="tab-pane  " id="tab2">
            <p> default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like</p>
            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et</p>
          </div>
          <div class="tab-pane " id="tab3">
            <p>over the years, sometimes by accident, sometimes on purpose (injected humour and the like</p>
            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et</p>
          </div>
        </div>
      </div>
    </div>

@endsection


@section('internalJS')

@endsection


