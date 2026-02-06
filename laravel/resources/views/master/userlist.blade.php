@extends('layouts.Adminlte3')

@section('header')
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('layout/adminlte3/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('layout/adminlte3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('layout/adminlte3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('layout/adminlte3/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('layout/adminlte3/dist/css/adminlte.min.css') }}">
@endsection

@section('contentheader')
<h1 class="m-0">{{$judul}}</h1>
@endsection

@section('contentheadermenu')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item active">{{$judul}}</li>
</ol>
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
              @if($submenu=="affiliatedtl" && Auth::user()->user_level=='1')
              @else
              <div class="row">
                <div class="col-8">
                  <span class="mb-3" data-toggle="tooltip" data-placement="left" title="Tambah Data">
                    <button data-toggle="modal" data-target="#modal-tambah" type="button" class="btn btn-sm btn-primary">
                      <i class="fa fa-plus" aria-hidden="true"></i>
                    </button>
                    <a href="{{ route('users.export') }}" class="btn btn-sm btn-success">
                      <i class="fa fa-download" aria-hidden="true"> Export</i>
                    </a>
                  </span>
                </div>
                <div class="col-4">
                  <form method="get" action="{{url('user')}}" class="form-horizontal">
                    <div class="input-group">
                      <input name="caridata" type="text" class="form-control" placeholder="Cari Data" value="{{ app('request')->input('caridata') }}">
                      <button type="submit" class="btn btn-info">Cari</button>
                      <a href="{{url('user')}}" class="btn btn-warning">Reset</a>
                    </div>
                  </form>
                </div>
              </div>
              @endif

              @if(count($data)>0)
                <table id="tabledata" class="table table-striped">
                  <thead>
  <tr>
    <th>No</th>
    <th>Username (Email)</th>
    <th>Nama</th>
    <th>Referrer</th>
    <th>NIK</th> <!-- Tambahkan kolom NIK di sini -->
    <th>Aksi</th>
  </tr>
</thead>
<tbody>
  @foreach($data as $key)
  <tr>
    <td width="5%">{{$loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}</td>
    <td width="20%">{{$key->username}}</td>
    <td width="20%">{{$key->name}}</td>
    <td width="20%">
      @if(isset($key->referrer) && is_numeric($key->referrer) && isset(referrer()[$key->referrer]))
        {{ referrer()[$key->referrer][1] }}
      @else
        Tidak Diketahui
      @endif
    </td>
    <td width="15%">{{$key->nik ?? 'Tidak Ada NIK'}}</td> <!-- Tambahkan kolom NIK di sini -->
    <td width="20%" style="text-align:right">
      <div class="btn-group">
        <span data-toggle="tooltip" data-placement="left" title="Lihat Transaksi">
          <a href="{{url('lihattransaksi')}}/{{Crypt::encrypt($key->id)}}" class="btn btn-sm btn-outline-danger"><i class="fas fa-money"></i></a>
        </span>
        <span data-toggle="tooltip" data-placement="left" title="Lihat Hasil Ujian">
          <a href="{{url('lihathasilujian')}}/{{Crypt::encrypt($key->id)}}" class="btn btn-sm btn-outline-success"><i class="fas fa-list"></i></a>
        </span>
        <span data-toggle="tooltip" data-placement="left" title="Reset Password">
          <button data-toggle="modal" data-target="#modal-reset-{{$key->id}}" type="button" class="btn btn-sm btn-outline-primary"><i class="fas fa-undo"></i></button>
        </span>
        <span data-toggle="tooltip" data-placement="left" title="Ubah Data">
          <button data-toggle="modal" data-target="#modal-edit-{{$key->id}}" type="button" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></button>
        </span>
        <span data-toggle="tooltip" data-placement="left" title="Hapus Data">
          <button data-toggle="modal" data-target="#modal-hapus-{{$key->id}}" type="button" class="btn btn-sm btn-outline-danger"><i class="far fa-trash-alt"></i></button>
        </span>
      </div>
    </td>
  </tr>
  @endforeach
</tbody>



                </table>
                {{ $data->links() }}
                @else
                <br>
                <center>Belum Ada User</center>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

@foreach($data as $key)
<!-- Modal Edit -->
<div class="modal fade" id="modal-edit-{{$key->id}}">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Ubah Data</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" id="formData_{{$key->id}}" class="form-horizontal">
        @csrf
        <div class="modal-body">
          @if(Auth::user()->user_level=='1')
          <div class="form-group">
            <label>User Level<span class="bintang">*</span></label>
            <input type="text" class="form-control" placeholder="User Level" value="{{$key->nama_level}}" readonly>
          </div>
          @endif
          <div class="form-group">
            <label>Username<span class="bintang">*</span> (Akun Login)</label>
            <input type="text" class="form-control" placeholder="Username" value="{{$key->username}}" readonly>
          </div>
          <div class="form-group">
            <label for="name_{{$key->id}}">Nama Lengkap<span class="bintang">*</span></label>
            <input type="text" class="form-control" id="name_{{$key->id}}" name="name[]" placeholder="Nama Lengkap" value="{{$key->name}}">
          </div>
          <div class="form-group">
            <label for="email_{{$key->id}}">Email<span class="bintang">*</span></label>
            <input type="email" class="form-control" placeholder="Email" value="{{$key->email}}" readonly>
          </div>
          @if (isset($role))
          <div class="form-group">
            <label for="role_{{$key->id}}">Role<span class="bintang">*</span></label>
            <select class="form-control form-control-lg" id="role_{{$key->id}}" name="role_id">
              @if(!$key->role_id)
              <option value="">Peserta</option>
              @else
              @foreach($role as $data)
              <option value="{{$data->id}}" @if($data->id == $key->role_id) selected @endif>{{$data->name}}</option>
              @endforeach
              @endif
            </select>
          </div>
          @else
          <div class="form-group">
            <label for="role_{{$key->id}}">Role<span class="bintang">*</span></label>
            <select class="form-control form-control-lg" id="role_{{$key->id}}" name="role_id" disabled>
              <option value="">Peserta</option>
            </select>
          </div>
          @endif
          <div class="form-group">
            <label for="no_wa_{{$key->id}}">Nomor Whatsapp<span class="bintang">*</span></label>
            <input type="text" class="form-control int" id="no_wa_{{$key->id}}" name="no_wa[]" placeholder="Nomor Whatsapp" value="{{$key->no_wa}}">
          </div>
          <div class="form-group">
            <label for="jenis_kelamin_{{$key->id}}">Jenis Kelamin<span class="bintang">*</span></label>
            <select class="form-control jenis_kelamin" id="jenis_kelamin_{{$key->id}}" name="jenis_kelamin[]">
              <option {{ $key->jenis_kelamin=='l' ? 'selected' : '' }} value="l">Laki-laki</option>
              <option {{ $key->jenis_kelamin=='p' ? 'selected' : '' }} value="p">Perempuan</option>
            </select>
          </div>
          <div class="form-group">
            <label for="alamat_{{$key->id}}">Alamat<span class="bintang">*</span></label>
            <textarea name="alamat[]" id="alamat_{{$key->id}}" rows="5" class="form-control" placeholder="Alamat">{{ $key->alamat }}</textarea>
          </div>
          <div class="form-group">
            <label for="provinsi_{{$key->id}}">Provinsi<span class="bintang">*</span></label>
            <select class="form-control form-control-lg _provinsi" id_kabupaten="kabupaten_{{$key->id}}" id_kecamatan="kecamatan_{{$key->id}}" id="provinsi_{{$key->id}}" name="provinsi[]">
              <option value=""></option>
              @foreach($provinsi as $data)
              <option value="{{$data->id_prov}}" {{$key->provinsi==$data->id_prov ? 'selected' : ''}}>{{$data->nama}}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="provinsi_{{$key->id}}">Kabupaten<span class="bintang">*</span></label>
            <select class="form-control form-control-lg" id="kabupaten_{{$key->id}}" name="kabupaten[]">
              @php
              $kab = App\Models\MasterKabupaten::where('id_prov',$key->provinsi)->get();
              @endphp
              <option value=""></option>
              @foreach($kab as $data)
              <option value="{{$data->id_kab}}" {{$key->kabupaten==$data->id_kab ? 'selected' : ''}}>{{$data->nama}}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="provinsi_{{$key->id}}">Kecamatan<span class="bintang">*</span></label>
            <select class="form-control form-control-lg" id="kecamatan_{{$key->id}}" name="kecamatan[]">
              @php
              $kec = App\Models\MasterKecamatan::where('id_kab',$key->kabupaten)->get();
              @endphp
              <option value=""></option>
              @foreach($kec as $data)
              <option value="{{$data->id_kec}}" {{$key->kecamatan==$data->id_kec ? 'selected' : ''}}>{{$data->nama}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
          <label class="ket-bintang">Bertanda <span class="bintang">*</span> Wajib diisi</label>
          <button type="submit" class="btn btn-danger btn-submit-data" idform="{{$key->id}}">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Hapus -->
<div class="modal fade" id="modal-hapus-{{$key->id}}">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Konfirmasi</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" id="formHapus_{{$key->id}}" class="form-horizontal">
        @csrf
        <div class="modal-body">
          <h6> Apakah anda ingin menghapus user {{$key->name}}?</h6>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-danger btn-hapus" idform="{{$key->id}}">Hapus</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Reset Password -->
<div class="modal fade" id="modal-reset-{{$key->id}}">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Konfirmasi</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6> Apakah anda ingin me-reset password {{$key->name}}? <b>(Password akan disamakan dengan username)</b></h6>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
        <button type="button" class="btn btn-danger btn-reset-pwd" iduser="{{ $key->id }}">Ya</button>
      </div>
    </div>
  </div>
</div>
@endforeach

<!-- Modal Tambah -->
<div class="modal fade" id="modal-tambah">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Data</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" id="_formData" class="form-horizontal">
        @csrf
        <div class="modal-body">
          @if($submenu=="user")
          <input type="hidden" value="2" name="user_level_add">
          @elseif($submenu=="affiliate" && Auth::user()->user_level=='1')
          <input type="hidden" value="3" name="user_level_add">
          @elseif($submenu=="affiliate" && Auth::user()->user_level=='3')
          <input type="hidden" value="4" name="user_level_add">
          @endif
          <div class="form-group">
            <label for="name_add">Nama Lengkap<span class="bintang">*</span></label>
            <input type="text" class="form-control" id="name_add" name="name_add" placeholder="Nama Lengkap">
          </div>
          <div class="form-group">
            <label for="email_add">Email<span class="bintang">*</span></label>
            <input type="email" class="form-control" id="email_add" name="email_add" placeholder="Email">
          </div>
          @if (isset($role))
          <div class="form-group">
            <label for="role_add">Role</label>
            <select class="form-control form-control-lg" id="role_add" name="role_id">
              <option value="">-- Pilih Role --</option>
              @foreach($role as $data)
              <option value="{{$data->id}}">{{$data->name}}</option>
              @endforeach
            </select>
          </div>
          @endif
          <div class="form-group">
            <label for="no_wa_add">Nomor Whatsapp<span class="bintang">*</span></label>
            <input type="text" class="form-control int" id="no_wa_add" name="no_wa_add" placeholder="Nomor Whatsapp">
          </div>
          <div class="form-group">
            <label for="jenis_kelamin_add">Jenis Kelamin<span class="bintang">*</span></label>
            <select class="form-control jenis_kelamin" id="jenis_kelamin_add" name="jenis_kelamin_add">
              <option value=""></option>
              <option value="l">Laki-laki</option>
              <option value="p">Perempuan</option>
            </select>
          </div>
          <div class="form-group">
            <label for="alamat_add">Alamat<span class="bintang">*</span></label>
            <textarea name="alamat_add" id="alamat_add" rows="5" class="form-control" placeholder="Alamat"></textarea>
          </div>
          <div class="form-group">
            <label for="provinsi_add">Provinsi<span class="bintang">*</span></label>
            <select class="form-control form-control-lg _provinsi" id_kabupaten="kabupaten_add" id_kecamatan="kecamatan_add" id="provinsi_add" name="provinsi_add">
              <option value=""></option>
              @foreach($provinsi as $data)
              <option value="{{$data->id_prov}}">{{$data->nama}}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="provinsi_add">Kabupaten<span class="bintang">*</span></label>
            <select class="form-control form-control-lg" id="kabupaten_add" name="kabupaten_add">
              <option value=""></option>
            </select>
          </div>
          <div class="form-group">
            <label for="provinsi_add">Kecamatan<span class="bintang">*</span></label>
            <select class="form-control form-control-lg" id="kecamatan_add" name="kecamatan_add">
              <option value=""></option>
            </select>
          </div>
          <div class="form-group">
            <label for="provinsi_add">Password<span class="bintang">*</span> sama dengan email</label>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
          <label class="ket-bintang">Bertanda <span class="bintang">*</span> Wajib diisi</label>
          <button type="submit" class="btn btn-danger">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('footer')
<script src="{{ asset('layout/adminlte3/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/jquery-validation/additional-methods.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/dist/js/adminlte.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/dist/js/demo.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.2.3/flatpickr.js"></script>
<script>
  $(document).ready(function(){
    $('.jenis_kelamin').select2({
        placeholder: "Pilih Jenis Kelamin"
    });

    // NIS
    $(".int").on('input paste', function () {
      hanyaAngka(this);
    });

    $(".ttl").flatpickr({
      dateFormat: "d-m-Y",
      disableMobile: "true"
    });

    $('._provinsi').each(function(i, obj) {
        var id_provinsi = $(this).attr('id');
        var id_kabupaten = $(this).attr('id_kabupaten');
        var id_kecamatan = $(this).attr('id_kecamatan');
        getKabupaten(id_provinsi,id_kabupaten,id_kecamatan,'{{ url("/getKabupaten") }}','{{asset("/image/global/loading.gif")}}');
        getKecamatan(id_kabupaten,id_kecamatan,'{{ url("/getKecamatan") }}','{{asset("/image/global/loading.gif")}}');
    });

    bsCustomFileInput.init();

    $(document).on('change', '.input-photo', function (e) {
        var idphoto = $(this).attr('id');
        onlyPhoto(idphoto);
    });

    //Fungsi Hapus Data
    $(document).on('click', '.btn-hapus', function (e) {
        idform = $(this).attr('idform');
        var formData = new FormData($('#formHapus_' + idform)[0]);

        var url = "{{ url('/hapususerlist') }}/"+idform;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            type: 'POST',
            dataType: "JSON",
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $.LoadingOverlay("show");
            },
            success: function (response) {
                    if (response.status == true) {
                      Swal.fire({
                          html: response.message,
                          icon: 'success',
                          showConfirmButton: false
                        });
                        reload(1000);
                    }else{
                      Swal.fire({
                          html: response.message,
                          icon: 'error',
                          confirmButtonText: 'Ok'
                      });
                    }
            },
            error: function (xhr, status) {
                alert('Error!!!');
            },
            complete: function () {
                $.LoadingOverlay("hide");
            }
        });
    });
    

    // Fungsi Ubah Data
    $(document).on('click', '.btn-submit-data', function (e) {
        idform = $(this).attr('idform');
        $('#formData_'+idform).validate({
          rules: {
            'name[]': {
              required: true
            },
            'no_wa[]': {
              required: true,
            },
            'jenis_kelamin[]': {
              required: true
            },
            'alamat[]': {
              required: true
            },
            'provinsi[]': {
              required: true
            },
            'kabupaten[]': {
              required: true
            },
            'kecamatan[]': {
              required: true
            }
          },
          messages: {
            'name[]': {
              required: "Nama lengkap tidak boleh kosong"
            },
            'no_wa[]': {
              required: "Nomor whatsapp tidak boleh kosong"
            },
            'jenis_kelamin[]': {
              required: "Jenis kelamin tidak boleh kosong"
            },
            'alamat[]': {
              required: "Alamat tidak boleh kosong"
            },
            'provinsi[]': {
              required: "Provinsi tidak boleh kosong"
            },
            'kabupaten[]': {
              required: "Kabupaten tidak boleh kosong"
            },
            'kecamatan[]': {
              required: "Kecamatan tidak boleh kosong"
            }
          },
          errorElement: 'span',
          errorPlacement: function (error, element) {
              if (element.hasClass('_select2')) {     
                  element.parent().addClass('select2-error');
                  error.addClass('invalid-feedback');
                  element.closest('.form-group').append(error);
              } else {                                      
                  error.addClass('invalid-feedback');
                  element.closest('.form-group').append(error);
              }
            },
            highlight: function (element, errorClass, validClass) {
              $(element).addClass('is-invalid');
              if(element.tagName.toLowerCase()=='select'){
                var x = element.getAttribute('id');
                y = $('#'+x).parent().addClass('select2-error');
              }
            },
            unhighlight: function (element, errorClass, validClass) {
              $(element).removeClass('is-invalid');
              if(element.tagName.toLowerCase()=='select'){
                var x = element.getAttribute('id');
                y = $('#'+x).parent().removeClass('select2-error');
              }
            },

          submitHandler: function () {
          
            var formData = new FormData($('#formData_'+idform)[0]);

            var url = "{{ url('/updateuserlist') }}/"+idform;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                type: 'POST',
                dataType: "JSON",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $.LoadingOverlay("show");
                },
                success: function (response) {
                    if (response.status == true) {
                      Swal.fire({
                          html: response.message,
                          icon: 'success',
                          showConfirmButton: false
                        });
                        reload(1000);
                    }else{
                      Swal.fire({
                          html: response.message,
                          icon: 'error',
                          confirmButtonText: 'Ok'
                      });
                    }
                },
                error: function (xhr, status) {
                    alert('Error!!!');
                },
                complete: function () {
                    $.LoadingOverlay("hide");
                }
            });   
          }
        });
    });

    // Fungsi Add Data
    $('#_formData').validate({
          rules: {
            user_level_add: {
              required: true
            },
            name_add: {
              required: true
            },
            no_wa_add: {
              required: true
            },
            email_add: {
              required: true,
              email:true
            },
            jenis_kelamin_add: {
              required: true
            },
            alamat_add: {
              required: true
            },
            provinsi_add: {
              required: true
            },
            kabupaten_add: {
              required: true
            },
            kecamatan_add: {
              required: true
            },
          },
          messages: {
            user_level_add: {
              required: "User level tidak boleh kosong"
            },
            no_wa_add: {
              required: "Nomor whatsapp tidak boleh kosong"
            },
            name_add: {
              required: "Nama Lengkap tidak boleh kosong"
            },
            email_add: {
              required: "Email tidak boleh kosong",
              email:"Masukkan alamat email yang benar"
            },
            jenis_kelamin_add: {
              required: "Jenis kelamin tidak boleh kosong"
            },
            alamat_add: {
              required: "Alamat tidak boleh kosong"
            },
            provinsi_add: {
              required: "Provinsi tidak boleh kosong"
            },
            kabupaten_add: {
              required: "Kabupaten tidak boleh kosong"
            },
            kecamatan_add: {
              required: "Kecamatan tidak boleh kosong"
            },
          },
          errorElement: 'span',
          errorPlacement: function (error, element) {
              if (element.hasClass('_select2')) {     
                  element.parent().addClass('select2-error');
                  error.addClass('invalid-feedback');
                  element.closest('.form-group').append(error);
              } else {                                      
                  error.addClass('invalid-feedback');
                  element.closest('.form-group').append(error);
              }
            },
            highlight: function (element, errorClass, validClass) {
              $(element).addClass('is-invalid');
              if(element.tagName.toLowerCase()=='select'){
                var x = element.getAttribute('id');
                y = $('#'+x).parent().addClass('select2-error');
              }
            },
            unhighlight: function (element, errorClass, validClass) {
              $(element).removeClass('is-invalid');
              if(element.tagName.toLowerCase()=='select'){
                var x = element.getAttribute('id');
                y = $('#'+x).parent().removeClass('select2-error');
              }
            },

          submitHandler: function () {
          
            var formData = new FormData($('#_formData')[0]);

            var url = "{{ url('/storeuserlist') }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                type: 'POST',
                dataType: "JSON",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $.LoadingOverlay("show");
                },
                success: function (response) {
                    if (response.status == true) {
                        Swal.fire({
                          html: response.message,
                          icon: 'success',
                          showConfirmButton: false
                        });
                        reload(1000);
                    }else{
                      Swal.fire({
                          html: response.message,
                          icon: 'error',
                          confirmButtonText: 'Ok'
                      });
                    }
                },
                error: function (xhr, status) {
                    alert('Error!!!');
                },
                complete: function () {
                    $.LoadingOverlay("hide");
                }
            });   
          }
      });

  });
  $(document).on('click', '.btn-reset-pwd', function (e) {
    var iduser = $(this).attr('iduser');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: "POST",
        dataType: "JSON",
        url: "{{url('resetuserpass')}}",
        data: { iduser: iduser },
        async: false,
        success: function(response) {
            if (response.status === true) {
                Swal.fire({
                    html: response.message,
                    icon: 'success',
                    showConfirmButton: false
                });
                reload(1000);
            } else {
                Swal.fire({
                    html: response.message,
                    icon: 'error',
                    confirmButtonText: 'Ok'
                });
            }
        }
    });
});

</script>
@endsection
