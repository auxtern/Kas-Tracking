@extends('layouts.app-main')

@section('title')
{{ config('app.name', 'Kas Tracking') }} - Anggota Organisasi
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
    <a class="side-menu__item active" href="{{ route('organisasi/manage/members', ['organisasi_id'=>$organisasi['organisasi_id']]) }}">
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
            <span>Anggota</span>
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
            <div class="card-title">Data Anggota</div>
            <div>
                  <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalTambah"><i class="fa fa-plus"></i></button>
            </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered text-nowrap" id="dataTables1">
              <thead>
                <tr>
                  <th class="wd-15p border-bottom-0">ID Anggota</th>
                  <th class="wd-10p border-bottom-0">Keys</th>
                  <th class="wd-15p border-bottom-0">Nama</th>
                  <th class="wd-15p border-bottom-0">Jenis Kelamin</th>
                  <th class="wd-20p border-bottom-0">Tipe Pembayaran</th>
                  <th class="wd-15p border-bottom-0">Whatsapp</th>
                  <th class="wd-10p border-bottom-0">Email</th>
                  <th class="wd-10p border-bottom-0">Tanggal Ditambahkan</th>
                  <th class="wd-10p border-bottom-0">Tindakan</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($org_members as $member)
                  <tr>
                    <td>{{ $member->member_id }}</td>
                    <td>{{ $member->keys }}</td>
                    <td>{{ $member->nama }}</td>
                    <td>{{ $member->jenis_kelamin }}</td>
                    <td>{{ $member->tipe_pembayaran }}</td>
                    <td>{{ $member->whatsapp }}</td>
                    <td>{{ $member->email }}</td>
                    <td>{{ App\Helpers\Tools::tanggalHariIndonesia($member->created_at) }}</td>
                    <td>
                      <button class="btn btn-sm btn-warning" onclick="ubahDataMember('{{ $member->member_id }}', '{{ $member->nama }}', '{{ $member->tipe_pembayaran }}', '{{ $member->whatsapp }}', '{{ $member->email }}', '{{ $member->keys }}', '{{ $member->jenis_kelamin }}')" data-toggle="modal" data-target="#modalUbah">
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

    <!-- Modal -->
    <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalTambahLabel">Tambah Anggota</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">


            <form method="POST" action="{{ route('organisasi/manage/members', ['organisasi_id'=>$organisasi['organisasi_id']]) }}">
              @csrf

              <div class="form-group">
                  <label for="member_id" class="form-label">ID Anggota</label>

                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">m{{$organisasi['organisasi_id']}}_</span>
                    </div>
                    <input class="form-control{{ $errors->has('member_id') ? ' is-invalid' : '' }} mb-0" type="text" name="member_id" placeholder="" value="{{ old('member_id') }}" required>
                  </div>
                  @if ($errors->has('member_id'))
                    <span class="text-danger" role="alert">
                        <strong>{{ $errors->first('member_id') }}</strong>
                    </span>
                  @endif
              </div>

              <div class="form-group">
                  <label for="nama" class="form-label">Nama Lengkap</label>
                  <input class="form-control{{ $errors->has('nama') ? ' is-invalid' : '' }} mb-0" type="text" name="nama" placeholder="" value="{{ old('nama') }}" required>
                  @if ($errors->has('nama'))
                      <span class="text-danger" role="alert">
                          <strong>{{ $errors->first('nama') }}</strong>
                      </span>
                  @endif
              </div>


              <div class="form-group">
                <label class="form-label">Jenis Kelamin</label>
                <div class="form-check form-check-inline">
                  <label class="custom-control custom-radio mr-3" style="cursor: pointer;">
                    <input name="jenis_kelamin" type="radio" class="custom-control-input{{ $errors->has('jenis_kelamin') ? ' is-invalid' : '' }}" value="Laki-Laki">
                    <span class="custom-control-label">Laki-Laki</span>
                  </label>
                  <label class="custom-control custom-radio" style="cursor: pointer;">
                    <input name="jenis_kelamin" type="radio" class="custom-control-input{{ $errors->has('jenis_kelamin') ? ' is-invalid' : '' }}" value="Perempuan">
                    <span class="custom-control-label">Perempuan</span>
                  </label>
                </div>
              </div>


              <div class="form-group">
                  <label for="tipe_pembayaran" class="form-label">Tipe Pembayaran</label>
                  <select class="form-control{{ $errors->has('tipe_pembayaran') ? ' is-invalid' : '' }} mb-0" name="tipe_pembayaran" required>
                      <option value="" disabled selected></option>
                      <option value="Selalu">Selalu</option>
                      <option value="Terkadang">Terkadang</option>
                      <option value="Tidak Ada">Tidak Ada</option>
                  </select>
                  @if ($errors->has('tipe_pembayaran'))
                      <span class="text-danger" role="alert">
                          <strong>{{ $errors->first('tipe_pembayaran') }}</strong>
                      </span>
                  @endif
              </div>

              <div class="form-group">
                  <span>Nomor Whatsapp</span><br>
                  <input class="form-control{{ $errors->has('whatsapp') ? ' is-invalid' : '' }} mb-0" type="number" name="whatsapp" placeholder="" value="{{ old('whatsapp') }}">
                  @if ($errors->has('whatsapp'))
                      <span class="text-danger" role="alert">
                          <strong>{{ $errors->first('whatsapp') }}</strong>
                      </span>
                  @endif
              </div>

              <div class="form-group">
                  <label for="email" class="form-label">Alamat Email</label>
                  <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} mb-0" type="email" name="email" placeholder="" value="{{ old('email') }}">
                  @if ($errors->has('email'))
                      <span class="text-danger" role="alert">
                          <strong>{{ $errors->first('email') }}</strong>
                      </span>
                  @endif
              </div>

              <div class="form-group">
                <label for="keys" class="form-label">Keys</label>
                  <input class="form-control{{ $errors->has('keys') ? ' is-invalid' : '' }} mb-0" type="keys" name="keys" placeholder="" value="{{ old('keys') }}" required>
                  @if ($errors->has('keys'))
                      <span class="text-danger" role="alert">
                          <strong>{{ $errors->first('keys') }}</strong>
                      </span>
                  @endif
              </div>

              <p class="font-weight-bold">Anggota yang telah ditambahkan tidak dapat dihapus!</p>

              <div class="form-button text-right">
                  <button id="submit" type="submit" class="btn btn-primary">Simpan Data</button>
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


            <form method="POST" action="{{ route('organisasi/manage/members/update', ['organisasi_id'=>$organisasi['organisasi_id']]) }}">
              @csrf

              <div class="form-group">
                  <label for="member_id" class="form-label">ID Anggota</label>
                  <input class="form-control mb-0" type="text" name="member_id" id="u_member_id" required readonly>
              </div>

              <div class="form-group">
                  <label for="nama" class="form-label">Nama Lengkap</label>
                  <input class="form-control mb-0" type="text" name="nama" id="u_nama" required>
              </div>

              <div class="form-group">
                <label class="form-label">Jenis Kelamin</label>
                <div class="form-check form-check-inline">
                  <label class="custom-control custom-radio mr-3" style="cursor: pointer;">
                    <input name="jenis_kelamin" type="radio" class="custom-control-input{{ $errors->has('jenis_kelamin') ? ' is-invalid' : '' }}" value="Laki-Laki">
                    <span class="custom-control-label">Laki-Laki</span>
                  </label>
                  <label class="custom-control custom-radio" style="cursor: pointer;">
                    <input name="jenis_kelamin" type="radio" class="custom-control-input{{ $errors->has('jenis_kelamin') ? ' is-invalid' : '' }}" value="Perempuan">
                    <span class="custom-control-label">Perempuan</span>
                  </label>
                </div>
              </div>

              <div class="form-group">
                  <label for="tipe_pembayaran" class="form-label">Tipe Pembayaran</label>
                  <select class="form-control mb-0" name="tipe_pembayaran" id="u_tipe_pembayaran" required>
                      <option value="" disabled selected></option>
                      <option value="Selalu">Selalu</option>
                      <option value="Terkadang">Terkadang</option>
                      <option value="Tidak Ada">Tidak Ada</option>
                  </select>
              </div>

              <div class="form-group">
                  <span>Nomor Whatsapp</span><br>
                  <input class="form-control mb-0" type="number" name="whatsapp" id="u_whatsapp">
              </div>

              <div class="form-group">
                  <label for="email" class="form-label">Alamat Email</label>
                  <input class="form-control mb-0" type="email" name="email" id="u_email">
              </div>

              <div class="form-group">
                <label for="keys" class="form-label">Keys</label>
                  <input class="form-control mb-0" type="keys" name="keys" id="u_keys" required>
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
    function ubahDataMember(member_id, nama, tipe_pembayaran, whatsapp, email, keys, jenis_kelamin){
      $('#u_member_id').val(member_id);
      $('#u_nama').val(nama);
      $('#u_tipe_pembayaran').val(tipe_pembayaran);
      $('#u_whatsapp').val(whatsapp);
      $('#u_email').val(email);
      $('#u_keys').val(keys);
      $('input[name="jenis_kelamin"]').removeAttr('checked');
      $("input[name=jenis_kelamin][value=" + jenis_kelamin + "]").attr('checked', 'checked');
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

