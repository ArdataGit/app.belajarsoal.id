@extends('layouts.Adminlte3')

@section('header')
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('layout/adminlte3/plugins/fontawesome-free/css/all.min.css') }}">

  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('layout/adminlte3/dist/css/adminlte.min.css') }}">

  <style>

    .kategori ul {
        padding-bottom:32px;
        border-left:solid 1px #ddd;
    }

  </style>
@endsection

@section('contentheader')
<h1 class="m-0">Kategori Materi</h1>
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
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
              <ul class="kategori">
                <li>
                <button type="button" class="btn btn-sm btn-warning" onclick="advance_mode();">Advance</button>
                <button data-toggle="modal" data-target="#modal-tambah" type="button" class="btn btn-md btn-primary d-none"><i class="fa fa-plus"></i></button>
                </li>
                @php 
                    if(!function_exists('kategori_list')){
                        function kategori_list($list, &$kategoris, $root){
                            foreach($list as $id){
                                $h = $root ? 'h4' : 'h4';
                                $b = $root ? 'sm' : 'sm';
                                $c = $root ? ' d-none' : '';
                                echo '
                                <li><'.$h.'>
                                <button data-toggle="modal" data-target="#modal-hapus-'.$id.'" type="button" class="btn btn-'.$b.' btn-danger'.$c.'"><i class="fa fa-trash"></i></button>
                                '.$kategoris[$id]['name'].'
                                <button data-toggle="modal" data-target="#modal-edit-'.$id.'" type="button" class="btn btn-'.$b.' btn-info'.$c.'"><i class="fa fa-edit"></i></button>
                                <button data-toggle="modal" data-target="#modal-tambah-'.$id.'" type="button" class="btn btn-'.$b.' btn-primary"><i class="fa fa-plus"></i></button>
                                </'.$h.'>
                                ';
                                if($kategoris[$id]['items']){
                                    echo '
                                <ul>
                                ';
                                    kategori_list($kategoris[$id]['items'], $kategoris, false);
                                    echo '
                                </ul>
                                ';
                                }
                                echo '
                                </li>
                                ';
                            }                            
                        }
                    }

                    kategori_list($kategoris[0], $kategoris, true);
                    unset($kategoris[0]);
                @endphp
              </ul>
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

@endsection

    <!-- Modal Tambah -->
    <div class="modal fade" id="modal-tambah">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Tambah Kategori</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method="post" id="_formData" class="form-horizontal">
            @csrf
            <div class="modal-body">

                <div class="form-group">
                <label>Nama<span class="bintang">*</span></label>
                <input type="text" class="form-control" placeholder="Nama kategori" name="name">
                </div>

                <div class="form-group">
                <label>Keterangan</label>
                <textarea class="form-control" placeholder="Keterangan" name="keterangan"></textarea>
                </div>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger btn-submit-data">Simpan</button>
            </div>
          </form>
        </div>
      <!-- /.modal-content -->
      </div>
    <!-- /.modal-dialog -->
    </div>
    <!-- /.modal tambah -->

@foreach($kategoris as $id=>$kategori)
    
    <!-- Modal Tambah -->
    <div class="modal fade" id="modal-tambah-{{$id}}">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Tambah Sub Kategori</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method="post" id="formAdd_{{$id}}" class="form-horizontal">
            @csrf
            <div class="modal-body">

                <div class="form-group">
                <label>Nama<span class="bintang">*</span></label>
                <input type="text" class="form-control" placeholder="Nama kategori" name="name">
                </div>

                <div class="form-group">
                <label>Keterangan</label>
                <textarea class="form-control" placeholder="Keterangan" name="keterangan"></textarea>
                </div>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger btn-submit-add" idform="{{$id}}">Simpan</button>
            </div>
          </form>
        </div>
      <!-- /.modal-content -->
      </div>
    <!-- /.modal-dialog -->
    </div>
    <!-- /.modal tambah -->

    <!-- Modal Edit -->
    <div class="modal fade" id="modal-edit-{{$id}}">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Edit Kategori</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method="post" id="formEdit_{{$id}}" class="form-horizontal">
            @csrf
            <div class="modal-body">

                <div class="form-group">
                <label>Nama<span class="bintang">*</span></label>
                <input type="text" class="form-control" placeholder="Nama kategori" name="name" value="{{$kategori['name']}}" required>
                </div>

                <div class="form-group">
                <label>Keterangan</label>
                <textarea class="form-control" placeholder="Keterangan" name="keterangan">{{\htmlspecialchars($kategori['keterangan'])}}</textarea>
                </div>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger btn-submit-edit" idform="{{$id}}">Simpan</button>
            </div>
          </form>
        </div>
      <!-- /.modal-content -->
      </div>
    <!-- /.modal-dialog -->
    </div>
    <!-- /.modal edit -->

    <!-- Modal Hapus -->
    <div class="modal fade" id="modal-hapus-{{$id}}">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Konfirmasi</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method="post" id="formHapus_{{$id}}" class="form-horizontal">
            @csrf
            <div class="modal-body">
                <h6> Apakah anda ingin menghapus kategori {{$kategori['name']}}?</h6>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger btn-hapus" idform="{{$id}}">Hapus</button>
            </div>
          </form>
        </div>
      <!-- /.modal-content -->
      </div>
    <!-- /.modal-dialog -->
    </div>
    <!-- /.Modal Hapus -->
@endforeach

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


    // Fungsi Add Data
    $('#_formData').validate({
          rules: {
            name: {
              required: true
            }
          },
          messages: {
            name: {
              required: "Nama kategori tidak boleh kosong"
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
          
            var formData = new FormData($('#_formData')[0]);

            var url = "{{ url('kategorimateri/store') }}";
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

    // Fungsi Tambah Sub Kategori
    $(document).on('click', '.btn-submit-add', function (e) {
        idform = $(this).attr('idform');
        $('#formAdd_'+idform).validate({
          rules: {
            name: {
              required: true
            }
          },
          messages: {
            name: {
              required: "Nama sub kategori tidak boleh kosong"
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
          
            var formData = new FormData($('#formAdd_'+idform)[0]);

            var url = "{{ url('/kategorimateri/store') }}/"+idform;
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

    // Fungsi Ubah Kategori
    $(document).on('click', '.btn-submit-edit', function (e) {
        idform = $(this).attr('idform');
        $('#formEdit_'+idform).validate({
          rules: {
            name: {
              required: true
            }
          },
          messages: {
            name: {
              required: "Nama lengkap tidak boleh kosong"
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
          
            var formData = new FormData($('#formEdit_'+idform)[0]);

            var url = "{{ url('/kategorimateri/update') }}/"+idform;
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


        //Fungsi Hapus Data
    $(document).on('click', '.btn-hapus', function (e) {
        idform = $(this).attr('idform');
        var formData = new FormData($('#formHapus_' + idform)[0]);

        var url = "{{ url('/kategorimateri/delete') }}/"+idform;
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

  });

  function advance_mode(){
    $('.kategori > li > button.btn-primary').toggleClass('d-none');
    $('.kategori > li > h4 > button.btn-danger').toggleClass('d-none');
    $('.kategori > li > h4 > button.btn-info').toggleClass('d-none');    
    }

</script>

@endsection