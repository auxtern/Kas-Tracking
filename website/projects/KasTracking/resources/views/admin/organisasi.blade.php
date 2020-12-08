@extends('layouts.app-main')

@section('title')
{{ config('app.name', 'Kas Tracking') }} - Admin
@endsection


@section('header')
    <!--Page header-->
    <div class="page-header">
      <div class="page-leftheader">
        <h4 class="page-title mb-0"><i class="fa fa-lg fa-grid"></i> Daftar Organisasi</h4>
      </div>
    </div>
    <!--End Page header-->
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="card-title">Daftar Organisasi</div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered text-nowrap" id="data-bendahara">
              <thead>
                <tr>
                  <th class="wd-15p border-bottom-0">ID</th>
                  <th class="wd-15p border-bottom-0">Nama</th>
                  <th class="wd-20p border-bottom-0">Lokasi</th>
                  <th class="wd-15p border-bottom-0">Jenis iuran</th>
                  <th class="wd-10p border-bottom-0">Status iuran</th>
                  <th class="wd-10p border-bottom-0">Jumlah iuran</th>
                  <th class="wd-10p border-bottom-0">Tanggal Dibuat</th>
                  <th class="wd-10p border-bottom-0">Tanggal Dierbarui</th>
                </tr>
              </thead>
              <tbody>
                @php
                    $dataOrgs = App\Organisasi::all();
                @endphp

                @foreach ($dataOrgs as $dataOrg)
                    <tr>
                        <td>{{ $dataOrg->organisasi_id }}</td>
                        <td>{{ $dataOrg->nama }}</td>
                        <td>{{ $dataOrg->lokasi }}</td>
                        <td>{{ $dataOrg->jenis_iuran }}</td>
                        <td>{{ $dataOrg->status_iuran }}</td>
                        <td>{{ $dataOrg->jumlah_iuran }}</td>
                        <td>{{ $dataOrg->created_at }}</td>
                        <td>{{ $dataOrg->updated_at }}</td>
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

