@extends('layouts.app-verification')

@section('title')
{{ config('app.name', 'Kas Tracking') }} - Verification
@endsection

@section('main-menu')
    <li class="slide">
        <a class="side-menu__item active" href="{{ route('home') }}">
        <i data-feather="layers" class="side-menu__icon"></i>
            <span class="side-menu__label">Organisasi</span>
            <span class="badge badge-success side-badge">0</span>
        </a>
    </li>
@endsection

@section('header')
    <!--Page header-->
    <div class="page-header">
      <div class="page-leftheader">
        <h4 class="page-title mb-0">Organisasi yang diikuti</h4>
        </ol>
      </div>
      <div class="page-rightheader">
        <div class="btn btn-list">
          <a href="#" class="btn btn-info">
            <i class="fa fa-plus-circle mr-1"></i> Buat Organisasi
          </a>
        </div>
      </div>
    </div>
    <!--End Page header-->
@endsection

@section('content')

@endsection


@section('internalJS')
  
@endsection


