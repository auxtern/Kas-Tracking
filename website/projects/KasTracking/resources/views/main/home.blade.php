@extends('layouts.app-main')

@section('title')
{{ config('app.name', 'Kas Tracking') }}
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
          <a href="{{ route('organisasi/create') }}" class="btn btn-info">
            <i class="fa fa-plus-circle mr-1"></i> Buat Organisasi
          </a>
        </div>
      </div>
    </div>
    <!--End Page header-->
@endsection

@section('content')
<div class="col-md-12 col-lg-6">
  <div class="card overflow-hidden">
    <div class="card-status bg-primary"></div>
    <div class="card-header">
      <h3 class="card-title text-dark">
        Delcom
      </h3>
      <div class="card-options">
        <a href="#" class="card-options-collapse mr-2" data-toggle="card-collapse">
          <i class="fa fa-chevron-up"></i>
        </a>
        <a href="#" class="card-options-remove mr-2" data-toggle="card-remove">
          <i class="fa fa-times">
            </i></a>
      </div>
    </div>
    <div class="card-body text-center">

      <div class="avatar-list">
        <span class="avatar avatar-xxl bradius" style="background-image: url({{$url_foto}})"></span>
        <span class="avatar avatar-xxl bradius" style="background-image: url({{$url_foto}})"></span>
        <span class="avatar avatar-xxl bradius" style="background-image: url({{$url_foto}})"></span>
      </div>
      <div class="mt-3">
        <p class="text-muted">Anda dan 1 orang lainnya berpartisipasi dalam organisasi ini.</p>
      </div>
      
      <div class="mt-5">
        <button class="btn btn-sm btn-info">Kelolah</button>
      </div>
    </div>
  </div>
</div>
@endsection


@section('internalJS')
  
@endsection


