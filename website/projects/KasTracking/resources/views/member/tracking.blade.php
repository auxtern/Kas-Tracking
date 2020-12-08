@extends('layouts.app-member')

@section('title')
{{ config('app.name', 'Kas Tracking') }} - Keungan Organisasi
@endsection


@section('header')
    <!--Page header-->
    <div class="page-header">
      <div class="page-leftheader">
        <h4 class="page-title mb-0"><i class="fa fa-layer-group mr-2"></i> {{ $organisasi['nama'] }}</h4>
      </div>
    </div>
    <!--End Page header-->
@endsection

@section('content')

    <div class="panel panel-primary">
      <div class="tab-menu-heading bg-white shadow">
        <div class="d-felx flex-wrap justify-content-between align-items-center">
          <div class="tabs-menu">
            
            <!-- Tabs -->
            <ul class="nav panel-tabs">
              <li><a href="#tab1" class="active" data-toggle="tab">Pemasukan</a></li>
              <li><a href="#tab2" data-toggle="tab">Pengeluaran</a></li>
              <li><a href="#tab3" data-toggle="tab">Tunggakan</a></li>
              <li><a href="#tab4" data-toggle="tab">Kesalahan</a></li>
            </ul>
          </div>
        </div>
      </div>

      <div class="panel-body tabs-menu-body mt-3">
        <div class="tab-content">

          <div class="tab-pane active" id="tab1">

            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                      <div class="card-title">Data Pemasukan</div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-bordered text-nowrap" id="dataTables1">
                        <thead>
                          <tr>
                            <th class="wd-15p border-bottom-0">ID Anggota</th>
                            <th class="wd-15p border-bottom-0">Nama</th>
                            <th class="wd-15p border-bottom-0">Nominal</th>
                            <th class="wd-20p border-bottom-0">Catatan</th>
                            <th class="wd-10p border-bottom-0">Tanggal Diperbarui</th>
                          </tr>
                        </thead>
                        <tbody>

                          @php
                              $dataPemasukan = Illuminate\Support\Facades\DB::select('select organisasi_tracking.*, organisasi_members.* from organisasi_tracking INNER JOIN organisasi_members on organisasi_tracking.member_id = organisasi_members.member_id where organisasi_tracking.organisasi_id = ? AND organisasi_tracking.kategori = ? ORDER BY organisasi_tracking.tracking_id DESC', [$organisasi['organisasi_id'], 'Pemasukan']);
                          @endphp

                          @foreach ($dataPemasukan as $mPemasukan)
                            <tr>
                              <td>{{ $mPemasukan->member_id }}</td>
                              <td>{{ $mPemasukan->nama }}</td>
                              <td>{{ $mPemasukan->nominal }}</td>
                              <td>{{ $mPemasukan->catatan }}</td>
                              <td>{{ App\Helpers\Tools::tanggalHariIndonesia($mPemasukan->updated_at) }}</td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>

          <div class="tab-pane  " id="tab2">

            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                      <div class="card-title">Data Pengeluaran</div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-bordered text-nowrap" id="dataTables2">
                        <thead>
                          <tr>
                            <th class="wd-15p border-bottom-0">Nama Bendahara</th>
                            <th class="wd-15p border-bottom-0">Nominal</th>
                            <th class="wd-20p border-bottom-0">Catatan</th>
                            <th class="wd-10p border-bottom-0">Tanggal Diperbarui</th>
                          </tr>
                        </thead>
                        <tbody>

                          @php
                          $dataPemasukan = Illuminate\Support\Facades\DB::select('select organisasi_tracking.*, users.* from organisasi_tracking INNER JOIN users on organisasi_tracking.user_id = users.id where organisasi_tracking.organisasi_id = ? AND organisasi_tracking.kategori = ? ORDER BY organisasi_tracking.tracking_id DESC', [$organisasi['organisasi_id'], 'Pengeluaran']);
                          @endphp

                          @foreach ($dataPemasukan as $mPemasukan)
                            <tr>
                              <td>{{ $mPemasukan->nama }}</td>
                              <td>{{ $mPemasukan->nominal }}</td>
                              <td>{{ $mPemasukan->catatan }}</td>
                              <td>{{ App\Helpers\Tools::tanggalHariIndonesia($mPemasukan->updated_at) }}</td>
                            </tr>
                            @endforeach

                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>

          <div class="tab-pane " id="tab3">

            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                      <div class="card-title">Data Tunggakan</div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-bordered text-nowrap" id="dataTables3">
                        <thead>
                          <tr>
                            <th class="wd-15p border-bottom-0">ID Anggota</th>
                            <th class="wd-15p border-bottom-0">Nama</th>
                            <th class="wd-15p border-bottom-0">Nominal</th>
                            <th class="wd-20p border-bottom-0">Catatan</th>
                            <th class="wd-10p border-bottom-0">Tanggal Diperbarui</th>
                          </tr>
                        </thead>
                        <tbody>

                          @php
                          $dataPemasukan = Illuminate\Support\Facades\DB::select('select organisasi_tracking.*, organisasi_members.* from organisasi_tracking INNER JOIN organisasi_members on organisasi_tracking.member_id = organisasi_members.member_id where organisasi_tracking.organisasi_id = ? AND organisasi_tracking.kategori = ? ORDER BY organisasi_tracking.tracking_id DESC', [$organisasi['organisasi_id'], 'Tunggakan']);
                          @endphp

                          @foreach ($dataPemasukan as $mPemasukan)
                            <tr>
                              <td>{{ $mPemasukan->member_id }}</td>
                              <td>{{ $mPemasukan->nama }}</td>
                              <td>{{ $mPemasukan->nominal }}</td>
                              <td>{{ $mPemasukan->catatan }}</td>
                              <td>{{ App\Helpers\Tools::tanggalHariIndonesia($mPemasukan->updated_at) }}</td>
                            </tr>
                          @endforeach

                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>

          <div class="tab-pane " id="tab4">

            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                      <div class="card-title">Kesalahan Data</div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-bordered text-nowrap" id="dataTables4">
                        <thead>
                          <tr>
                            <th class="wd-15p border-bottom-0">Nama Bendahara</th>
                            <th class="wd-15p border-bottom-0">Nominal</th>
                            <th class="wd-20p border-bottom-0">Catatan</th>
                            <th class="wd-10p border-bottom-0">Tanggal Diperbarui</th>
                          </tr>
                        </thead>
                        <tbody>

                          @php
                          $dataPemasukan = Illuminate\Support\Facades\DB::select('select organisasi_tracking.*, users.* from organisasi_tracking INNER JOIN users on organisasi_tracking.user_id = users.id where organisasi_tracking.organisasi_id = ? AND organisasi_tracking.kategori = ? ORDER BY organisasi_tracking.tracking_id DESC', [$organisasi['organisasi_id'], 'Kesalahan']);
                          @endphp

                          @foreach ($dataPemasukan as $mPemasukan)
                            <tr>
                              <td>{{ $mPemasukan->nama }}</td>
                              <td>{{ $mPemasukan->nominal }}</td>
                              <td>{{ $mPemasukan->catatan }}</td>
                              <td>{{ App\Helpers\Tools::tanggalHariIndonesia($mPemasukan->updated_at) }}</td>
                            </tr>
                          @endforeach

                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
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


@endsection




