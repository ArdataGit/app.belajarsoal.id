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
<h1 class="m-0">Informasi</h1>
@endsection

@section('contentheadermenu')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item">List Informasi</li>
</ol>
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
              <span data-toggle="tooltip" data-placement="left" title="Tambah Data">
                <button data-toggle="modal" data-target="#modal-tambah" type="button" class="btn btn-sm btn-primary btn-add-absolute">
                  <i class="fa fa-plus" aria-hidden="true"></i>
                </button>
              </span>
              <!-- <button data-toggle="modal" data-target="#modal-tambah" type="button" class="btn btn-md btn-primary btn-absolute">Tambah</button> -->
                <table id="tabledata" class="table  table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <!-- <th>Jenis</th> -->
                    <!-- <th>User</th> -->
                    <th>Judul</th>
                    <th>Ringkasan</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($data as $key)
                  <tr>
                    <td width="1%">{{$loop->iteration}}</td>
                    <!-- <td class="_align_left">{{$key->jenis==1 ? "Promo" : "Referral"}}</td> -->
                    <!-- <td>{{$key->user_r ? $key->user_r->name : ''}}</td> -->
                    <td width="15%">{{$key->judul}}</td>
                    <td class="_align_center">{{$key->ket}}</td>
                    <td width="1%" class="_align_center">
                      <div class="btn-group">
                        <span data-toggle="tooltip" data-placement="left" title="Lihat Gambar">
                          <button onclick="modalImage('{{$key->judul}}','{{asset($key->gambar)}}')" type="button" class="btn btn-sm btn-outline-info"><i class="fas fa-image"></i></button>
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
          <form method="post" id="formData_{{$key->id}}" class="form-horizontal">
            @csrf
            <input type="hidden" value="{{$key->id}}" name="iddata[]">
            <div class="modal-body">
              <!-- <div class="card-body"> -->
                <!-- <div class="form-group">
                  <label for="jenis_{{$key->id}}">Jenis<span class="bintang">*</span></label>
                  <select class="form-control jenis" attrjns="{{$key->id}}" name="jenis[]" id="jenis_{{$key->id}}" disabled>
                    <option value=""></option>
                    <option value="1" {{$key->jenis==1 ? "selected" : ""}}>Promo</option>
                    <option value="2" {{$key->jenis==2 ? "selected" : ""}}>Referral</option>
                  </select>
                </div> -->

                

                <div class="form-group">
                    <label for="judul_{{$key->id}}">Judul<span class="bintang">*</span></label>
                    <input type="text" class="form-control" id="judul_{{$key->id}}" name="judul[]" placeholder="Judul" value="{{$key->judul}}">
                </div>

                <div class="form-group">
                    <label for="link_{{$key->id}}">Link</label>
                    <input type="text" class="form-control" id="link_{{$key->id}}" name="link[]" placeholder="Link" value="{{$key->link}}">
                </div>

                <div class="form-group">
                    <label for="ket_{{$key->id}}">Ringkasan<span class="bintang">*</span></label>
                    <textarea name="ket[]" id="ket_{{$key->id}}" rows="5" class="form-control" placeholder="Ringkasan">{{$key->ket}}</textarea>  
                </div> 
             
                <div class="form-group">
                    <label for="isi_{{$key->id}}">Isi<span class="bintang">*</span></label>
                    <textarea name="isi[]" id="isi_{{$key->id}}" rows="5" class="form-control content_" placeholder="Isi">{{$key->isi}}</textarea>  
                </div> 

                <div class="form-group">
                  <label>Gambar <span class="input-keterangan">(jpg/jpeg/png)</span></label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="input-foto custom-file-input" id="gambar_{{$key->id}}" name="gambar[]" idlabel="label-gambar-{{$key->id}}">
                      <label id="label-gambar-{{$key->id}}" class="custom-file-label" style="border-radius: .25rem;">Pilih file</label>
                    </div>
                  </div> 
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
            <input type="hidden" value="{{$key->id}}" name="iddata[]">
            <div class="modal-body">
                <h6> Apakah anda ingin menghapus informasi {{$key->judul}}?</h6>
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
              <input type="hidden" value="1" name="jenis_add" id="jenis_add">
              <!-- <div class="form-group">
                  <label for="jenis_add">Jenis<span class="bintang">*</span></label>
                  <select class="form-control jenis" attrjns="add" name="jenis_add" id="jenis_add">
                    <option value=""></option>
                    <option value="1">Promo</option>
                    <option value="2">Referral</option>
                  </select>
              </div> -->
              <div class="form-group">
                <label for="judul_add">Judul<span class="bintang">*</span></label>
                <input type="text" class="form-control" id="judul_add" name="judul_add" placeholder="Judul">
              </div>
              
              <div class="form-group">
                <label for="link_add">Link</label>
                <input type="text" class="form-control" id="link_add" name="link_add" placeholder="Link">
              </div> 

              <div class="form-group">
                <label for="ket_add">Ringkasan<span class="bintang">*</span></label>
                <textarea name="ket_add" id="ket_add" rows="5" class="form-control" placeholder="Ringkasan"></textarea>  
              </div>

              <div class="form-group">
                <label for="isi_add">Isi<span class="bintang">*</span></label>
                <textarea name="isi_add" id="isi_add" rows="5" class="form-control content_" placeholder="Isi"></textarea>  
              </div>

              <div class="form-group">
                <label>Gambar<span class="bintang">*</span> <span class="input-keterangan">(jpg/jpeg/png)</span></label>
                <div class="input-group">
                  <div class="custom-file">
                    <input type="file" class="input-foto custom-file-input" id="gambar_add" name="gambar_add" idlabel="label-gambar-add">
                    <label id="label-gambar-add" class="custom-file-label" style="border-radius: .25rem;">Pilih file</label>
                  </div>
                </div> 
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
<!-- /.modal edit -->

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

<!-- Tinymce -->
<script src="{{ env('TINYMCE_SCRIPT_URL') }}" referrerpolicy="origin"></script>


<script>
  $(document).ready(function(){

    tinymce.init({
        selector: ".content_", theme: "modern",
        plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
                "table contextmenu directionality emoticons paste textcolor"
        ],
        toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
        toolbar2: " | link unlink anchor | image media | forecolor backcolor  | print preview code ",
        image_advtab: true,
        height : "250",
        file_picker_callback: function (cb, value, meta) {
        var input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');

        /*
          Note: In modern browsers input[type="file"] is functional without
          even adding it to the DOM, but that might not be the case in some older
          or quirky browsers like IE, so you might want to add it to the DOM
          just in case, and visually hide it. And do not forget do remove it
          once you do not need it anymore.
        */

        input.onchange = function () {
          var file = this.files[0];

          var reader = new FileReader();
          reader.onload = function () {
            /*
              Note: Now we need to register the blob in TinyMCEs image blob
              registry. In the next release this part hopefully won't be
              necessary, as we are looking to handle it internally.
            */
            var id = 'blobid' + (new Date()).getTime();
            var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
            var base64 = reader.result.split(',')[1];
            var blobInfo = blobCache.create(id, file, base64);
            blobCache.add(blobInfo);

            /* call the callback and populate the Title field with the file name */
            cb(blobInfo.blobUri(), { title: file.name });
          };
          reader.readAsDataURL(file);
        };

        input.click();
      }
    });

    bsCustomFileInput.init();

    $(document).on('change', '.input-foto', function (e) {
        var idphoto = $(this).attr('id');
        onlyPhoto(idphoto);
    });

    // $(".hide").hide();

    // $(document).on('change', '.tipe', function (e) {
    //     jenis = $(this).val();
    //     attrjns = $(this).attr('attrjns');
    //     $(".harga_"+attrjns).hide();
    //     $(".persen_"+attrjns).hide();
    //     if(jenis==1){
    //       $(".harga_"+attrjns).show();
    //     }else{
    //       $(".persen_"+attrjns).show();
    //     }
    // });

    // $(document).on('change', '.jenis', function (e) {
    //     jenis = $(this).val();
    //     attrjns = $(this).attr('attrjns');
    //     $(".user_"+attrjns).hide();
    //     if(jenis==2){
    //       $(".user_"+attrjns).show();
    //     }
    // });

    $(".int").on('input paste', function () {
      hanyaInteger(this);
    });

    $(".angkabesar").on('input paste', function () {
      hanyaAngkaAndBesar(this);
    });
    // bsCustomFileInput.init();
    tableinformasi("tabledata");

    //Initialize Select2 Elements

    // $('.mapel').select2({
    //   placeholder: "Pilih Mapel"
    // });

    $('.jenis').select2({
      placeholder: "Pilih Jenis"
    });
    $('.user').select2({
      placeholder: "Pilih User"
    })

    // $('#jenis_soal_add').on('select2:select', function (e) {
    //     var val = $(this).val();
    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    //     });
    //     $.ajax({
    //         url: '{{url("getPaketSoal")}}',
    //         type: 'POST',
    //         dataType: "JSON",
    //         data: {
    //             "val":val
    //         },
    //         beforeSend: function () {
    //             $.LoadingOverlay("show", {
    //                 image       : "{{asset('/image/global/loading.gif')}}"
    //             });
    //         },
    //         success: function (response) {
    //             if (response.status == true) {

    //                 $("#fk_paket_soal_mst_add").html("");
    //                 var newOption = new Option('', '', false, false);
    //                 $("#fk_paket_soal_mst_add").append(newOption).trigger('change');
    //                 $("#fk_paket_soal_mst_add").attr("data-placeholder","Paket Soal");

    //                 $("#fk_paket_soal_mst_add").select2({
    //                     data: response.datapaket
    //                 });
    //             }else{
    //                 Swal.fire({
    //                     title: "Error!!!",
    //                     icon: 'error',
    //                     confirmButtonText: 'Ok'
    //                 });
    //             }
    //         },
    //         error: function (xhr, status) {
    //             alert('Error!!!');
    //         },
    //         complete: function () {
    //             $.LoadingOverlay("hide");
    //         }
    //     });
    // });

    // $(document).on('change', '.input-photo', function (e) {
    //     var idphoto = $(this).attr('id');
    //     onlyPhoto(idphoto);
    // });

    //Fungsi Hapus Data
    $(document).on('click', '.btn-hapus', function (e) {
        idform = $(this).attr('idform');
        var formData = new FormData($('#formHapus_' + idform)[0]);

        var url = "{{ url('/hapusinformasi') }}";
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
          ignore: ".ignore",
          rules: {
            'judul[]': {
              required: true
            },
            'ket[]': {
              required: true
            },
            'isi[]': {
              required: true
            }
          },
          messages: {
            'judul[]': {
              required: "Judul tidak boleh kosong"
            },
            'ket[]': {
              required: "Ringkasan tidak boleh kosong"
            },
            'isi[]': {
              required: "Isi tidak boleh kosong"
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

            var url = "{{ url('/updateinformasi') }}";
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
          ignore: ".ignore",
          rules: {
            judul_add: {
              required: true
            },
            ket_add: {
              required: true
            },
            isi_add: {
              required: true
            },
            gambar_add: {
              required: true
            }
          },
          messages: {
            judul_add: {
              required: "Judul tidak boleh kosong"
            },
            ket_add: {
              required: "Ringkasan tidak boleh kosong"
            },
            gambar_add: {
              required: "Gambar tidak boleh kosong"
            },
            isi_add: {
              required: "Isi tidak boleh kosong"
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

            var url = "{{ url('storeinformasi') }}";
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
</script>

@endsection