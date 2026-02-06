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

<h1 class="m-0">Transaksi {{ucwords($jenis)}}</h1>

@endsection



@section('contentheadermenu')

<ol class="breadcrumb float-sm-right">

  <!-- <li class="breadcrumb-item"><a class="_kembali" href="{{url('user')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</a></li> -->

</ol>

@endsection



@section('content')

<!-- Main content -->

<section class="content">

  <div class="container-fluid">



    <!-- <ul class="nav nav-pills" role="tablist">

          <li class="nav-item">

            <a class="nav-link active" data-toggle="pill" href="#event">Transaksi Event</a>

          </li>

          <li class="nav-item">

            <a class="nav-link" data-toggle="pill" href="#hadiah">Transaksi Hadiah</a>

          </li>

        </ul> -->





    @if($jenis=="paket")



    <div id="event"><br>

      <div class="row">

        <div class="col-12">

          <div class="card">

            <!-- <div class="card-header">

                <h3 class="card-title">Foto Beranda</h3>

              </div> -->

            <!-- /.card-header -->

            <div class="card-body">

              <div class="row">
                <div class="col-8">

                </div>
                <div class="col-4">

                  <form method="get" action="{{url('listtransaksi/paket')}}" class="form-horizontal">

                    <div class="input-group">

                      <input name="caridata" type="text" class="form-control" placeholder="Cari Data" value="{{ app('request')->input('caridata') }}">

                      <button type="submit" class="btn btn-info">Cari</button>

                      <a href="{{url('listtransaksi/paket')}}" class="btn btn-warning">Reset</a>

                    </div>

                  </form>

                </div>
              </div>

              <!-- <span data-toggle="tooltip" data-placement="left" title="Tambah Data">

                <button data-toggle="modal" data-target="#modal-tambah" type="button" class="btn btn-sm btn-primary btn-add-absolute">

                  <i class="fa fa-plus" aria-hidden="true"></i>

                </button>

              </span> -->

              <!-- <button data-toggle="modal" data-target="#modal-tambah" type="button" class="btn btn-md btn-primary btn-absolute">Tambah</button> -->

              <table id="tabledata" class="table  table-striped">

                <thead>

                  <tr>

                    <th>No</th>

                    <th>No.Transaksi</th>

                    <th>User</th>

                    <th>Paket</th>

                    <th>Harga</th>

                    <th>Tanggal Transaksi</th>

                    <th>Detail</th>

                  </tr>

                </thead>

                <tbody>

                  @foreach($data as $key)

                  <tr>

                    <td width="1%">{{$loop->iteration}}</td>

                    <td width="25%">{{$key->merchant_order_id}}</td>

                    <td>{{$key->user_r ? $key->user_r->name : "[Deleted User]"}}</td>

                    <td width="5%">{{$key->paket_mst_r->judul}}</td>

                    <td width="5%" class="_align_right">{{formatRupiahCekGratis($key->harga)}}</td>

                    <td width="20%" class="_align_center">{{Carbon\Carbon::parse($key->created_at)->translatedFormat('l, d F Y , H:i:s')}}</td>

                    <td width="5%" class="_align_right">

                      <div class="btn-group">

                        @if($key->harga>0)

                        <!-- <span data-toggle="tooltip" data-placement="left" title="Bukti Bayar">

                            <button onclick="modalImage('{{$key->merchant_order_id}}','{{asset($key->bukti)}}')" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></button>

                        </span> -->

                        @endif

                        @if($key->status==1)

                        <span>

                          <button style="white-space:nowrap" data-toggle="modal" data-target="#modal-edit-{{$key->id}}" type="button" class="btn btn-sm btn-success">Sudah Bayar</button>

                        </span>

                        @else

                        <span>

                          <button style="white-space:nowrap" data-toggle="modal" data-target="#modal-edit-{{$key->id}}" type="button" class="btn btn-sm btn-danger">Belum Bayar</button>

                        </span>

                        @endif

                        <span data-toggle="tooltip" data-placement="left" title="Hapus Transaksi">

                          <button data-toggle="modal" data-target="#modal-hapus-{{$key->id}}" type="button" class="btn btn-sm btn-outline-danger"><i class="far fa-trash-alt"></i></button>

                        </span>

                      </div>

                    </td>

                  </tr>

                  @endforeach

                </tbody>

                <!-- <tfoot>

                  <tr>

                    <th>Rendering engine</th>

                    <th>Browser</th>

                    <th>Platform(s)</th>

                    <th>Engine version</th>

                    <th>CSS grade</th>

                  </tr>

                  </tfoot> -->

              </table>

              {{ $data->links() }}


            </div>

            <!-- /.card-body -->

          </div>

          <!-- /.card -->

        </div>

        <!-- /.col -->

      </div>

    </div>

    @elseif($jenis=="hadiah")

    <div id="hadiah" class="tab-pane"><br>

      <div class="row">

        <div class="col-12">

          <div class="card">

            <!-- <div class="card-header">

                <h3 class="card-title">Foto Beranda</h3>

              </div> -->

            <!-- /.card-header -->

            <div class="card-body">

              <!-- <span data-toggle="tooltip" data-placement="left" title="Tambah Data">

                <button data-toggle="modal" data-target="#modal-tambah" type="button" class="btn btn-sm btn-primary btn-add-absolute">

                  <i class="fa fa-plus" aria-hidden="true"></i>

                </button>

              </span> -->

              <!-- <button data-toggle="modal" data-target="#modal-tambah" type="button" class="btn btn-md btn-primary btn-absolute">Tambah</button> -->



            </div>

            <!-- /.card-body -->

          </div>

          <!-- /.card -->

        </div>

        <!-- /.col -->

      </div>

    </div>

    @endif





    <!-- /.row -->

  </div>

  <!-- /.container-fluid -->

</section>

<!-- /.content -->



@if($jenis=="paket")



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

          <!-- <div class="card-body"> -->

          <div class="form-group">

            <label for="status_{{$key->id}}">Status</label>

            <select class="form-control status" id="status_{{$key->id}}" name="status[]">

              <option {{ $key->status==0 ? 'selected' : '' }} value="0">Belum Bayar</option>

              <option {{ $key->status==1 ? 'selected' : '' }} value="1">Sudah Bayar</option>

            </select>

          </div>



          <!-- /.form-group -->

          <!-- </div> -->

        </div>

        <div class="modal-footer justify-content-between">

          <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>

          <button type="submit" class="btn btn-danger btn-submit-data" idform="{{$key->id}}">Simpan</button>

        </div>

      </form>

    </div>

    <!-- /.modal-content -->

  </div>

  <!-- /.modal-dialog -->

</div>

<!-- /.modal edit -->



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

          <h6> Apakah anda ingin menghapus transaksi {{$key->merchant_order_id}}?</h6>

        </div>

        <div class="modal-footer justify-content-between">

          <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>

          <button type="button" class="btn btn-danger btn-hapus" idform="{{$key->id}}">Hapus</button>

        </div>

      </form>

    </div>

    <!-- /.modal-content -->

  </div>

  <!-- /.modal-dialog -->

</div>

<!-- /.Modal Hapus -->

@endforeach



@elseif($jenis=="hadiah")



@foreach($datahadiah as $key)

<!-- Modal Edit -->

<div class="modal fade" id="modal-edit-hadiah-{{$key->id}}">

  <div class="modal-dialog modal-lg">

    <div class="modal-content">

      <div class="modal-header">

        <h4 class="modal-title">Ubah Data</h4>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <form method="post" id="formDataHadiah_{{$key->id}}" class="form-horizontal">

        @csrf

        <div class="modal-body">

          <!-- <div class="card-body"> -->

          <div class="form-group">

            <label>Nama Penerima</label>

            <input type="text" class="form-control" placeholder="Nama Penerima" value="{{$key->alamat_r->nama_penerima}}" readonly>

          </div>



          <div class="form-group">

            <label>No.Hp Penerima</label>

            <input type="text" class="form-control" placeholder="No.Hp Penerima" value="{{$key->alamat_r->no_hp_penerima}}" readonly>

          </div>



          @php

          $daftarProvinsi = Kavist\RajaOngkir\Facades\RajaOngkir::kota()->find($key->alamat_r->fk_kabupaten);

          @endphp



          <div class="form-group">

            <label>Provinsi</label>

            <input type="text" class="form-control" placeholder="Provinsi" value="{{$daftarProvinsi['province']}}" readonly>

          </div>



          <div class="form-group">

            <label>Kota/Kabupaten</label>

            <input type="text" class="form-control" placeholder="Provinsi" value="{{$daftarProvinsi['type']}} {{$daftarProvinsi['city_name']}}" readonly>

          </div>



          <div class="form-group">

            <label>Alamat Lengkap</label>

            <textarea name="" id="" cols="30" rows="10" class="form-control" disabled>{{$key->alamat_r->alamat_lengkap}}</textarea>

          </div>



          <div class="form-group">

            <label>Kode Pos</label>

            <input type="text" class="form-control" placeholder="Kode Pos" value="{{$daftarProvinsi['postal_code']}}" readonly>

          </div>





          <div class="form-group">

            <label for="status_{{$key->id}}">Status</label>

            <select class="form-control status" id="status_{{$key->id}}" name="status[]">

              <option {{ $key->status==0 ? 'selected' : '' }} value="0">Pending</option>

              <option {{ $key->status==1 ? 'selected' : '' }} value="1">Processing</option>

              <option {{ $key->status==2 ? 'selected' : '' }} value="2">Failed</option>

              <option {{ $key->status==3 ? 'selected' : '' }} value="3">Expired</option>

              <option {{ $key->status==4 ? 'selected' : '' }} value="4">Complete</option>

            </select>

          </div>



          <div class="form-group">

            <label for="no_resi_{{$key->id}}">No.Resi Pengiriman</label>

            <input type="text" class="form-control" id="no_resi_{{$key->id}}" name="no_resi[]" placeholder="No.Resi Pengiriman" value="{{$key->no_resi}}">

          </div>

          <div class="form-group">

            <label for="status_kirim_{{$key->id}}">Status Pengiriman</label>

            <select class="form-control status_pengiriman" id="status_kirim_{{$key->id}}" name="status_kirim[]">

              <option {{ $key->status_kirim==0 ? 'selected' : '' }} value="0">Belum dikirim</option>

              <option {{ $key->status_kirim==1 ? 'selected' : '' }} value="1">Sudah dikirim</option>

            </select>

          </div>



          <!-- /.form-group -->

          <!-- </div> -->

        </div>

        <div class="modal-footer justify-content-between">

          <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>

          <button type="submit" class="btn btn-danger btn-submit-data-hadiah" idform="{{$key->id}}">Simpan</button>

        </div>

      </form>

    </div>

    <!-- /.modal-content -->

  </div>

  <!-- /.modal-dialog -->

</div>

<!-- /.modal edit -->



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

          <h6> Apakah anda ingin menghapus transaksi {{$key->merchant_order_id}}?</h6>

        </div>

        <div class="modal-footer justify-content-between">

          <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>

          <button type="button" class="btn btn-danger btn-hapus" idform="{{$key->id}}">Hapus</button>

        </div>

      </form>

    </div>

    <!-- /.modal-content -->

  </div>

  <!-- /.modal-dialog -->

</div>

<!-- /.Modal Hapus -->

@endforeach



@endif



@endsection



@section('footer')

<!-- Custom Input File -->

<script src="{{ asset('layout/adminlte3/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

<!-- jQuery -->

<script src="{{ asset('layout/adminlte3/plugins/jquery/jquery.min.js') }}"></script>

<!-- Bootstrap 4 -->

<script src="{{ asset('layout/adminlte3/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- jquery-validation -->

<script src="{{ asset('layout/adminlte3/plugins/jquery-validation/jquery.validate.min.js') }}"></script>

<script src="{{ asset('layout/adminlte3/plugins/jquery-validation/additional-methods.min.js') }}"></script>

<!-- DataTables  & Plugins -->

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

<!-- AdminLTE App -->

<script src="{{ asset('layout/adminlte3/dist/js/adminlte.min.js') }}"></script>

<!-- AdminLTE for demo purposes -->

<script src="{{ asset('layout/adminlte3/dist/js/demo.js') }}"></script>

<!-- Page specific script -->

<!-- DatePicker -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.2.3/flatpickr.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.2.3/themes/dark.css">

<!--  Flatpickr  -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.2.3/flatpickr.js"></script>

<script>
  $(document).ready(function() {



    // datatablelihattran("tabledata");

    // datatablelihathadiah("tabledatahadiah");



    $('.status_pengiriman').select2({

      placeholder: "Pilih Status Pengiriman"

    });



    $('.status').select2({

      placeholder: "Pilih Status"

    });



    //Fungsi Hapus Data

    $(document).on('click', '.btn-hapus', function(e) {

      idform = $(this).attr('idform');

      var formData = new FormData($('#formHapus_' + idform)[0]);



      var url = "{{ url('/hapustransaksi') }}/{{$jenis}}/" + idform;

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

        beforeSend: function() {

          $.LoadingOverlay("show");

        },

        success: function(response) {

          if (response.status == true) {

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

        },

        error: function(xhr, status) {

          alert('Error!!!');

        },

        complete: function() {

          $.LoadingOverlay("hide");

        }

      });

    });



    // Fungsi Ubah Data

    $(document).on('click', '.btn-submit-data', function(e) {

      idform = $(this).attr('idform');

      $('#formData_' + idform).validate({

        rules: {

          'status[]': {

            required: true

          }

        },

        messages: {

          'status[]': {

            required: "Status tidak boleh kosong"

          }

        },

        errorElement: 'span',

        errorPlacement: function(error, element) {

          error.addClass('invalid-feedback');

          element.closest('.form-group').append(error);

        },

        highlight: function(element, errorClass, validClass) {

          $(element).addClass('is-invalid');

        },

        unhighlight: function(element, errorClass, validClass) {

          $(element).removeClass('is-invalid');

        },



        submitHandler: function() {



          var formData = new FormData($('#formData_' + idform)[0]);



          var url = "{{ url('/updatestatuspembayaran') }}/" + idform;

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

            beforeSend: function() {

              $.LoadingOverlay("show");

            },

            success: function(response) {

              if (response.status == true) {

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

            },

            error: function(xhr, status) {

              alert('Error!!!');

            },

            complete: function() {

              $.LoadingOverlay("hide");

            }

          });

        }

      });

    });



    // Fungsi Ubah Data

    $(document).on('click', '.btn-submit-data-hadiah', function(e) {

      idform = $(this).attr('idform');

      $('#formDataHadiah_' + idform).validate({

        rules: {

          'status_kirim[]': {

            required: true

          }

        },

        messages: {

          'status_kirim[]': {

            required: "Status tidak boleh kosong"

          }

        },

        errorElement: 'span',

        errorPlacement: function(error, element) {

          error.addClass('invalid-feedback');

          element.closest('.form-group').append(error);

        },

        highlight: function(element, errorClass, validClass) {

          $(element).addClass('is-invalid');

        },

        unhighlight: function(element, errorClass, validClass) {

          $(element).removeClass('is-invalid');

        },



        submitHandler: function() {



          var formData = new FormData($('#formDataHadiah_' + idform)[0]);



          var url = "{{ url('/updatestatushadiah') }}/" + idform;

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

            beforeSend: function() {

              $.LoadingOverlay("show");

            },

            success: function(response) {

              if (response.status == true) {

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

            },

            error: function(xhr, status) {

              alert('Error!!!');

            },

            complete: function() {

              $.LoadingOverlay("hide");

            }

          });

        }

      });

    });



  });
</script>



@endsection