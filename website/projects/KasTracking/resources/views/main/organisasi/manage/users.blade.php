@extends('layouts.app-main')

@section('title')
{{ config('app.name', 'Kas Tracking') }} - Bendahara Organisasi
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
      <a class="side-menu__item active" href="{{ route('organisasi/manage/users', ['organisasi_id'=>$organisasi['organisasi_id']]) }}">
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
    <a class="side-menu__item bg-white" href="{{ route('organisasi/manage/money', ['organisasi_id'=>$organisasi['organisasi_id']]) }}">
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
            <span>Bendahara</span>
          </li>
        </ol>
      </div>
    </div>
    <!--End Page header-->
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="card-title">Data Bendahara</div>
            <div>
                @if ($organisasi['user_id'] == Auth::user()->id)
                  <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalTambahBendahara"><i class="fa fa-plus"></i></button>
                @endif
            </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered text-nowrap" id="data-bendahara">
              <thead>
                <tr>
                  <th class="wd-15p border-bottom-0">Nama</th>
                  <th class="wd-15p border-bottom-0">Jenis Kelamin</th>
                  <th class="wd-20p border-bottom-0">Provinsi</th>
                  <th class="wd-15p border-bottom-0">Whatsapp</th>
                  <th class="wd-10p border-bottom-0">Email</th>
                  <th class="wd-10p border-bottom-0">Tanggal Bergabung</th>
                  <th class="wd-10p border-bottom-0">Status</th>

                  @if ($organisasi['user_id'] == Auth::user()->id)
                  <th class="wd-25p border-bottom-0">Tindakan</th>
                  @endif

                </tr>
              </thead>
              <tbody>
                @foreach ($bendaharas as $bendahara)
                  <tr>
                    <td>{{ $bendahara['nama'] }}</td>
                    <td>{{ $bendahara['jenis_kelamin'] }}</td>
                    <td>{{ $bendahara['provinsi'] }}</td>
                    <td>{{ $bendahara['whatsapp'] }}</td>
                    <td>{{ $bendahara['email'] }}</td>
                    <td>
                      @php
                        $orgUser = App\OrganisasiUsers::where('user_id', Auth::user()->id)->where('organisasi_id', $organisasi['organisasi_id'])->get()->first();  

                      @endphp
                      {{ App\Helpers\Tools::tanggalHariIndonesia($orgUser['created_at']) }}
                    </td>
                    <td>
                      @if ($bendahara['id'] == $organisasi['user_id'])
                      <span class="badge badge-gradient-primary">Utama</span>
                      @else
                      <span class="badge badge-gradient-success">Asisten</span>
                      @endif
                    </td>

                    @if ($organisasi['user_id'] == Auth::user()->id)
                    <td>
                      @if ($bendahara['id'] != $organisasi['user_id'])
                      <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalHapusBendahara" onclick="$('#user_id_to_delete').val({{ $bendahara['id'] }}); $('#namaBendahara').html('{{ $bendahara['nama'] }}')">
                        <i class="fa fa-trash text-white"></i>
                      </button>
                      @endif
                    </td>
                    @endif

                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  @if ($organisasi['user_id'] == Auth::user()->id)
    <!-- Modal -->
    <div class="modal fade" id="modalTambahBendahara" tabindex="-1" role="dialog" aria-labelledby="modalTambahBendaharaLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalTambahBendaharaLabel">Tambah Bendahara</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <form method="POST" action="{{ route('organisasi/manage/users', ["organisasi_id"=>$organisasi['organisasi_id']]) }}">
            @csrf
            <div class="modal-body">
              
                <div class="form-group">
                  <label for="user_id">User ID</label>
                  <input name="user_id" type="number" class="form-control" placeholder="Masukkan user id...">
                  <small class="form-text text-muted">user id dapat dilihat pada halaman profil.</small>
                </div>
          
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primary">Tambahkan</button>
            </div>

          </form>

        </div>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalHapusBendahara" tabindex="-1" role="dialog" aria-labelledby="modalHapusBendaharaLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalHapusBendaharaLabel">Keluarkan Bendahara <span id="namaBendahara"></span></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <form method="POST" action="{{ route('organisasi/manage/users/delete', ["organisasi_id"=>$organisasi['organisasi_id']]) }}">
            @csrf
            
            <div class="modal-body">

                <input type="hidden" name="user_id" id="user_id_to_delete">
              
                <div class="form-group">
                  <label for="alasan">Alasan pengeluaran?</label>
                  <input name="alasan" type="text" class="form-control" placeholder="Masukkan alasan kamu mengeluarkan bendahara ini...">
                  <small class="form-text text-muted">(!) semua catatan dari bendahara yang akan dikeluarkan dialihkan ke akun kamu.</small>
                </div>
          
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-info" data-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-danger">Keluarkan</button>
            </div>

          </form>

        </div>
      </div>
    </div>
  @endif
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

