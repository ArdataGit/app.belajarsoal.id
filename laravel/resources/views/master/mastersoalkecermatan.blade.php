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
<h1 class="m-0">Bank Soal Kecermatan</h1>
@endsection

@section('contentheadermenu')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a class="_kembali" href="{{url('kategorisoalkecermatan')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</a></li>
</ol>
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="row">
                    <div class="col-sm-2">Kategori</div>
                    <div class="col-sm-10">: {{$datakategori->judul}}</div>
                </div>
                <div class="row">
                    <div class="col-sm-2">Keterangan</div>
                    <div class="col-sm-10">: {{$datakategori->ket}}</div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <div class="btn-group">
                <span data-toggle="tooltip" data-placement="left" title="Tambah Data">
                  <button data-toggle="modal" data-target="#modal-tambah" type="button" class="btn btn-sm btn-primary btn-add-absolute btn-add-absolute-group">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                  </button>
                </span>
                <!-- <span style="margin-left:35px" data-toggle="tooltip" data-placement="left" title="Import Data">
                  <button data-toggle="modal" data-target="#modal-import" type="button" class="btn btn-sm btn-success btn-add-absolute btn-add-absolute-group">
                      <i class="fas fa-file-excel"></i>
                  </button>
                </span> -->
              </div>

              <!-- <button data-toggle="modal" data-target="#modal-tambah" type="button" class="btn btn-md btn-primary btn-absolute">Tambah</button> -->
                <table id="tabledata" class="table  table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Kiasan</th>
                    <th>Jumlah Soal</th>
                    <th>Waktu</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($data as $key)
                  <tr>
                    <td width="1%">{{$loop->iteration}}</td>
                    <td class="_align_center" width="40%">
                      <table class="table table-bordered" style="margin-bottom:0">
                        <thead>
                          @php
                            $datajson = json_decode($key->karakter);
                          @endphp
                          <tr>
                            @foreach($datajson as $dataloop)
                            <th><h2><b>{{$dataloop}}</b></h2></th>
                            @endforeach
                          </tr>
                          @php
                              $datajson = json_decode($key->kiasan);
                          @endphp
                          <tr>
                            @foreach($datajson as $dataloop)
                            <th><h5><b>{{$dataloop}}</b></h5></th>
                            @endforeach
                          </tr>
                        </thead>
                      </table>
                    </td>
                    @php
                      $getdata = App\Models\DtlSoalKecermatan::where('fk_master_soal_kecermatan',$key->id)->get();
                    @endphp
                    <td class="_align_center" width="1%">
                      {{count($getdata)}}
                    </td>
                    <td class="_align_center" width="1%">
                      @if($key->waktu_total)
                      {{$key->waktu_total}} Menit
                      @else
                      {{$key->waktu}} Detik
                      @endif
                    </td>
                
                    <td width="1%">
                      <div class="btn-group">
                        <span data-toggle="tooltip" data-placement="left" title="Detail Soal">
                          <a href="{{url('dtlsoalkecermatan')}}/{{$key->id}}" class="btn btn-sm btn-outline-info"><i class="fas fa-th-list"></i></a>
                        </span>
                        <span data-toggle="tooltip" data-placement="left" title="Ubah Data">
                          <button data-toggle="modal" data-target="#modal-edit-{{$key->id}}" type="button" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></button>
                        </span>                        
                        @php
                          $cekdata = App\Models\PaketSoalKecermatanDtl::where('fk_master_soal_kecermatan',$key->id)->get();
                        @endphp
                        @if(count($cekdata)<=0)
                        <span data-toggle="tooltip" data-placement="left" title="Hapus Data">
                          <button data-toggle="modal" data-target="#modal-hapus-{{$key->id}}" type="button" class="btn btn-sm btn-outline-danger"><i class="far fa-trash-alt"></i></button>
                        </span>
                        @else
                        <span data-toggle="tooltip" data-placement="left" title="Harap hapus data ini pada paket soal kecermatan terlebih dahulu">
                          <button type="button" class="btn btn-sm btn-outline-danger disabled"><i class="far fa-trash-alt"></i></button>
                        </span>
                        @endif
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
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
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

          @php
            $cekdata  = App\Models\DtlSoalKecermatan::where('fk_master_soal_kecermatan',$key->id)->get();
            $readonly = count($cekdata)>0 ? ' readonly' : '';
            $select2  = $readonly ? ' multiselect2' : '';
          @endphp

          <form method="post" id="formData_{{$key->id}}" class="form-horizontal">
            @csrf
            <div class="modal-body">
              <!-- <div class="card-body"> -->
                <div class="form-group">
                  <label for="karakter_{{$key->id}}">Karakter<span class="bintang">*</span></label>
                    <select class="form-control {{$select2}}" multiple="multiple" id="karakter_{{$key->id}}" name="karakter[]" {{$readonly}}>
                      @foreach(json_decode($key->karakter) as $datajson)
                      <option value="{{$datajson}}" selected>{{$datajson}}</option>
                      @endforeach
                    </select>
                </div>
                <div class="form-group">
                  <label for="kiasan_{{$key->id}}">Kiasan<span class="bintang">*</span></label>
                    <select class="form-control {{$select2}}" multiple="multiple" id="kiasan_{{$key->id}}" name="kiasan[]" {{$readonly}}>
                      @foreach(json_decode($key->kiasan) as $datajson)
                      <option value="{{$datajson}}" selected>{{$datajson}}</option>
                      @endforeach
                    </select>
                </div>
                <div class="form-group">
                  <label for="waktu_total_{{$key->id}}">Waktu<span class="bintang">*</span> ( Menit )</label>
                  <input type="number" min="1" class="form-control" id="waktu_total_{{$key->id}}" name="waktu_total" value="{{$key->waktu_total}}">
                </div>

                <!-- /.form-group -->
              <!-- </div> -->
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <label class="ket-bintang">Bertanda <span class="bintang">*</span> Wajib diisi</label>
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
                <h6> Apakah anda yakin ingin menghapus soal ini?</h6>
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
              <!-- <div class="card-body"> -->
              <input type="hidden" name="fk_kategori_soal_kecermatan_add" value="{{$idkategori}}">
              <div class="form-group">
                <label for="karakter_add">Karakter<span class="bintang">*</span></label>
                <select class="form-control multiselect2" multiple="multiple" name="karakter_add[]">
                </select>
              </div>
          
              <div class="form-group">
                  <label for="kiasan_add">Kiasan<span class="bintang">*</span></label>
                  <select class="form-control multiselect2" multiple="multiple" name="kiasan_add[]">
                  </select>
                </div>

            <div class="form-group">
              <label for="waktu_total_add">Waktu<span class="bintang">*</span> ( Menit )</label>
              <input type="number" min="1" class="form-control" id="waktu_total_add" name="waktu_total_add" value="1">
            </div>
                
              <!-- <div class="card-body"> -->
              <!-- /.form-group -->
            <!-- </div> -->
          </div>
          <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
              <label class="ket-bintang">Bertanda <span class="bintang">*</span> Wajib diisi</label>
              <button type="submit" class="btn btn-danger">Simpan</button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal tambah -->

<!-- Modal Import -->
<!-- <div class="modal fade" id="modal-import">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Import Data</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="post" id="_formDataImport" class="form-horizontal" enctype="multipart/form-data">
          @csrf
          <div class="modal-body">
             
              <div class="form-group">
                <label>Download Template Excel <a href="{{asset('document/TemplateSoal.xlsx')}}">disini</a></label>
              </div>
              <input type="hidden" name="idkategori" value="{{$idkategori}}">
              <div class="form-group row">
                        <label class="col-sm-12 col-form-label">File Excel <span class="input-keterangan">(.xlsx)</span></label>
                        <div class="col-sm-12">
                          <div class="input-group">
                            <div class="custom-file">
                              <input type="file" class="input-file" id="fileexcel" name="fileexcel" idlabel="label-fileexcel">
                              <label id="label-fileexcel" class="custom-file-label" style="border-radius: .25rem;" for="fileexcel">Choose file</label>
                            </div>
                          </div> 
                        </div>
                      </div>
      
          </div>
          <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
              <label class="ket-bintang">Bertanda <span class="bintang">*</span> Wajib diisi</label>
              <button type="submit" class="btn btn-danger">Import</button>
          </div>
        </form>
      </div>

    </div>
   
</div> -->
<!-- /.modal import -->

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
  $(document).ready(function(){

    bsCustomFileInput.init();
    $(document).on('change', '.input-file', function (e) {
        var idphoto = $(this).attr('id');
        onlyExcel(idphoto);
    });

    $(".multiselect2").select2({
        maximumSelectionLength: 5,
        tags: true,
    });

    // $(".multiselect2").select2({
    //   tags: true,
    //   maximumSelectionLength: 5
    // });


    // bsCustomFileInput.init();
    datatablemastersoal("tabledata");

    //Initialize Select2 Elements
    // $('.select2bs4').select2({
    //   placeholder: "Jenis",
    //   allowClear: true,
    //   theme: 'bootstrap4'
    // })

    // $(document).on('change', '.input-photo', function (e) {
    //     var idphoto = $(this).attr('id');
    //     onlyPhoto(idphoto);
    // });

    //Fungsi Hapus Data
    $(document).on('click', '.btn-hapus', function (e) {
        idform = $(this).attr('idform');
        var formData = new FormData($('#formHapus_' + idform)[0]);

        var url = "{{ url('/hapusmastersoalkecermatan') }}/"+idform;
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
            'karakter[]': {
              required: true
            },
            'kiasan[]': {
              required: true
            },
            'waktu_total': {
              required: true
            }
          },
          messages: {
            'karakter[]': {
              required: "Karakter tidak boleh kosong"
            },
            'kiasan[]': {
              required: "Kiasan tidak boleh kosong"
            },
            'waktu_total': {
              required: "Waktu total tidak boleh kosong"
            }
          },
          errorElement: 'span',
          errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
          },
          highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
          },
          unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
          },

          submitHandler: function () {
          
            var formData = new FormData($('#formData_'+idform)[0]);

            var url = "{{ url('/updatemastersoalkecermatan') }}/"+idform;
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
            'karakter_add[]': {
              required: true
            },
            'kiasan_add[]': {
              required: true
            },
            'waktu_total_add': {
              required: true
            }
          },
          messages: {
            'karakter_add[]': {
              required: "Karakter tidak boleh kosong"
            },
            'kiasan_add[]': {
              required: "Kiasan tidak boleh kosong"
            },
            'waktu_total_add': {
              required: "Waktu total tidak boleh kosong"
            }
          },
          errorElement: 'span',
          errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
          },
          highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
          },
          unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
          },

          submitHandler: function () {
            var formData = new FormData($('#_formData')[0]);

            var url = "{{ url('storemastersoalkecermatan') }}";
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

    // Fungsi Add Data Excel
    // $('#_formDataImport').validate({
    //       rules: {
    //         fileexcel: {
    //           required: true
    //         }
    //       },
    //       messages: {
    //         fileexcel: {
    //           required: "File excel tidak boleh kosong"
    //         }
    //       },
    //       errorElement: 'span',
    //       errorPlacement: function (error, element) {
    //         error.addClass('invalid-feedback');
    //         element.closest('.input-group').append(error);
    //       },
    //       highlight: function (element, errorClass, validClass) {
    //         $(element).addClass('is-invalid');
    //       },
    //       unhighlight: function (element, errorClass, validClass) {
    //         $(element).removeClass('is-invalid');
    //       },

    //       submitHandler: function () {
          
    //         var formData = new FormData($('#_formDataImport')[0]);

    //         var url = "{{ url('/importsoal') }}";
    //         $.ajaxSetup({
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             }
    //         });
    //         $.ajax({
    //             url: url,
    //             type: 'POST',
    //             dataType: "JSON",
    //             data: formData,
    //             contentType: false,
    //             processData: false,
    //             beforeSend: function () {
    //                 $.LoadingOverlay("show");
    //             },
    //             success: function (response) {
    //                 if (response.status == true) {
    //                     Swal.fire({
    //                       html: response.message,
    //                       icon: 'success',
    //                       showConfirmButton: false
    //                     });
    //                     reload(1000);
    //                 }else{
    //                   Swal.fire({
    //                       html: response.message,
    //                       icon: 'error',
    //                       confirmButtonText: 'Ok'
    //                   });
    //                 }
    //             },
    //             error: function (xhr, status) {
    //                 alert('Error!!!');
    //             },
    //             complete: function () {
    //                 $.LoadingOverlay("hide");
    //             }
    //         });   
    //       }
    //   });

  });
</script>

@endsection