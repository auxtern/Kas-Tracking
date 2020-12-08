@extends('layouts.app-main')

@section('title')
{{ config('app.name', 'Kas Tracking') }} - Keungan Organisasi
@endsection

@section('info-org')
  <ul class="list-group text-left mt-3">
    <li class="list-group-item justify-content-between">
      <strong class="text-muted">Jenis Iuran</strong>
      <span class="badgetext badge badge-info badge-pill">{{ $organisasi['jenis_iuran'] }}</span>
    </li>
    <li class="list-group-item justify-content-between">
      <strong class="text-muted">Jumlah Iuran</strong>
      <span class="badgetext badge badge-secondary badge-pill">Rp{{ number_format($organisasi['jumlah_iuran'], 0, ',', '.') }},00</span>
    </li>
  </ul>
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
        <div class="d-felx flex-wrap justify-content-between align-items-center">
          <div class="text-right">
            <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalTambah"><i class="fa fa-plus"></i></button>
          </div>
          <div class="tabs-menu">
            <!-- Tabs -->
            <ul class="nav panel-tabs">
              <li><a href="#tab0" class="active" data-toggle="tab"><i class="fa fa-users"></i></a></li>
              <li><a href="#tab1" data-toggle="tab">Pemasukan</a></li>
              <li><a href="#tab2" data-toggle="tab">Pengeluaran</a></li>
              <li><a href="#tab3" data-toggle="tab">Tunggakan</a></li>
              <li><a href="#tab4" data-toggle="tab">Kesalahan</a></li>
            </ul>
          </div>
        </div>
      </div>

      <div class="panel-body tabs-menu-body mt-3">
        <div class="tab-content">

          <div class="tab-pane active" id="tab0">
            <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                    <div class="card-title">Anggota Iuran ({{ $organisasi['jenis_iuran'] }})</div>
                </div>
                <div class="card-body">

                  @php
                      $mIuran = [];

                      if($organisasi['jenis_iuran'] == "Mingguan"){
                        $day = date('w');
                        $week_start = date('m-d-Y', strtotime('-'.$day.' days'));
                        $week_end = date('m-d-Y', strtotime('+'.(6-$day).' days'));

                        $mIuran = Illuminate\Support\Facades\DB::select('select * from organisasi_members where NOT member_id in (select member_id from organisasi_tracking where (updated_at >= ? and updated_at <= ?) and nominal = ? )', [$week_start, $week_end, $organisasi['jumlah_iuran']]);

                      }else if($organisasi['jenis_iuran'] == "Bulanan"){
                        $month_start = date("Y-m-d", strtotime("first day of this month"));
                        $month_end = date("Y-m-d", strtotime("last day of this month"));

                        $mIuran = Illuminate\Support\Facades\DB::select('select * from organisasi_members where tipe_pembayaran = ? AND NOT member_id in (select member_id from organisasi_tracking where (updated_at >= ? and updated_at <= ?) and nominal = ?)', ["Selalu", $month_start, $month_end, $organisasi['jumlah_iuran']]);

                      }else{
                        echo '<p>Untuk jenis iuran terkadang tidak ada daftar anggota yang ditampilkan!</p>';
                      }

                  @endphp
                  <div class="table-responsive">
                    <table class="table table-bordered text-nowrap" id="dataTables0">
                      <thead>
                        <tr>
                          <th class="wd-15p border-bottom-0">ID Anggota</th>
                          <th class="wd-15p border-bottom-0">Nama</th>
                          <th class="wd-15p border-bottom-0">Nominal</th>
                          <th class="wd-10p border-bottom-0">Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($mIuran as $member)
                          <tr>
                            <td>{{ $member->member_id }}</td>
                            <td>{{ $member->nama }}</td>
                            <td>{{ $organisasi['jumlah_iuran'] }}</td>
                            <td>
                              <div class="d-flex">

                                <form method="POST" class="mr-3" action="{{ route('organisasi/tracking/add', ["organisasi_id"=>$organisasi['organisasi_id']]) }}">
                                  @csrf
                                  <input type="hidden" name="member_id" value="{{ $member->member_id }}">
                                  <input type="hidden" name="kategori" value="Pemasukan">
                                  <button class="btn btn-sm btn-success">Dibayarkan</button>
                                </form>

                                <form method="POST" class="mr-3" action="{{ route('organisasi/tracking/add', ["organisasi_id"=>$organisasi['organisasi_id']]) }}">
                                  @csrf
                                  <input type="hidden" name="member_id" value="{{ $member->member_id }}">
                                  <input type="hidden" name="kategori" value="Tertunggak">
                                  <button class="btn btn-sm btn-danger">Tertunggak</button>
                                </form>

                              </div>
                            </td>
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

          <div class="tab-pane" id="tab1">

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
                            <th class="wd-10p border-bottom-0">Tindakan</th>
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
                              <td>
                                <button class="btn btn-sm btn-warning" onclick="ubahDataTracking('{{ $mPemasukan->tracking_id }}', '{{ $mPemasukan->nominal }}', '{{ $mPemasukan->kategori }}', '{{ $mPemasukan->catatan }}')" data-toggle="modal" data-target="#modalUbah">
                                  <i class="fa fa-edit"></i>
                                </button>
                              </td>
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
                            <th class="wd-10p border-bottom-0">Tindakan</th>
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
                              <td>
                                <button class="btn btn-sm btn-warning" onclick="ubahDataTracking('{{ $mPemasukan->tracking_id }}', '{{ $mPemasukan->nominal }}', '{{ $mPemasukan->kategori }}', '{{ $mPemasukan->catatan }}')" data-toggle="modal" data-target="#modalUbah">
                                  <i class="fa fa-edit"></i>
                                </button>
                              </td>
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
                            <th class="wd-10p border-bottom-0">Tindakan</th>
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
                              <td>
                                <button class="btn btn-sm btn-warning" onclick="ubahDataTracking('{{ $mPemasukan->tracking_id }}', '{{ $mPemasukan->nominal }}', '{{ $mPemasukan->kategori }}', '{{ $mPemasukan->catatan }}')" data-toggle="modal" data-target="#modalUbah">
                                  <i class="fa fa-edit"></i>
                                </button>
                              </td>
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
                            <th class="wd-10p border-bottom-0">Tindakan</th>
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
                              <td>
                                <button class="btn btn-sm btn-warning" onclick="ubahDataTracking('{{ $mPemasukan->tracking_id }}', '{{ $mPemasukan->nominal }}', '{{ $mPemasukan->kategori }}', '{{ $mPemasukan->catatan }}')" data-toggle="modal" data-target="#modalUbah">
                                  <i class="fa fa-edit"></i>
                                </button>
                              </td>
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



    <!-- Modal -->
    <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalTambahLabel">Buat Catatan Keuangan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <form method="POST" action="{{ route('organisasi/tracking/addc', ['organisasi_id'=>$organisasi['organisasi_id']]) }}">
              @csrf

              <div class="form-group">
                  <label for="member_id" class="form-label">ID Anggota
                  </label>
                  <input class="form-control mb-0" type="text" name="member_id" placeholder="" value="{{ old('member_id') }}" required>
              </div>

              <div class="form-group">
                  <label for="nominal" class="form-label">Nominal</label>
                  <input class="form-control mb-0" type="number" min="0" name="nominal" placeholder="" value="{{ old('nominal') }}" required>
              </div>


              <div class="form-group">
                  <label for="kategori" class="form-label">Kategori</label>
                  <select class="form-control mb-0" name="kategori" required>
                      <option value="" disabled selected></option>
                      <option value="Pemasukan">Pemasukan</option>
                      <option value="Pengeluaran">Pengeluaran</option>
                      <option value="Tunggakan">Tunggakan</option>
                  </select>
              </div>

              <div class="form-group">
                <label for="catatan" class="form-label">Catatan</label>
                <input class="form-control mb-0" type="text" name="catatan" placeholder="" value="{{ old('catatan') }}" required>
            </div>

              <p class="font-weight-bold">Catatan keuangan yang telah ditambahkan tidak dapat dihapus, tetapi dapat ditandai sebagai data yang salah!</p>

              <div class="form-button text-right">
                  <button type="submit" class="btn btn-primary">Simpan Data</button>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="modalUbah" tabindex="-1" role="dialog" aria-labelledby="modalUbahLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalUbahLabel">Ubah Anggota</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="POST" action="{{ route('organisasi/tracking/updatec', ['organisasi_id'=>$organisasi['organisasi_id']]) }}">
              @csrf

              <input type="hidden" name="tracking_id" id="u_tracking_id" value="" required>

              <div class="form-group">
                  <label for="nominal" class="form-label">Nominal</label>
                  <input id="u_nominal" class="form-control mb-0" type="number" min="0" name="nominal" placeholder="" value="{{ old('nominal') }}" required>
              </div>

              <div class="form-group">
                  <label for="kategori" class="form-label">Kategori</label>
                  <select id="u_kategori" class="form-control mb-0" name="kategori" required>
                      <option value="" disabled selected></option>
                      <option value="Pemasukan">Pemasukan</option>
                      <option value="Pengeluaran">Pengeluaran</option>
                      <option value="Tunggakan">Tunggakan</option>
                      <option value="Kesalahan">Kesalahan</option>
                  </select>
              </div>

              <div class="form-group">
                <label for="catatan" class="form-label">Catatan</label>
                <input id="u_catatan" class="form-control mb-0" type="text" name="catatan" placeholder="" value="{{ old('catatan') }}" required>
            </div>

              <div class="form-button text-right">
                  <button type="submit" class="btn btn-primary">Perbarui Data</button>
              </div>
            </form>

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

  <script>
    function ubahDataTracking(tracking_id, nominal, kategori, catatan){
      $('#u_tracking_id').val(tracking_id);
      $('#u_nominal').val(nominal);
      $('#u_kategori').val(kategori);
      $('#u_catatan').val(catatan);
    }
</script>

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




