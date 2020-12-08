@extends('layouts.app-main')

@section('title')
{{ config('app.name', 'Kas Tracking') }} - Admin
@endsection


@section('header')
    <!--Page header-->
    <div class="page-header">
      <div class="page-leftheader">
        <h4 class="page-title mb-0"><i class="fa fa-lg fa-user-friends"></i> Daftar Pengguna</h4>
      </div>
    </div>
    <!--End Page header-->
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="card-title">Daftar Pengguna</div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered text-nowrap" id="data-bendahara">
              <thead>
                <tr>
                  <th class="wd-15p border-bottom-0">ID</th>
                  <th class="wd-15p border-bottom-0">Nama</th>
                  <th class="wd-15p border-bottom-0">Jenis Kelamin</th>
                  <th class="wd-20p border-bottom-0">Provinsi</th>
                  <th class="wd-15p border-bottom-0">Whatsapp</th>
                  <th class="wd-10p border-bottom-0">Email</th>
                  <th class="wd-10p border-bottom-0">Tanggal Bergabung</th>
                </tr>
              </thead>
              <tbody>
                @php
                    $dataUsers = App\User::all();
                @endphp

                @foreach ($dataUsers as $dataUser)
                    <tr>
                        <td>{{ $dataUser->id }}</td>
                        <td>{{ $dataUser->nama }}</td>
                        <td>{{ $dataUser->jenis_kelamin }}</td>
                        <td>{{ $dataUser->provinsi }}</td>
                        <td>{{ $dataUser->whatsapp }}</td>
                        <td>{{ $dataUser->email }}</td>
                        <td>{{ $dataUser->created_at }}</td>
                    </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('internalCSS')
    <link href="{{ asset('lib/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
		<link href="{{ asset('lib/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" />
		<link href="{{ asset('lib/datatable/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
@endsection

@section('internalJS')
  {{-- Data Table --}}
  <script src="{{ asset('lib/datatable/js/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('lib/datatable/js/dataTables.bootstrap4.js') }}"></script>
  <script src="{{ asset('lib/datatable/js/dataTables.buttons.min.js') }}"></script>
  <script src="{{ asset('lib/datatable/js/buttons.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('lib/datatable/js/jszip.min.js') }}"></script>
  <script src="{{ asset('lib/datatable/js/pdfmake.min.js') }}"></script>
  <script src="{{ asset('lib/datatable/js/vfs_fonts.js') }}"></script>
  <script src="{{ asset('lib/datatable/js/buttons.html5.min.js') }}"></script>
  <script src="{{ asset('lib/datatable/js/buttons.print.min.js') }}"></script>
  <script src="{{ asset('lib/datatable/js/buttons.colVis.min.js') }}"></script>
  <script src="{{ asset('lib/datatable/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('lib/datatable/responsive.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('js/main/datatable/datatable.js') }}"></script>

  @if (Session::has('success'))
    <script>
      $.growl.notice({
        title: "Sukses",
        message: "{{ Session::get('success')}}"
      });
    </script>
  @endif

  @if (Session::has('error'))
    <script>
      $.growl.error({
        title: "Gagal",
        message: "{{ Session::get('error')}}"
      });
    </script>
  @endif

@endsection

