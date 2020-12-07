@extends('layouts.app-main')

@section('title')
{{ config('app.name', 'Kas Tracking') }}
@endsection

@section('nOrganisasi')
    {{ sizeof($organisasi) }}
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
<div class="d-flex flex-wrap">
  @foreach ($organisasi as $item)
  <div class="col-md-6 col-lg-6">
    <div class="card overflow-hidden">
      <div class="card-status bg-primary"></div>
      <div class="card-header">
        <h3 class="card-title text-dark">
          {{ $item['nama'] }}
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
        @php
            $obj = DB::select('select foto, jenis_kelamin from users where id in (select user_id from organisasi_users where organisasi_id = ?)', [$item['organisasi_id']]);
            $banyakUser = sizeof($obj);
        @endphp

        <div class="avatar-list">
          @foreach ($obj as $row)
            @php
                $user = (array) $row;
                $foto = App\Helpers\Tools::ambilFotoProfil($user['foto'], $user['jenis_kelamin']); 
            @endphp
            <span class="avatar avatar-xxl bradius" style="background-image: url({{$foto}})"></span>  
          @endforeach
        </div>
        <div class="mt-3">
          @if ($banyakUser > 1)
            <p class="text-muted">Kamu dan {{ ($banyakUser - 1) }} orang lainnya menjadi bendahara dalam organisasi ini.</p> 
          @else
            <p class="text-muted">Hanya kamu yang menjadi bendahara dalam organisasi ini.</p>
          @endif
        </div>
        
        <div class="mt-5">
          <a href="{{ route('organisasi/manage', ["organisasi_id" => $item['organisasi_id']]) }}" class="btn btn-sm btn-info text-decoration-none">Kelolah</a>
        </div>
      </div>
    </div>
  </div>
  @endforeach
</div>

@endsection


@section('internalJS')
@if (Session::has('success'))
<script>
  $.growl.notice({
    title: "Sukses",
    message: "{{ Session::get('success')}}"
  });
</script>
@endif
@endsection


