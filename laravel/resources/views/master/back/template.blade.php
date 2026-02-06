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
<h1 class="m-0">Website Setting</h1>
@endsection

@section('contentheadermenu')
<ol class="breadcrumb float-sm-right">
    <!-- <li class="breadcrumb-item"><a href="{{url('pelatihanmst')}}">Pelatihan</a></li> -->
    <li class="breadcrumb-item active">Website</li>
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
                    <th>Nama Website</th>
                    <th>No.Hp</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($template as $key)
                  <tr>
                    <td width="1%">{{$loop->iteration}}</td>
                    <td width="20%">{{$key->nama}}</td>
                    <td width="20%">{{$key->no_hp}}</td>
                    <td width="30%">{{$key->alamat}}</td>
                    <td width="1%" class="_align_center">
                      <div class="btn-group">
                        <span data-toggle="tooltip" data-placement="left" title="Lihat Logo Besar">
                            <button onclick="modalImage('Logo Besar','{{asset($key->logo_besar)}}')" class="btn btn-sm btn-outline-success"><i class="fas fa-eye"></i></button>
                        </span>
                        <span data-toggle="tooltip" data-placement="left" title="Lihat Logo Kecil">
                            <button onclick="modalImage('Logo Kecil','{{asset($key->logo_kecil)}}')" class="btn btn-sm btn-outline-success"><i class="fas fa-eye"></i></button>
                        </span>
                        <span data-toggle="tooltip" data-placement="left" title="Ubah Data">
                          <button data-toggle="modal" data-target="#modal-edit-{{$key->id}}" type="button" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></button>
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
    @foreach($template as $key)                   
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
                    <label for="nama_{{$key->id}}">Nama Website<span class="bintang">*</span></label>
                    <input type="text" class="form-control" id="nama_{{$key->id}}" name="nama[]" placeholder="Nama Website" value="{{$key->nama}}">
                </div> 
                <div class="form-group">
                    <label for="email_{{$key->id}}">Email<span class="bintang">*</span></label>
                    <input type="text" class="form-control" id="email_{{$key->id}}" name="email[]" placeholder="Email" value="{{$key->email}}">
                </div>
                <div class="form-group">
                    <label for="no_hp_{{$key->id}}">No.Hp<span class="bintang">*</span></label>
                    <input type="text" class="form-control int" id="no_hp_{{$key->id}}" name="no_hp[]" placeholder="No.Hp" value="{{$key->no_hp}}">
                </div>
                <div class="form-group">
                    <label>Provinsi<span class="bintang">*</span></label>
                   
                      <select class="form-control form-control-lg _select2" id="fk_provinsi" name="fk_provinsi">
                        <option value=""></option>
                        @foreach($provinsi as $keyprov)
                        <option value="{{$keyprov['province_id']}}" {{$key->fk_provinsi==$keyprov['province_id'] ? "selected" : ""}}>{{$keyprov['province']}}</option>
                        @endforeach
                      </select>
                   
                </div>
                <div class="form-group">
                  <label>Kabupaten/Kota<span class="bintang">*</span></label>
                 
                    <select class="form-control form-control-lg _select2" id="fk_kabupaten" name="fk_kabupaten">
                        <option value=""></option>
                        @if($kabupaten)
                          @foreach($kabupaten as $keykab)
                          <option value="{{$keykab['city_id']}}" {{$keykab["city_id"]==$key->fk_kabupaten ? "selected" : ""}}>{{$keykab['type']." ".$keykab['city_name']}}</option>
                          @endforeach
                        @endif
                    </select>
                
                </div>
                <div class="form-group">
                    <label for="alamat_{{$key->id}}">Alamat</label>
                    <textarea name="alamat[]" id="alamat_{{$key->id}}" rows="5" class="form-control" placeholder="Alamat">{{$key->alamat}}</textarea>  
                </div> 
                <div class="form-group">
                    <label for="copyright_{{$key->id}}">Copyright</label>
                    <textarea name="copyright[]" id="copyright_{{$key->id}}" rows="5" class="form-control" placeholder="Copyright">{{$key->copyright}}</textarea>  
                </div> 
                <!-- <div class="form-group">
                    <label for="meta_desc_{{$key->id}}">Meta Description</label>
                    <textarea name="meta_desc[]" id="meta_desc_{{$key->id}}" rows="5" class="form-control" placeholder="Meta Description">{{$key->meta_desc}}</textarea>  
                </div> 
                <div class="form-group">
                    <label for="meta_key_{{$key->id}}">Meta Keywords</label>
                    <textarea name="meta_key[]" id="meta_key_{{$key->id}}" rows="5" class="form-control" placeholder="Meta Keywords">{{$key->meta_key}}</textarea>  
                </div>
                <div class="form-group">
                    <label for="tentang_kami_{{$key->id}}">Tentang Kami</label>
                    <textarea name="tentang_kami[]" id="tentang_kami_{{$key->id}}" rows="5" class="form-control content_" placeholder="Tentang Kami">{{$key->tentang_kami}}</textarea>  
                </div>  
                 -->
                <div class="form-group">
                  <label for="logo_besar">Logo Besar <span class="input-keterangan">(jpg/jpeg/png)</span></label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input input-foto" idlabel="label-logo_besar-{{$key->id}}" name="logo_besar[]" id="logo_besar-{{$key->id}}">
                      <label id="label-logo_besar-{{$key->id}}" class="custom-file-label" for="logo_besar">Pilih File</label>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label for="logo-kecil">Logo Kecil <span class="input-keterangan">(jpg/jpeg/png)</span></label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input input-foto" idlabel="label-logo-kecil-{{$key->id}}" name="logo_kecil[]" id="logo-kecil-{{$key->id}}">
                      <label id="label-logo-kecil-{{$key->id}}" class="custom-file-label" for="logo-kecil">Pilih File</label>
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


    <!-- /.Modal Hapus -->
@endforeach


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
<script src="https://cdn.tiny.cloud/1/vg8mb8jm0n4hdtgx0a7r21ra3zxkjjn6c1z4xzejzsqdoqds/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  $(document).ready(function(){
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    bsCustomFileInput.init();
    $(document).on('change', '.input-foto', function (e) {
        var idphoto = $(this).attr('id');
        onlyPhoto(idphoto);
    });

    datatabletmp("tabledata");

    $(".int").on('input paste', function () {
      hanyaAngka(this);
    });

    $('#fk_provinsi').select2({
      placeholder: "Silahkan Pilih Provinsi"
    });

    $( "#fk_kabupaten" ).select2({
          placeholder: "Silahkan Pilih Kabupaten/Kota",
          ajax: { 
          url: "{{url('getkabupatenro')}}",
          type: "post",
          dataType: 'json',
          delay: 100,
          data: function (params) {
              return {
              _token: CSRF_TOKEN,
              search: params.term, // search term
              provid:$("#fk_provinsi").val()
              };
          },
          processResults: function (response) {
            return {
                results: $.map(response.data, function (item) {
                    return {
                        text: item.type+" "+item.city_name,
                        id: item.city_id
                    }
                })
            };
          },
          cache: true
          }
      }); 

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
 

    // Fungsi Ubah Data
    $(document).on('click', '.btn-submit-data', function (e) {
        idform = $(this).attr('idform');
        $('#formData_'+idform).validate({
          rules: {
            'nama[]': {
              required: true
            },
            'email[]': {
              required: true
            },
            'no_hp[]': {
              required: true
            },
            fk_provinsi: {
              required: true
            },
            fk_kabupaten: {
              required: true
            }
          },
          messages: {
            'nama[]': {
              required: "Nama website tidak boleh kosong"
            },
            'email[]': {
              required: "Email tidak boleh kosong"
            },
            'no_hp[]': {
              required: "No.Hp tidak boleh kosong"
            },
            fk_provinsi: {
              required: "Provinsi tidak boleh kosong"
            },
            fk_kabupaten: {
              required: "Kabupaten tidak boleh kosong"
            }
          },
          errorElement: 'span',
          errorPlacement: function (error, element) {
              if (element.hasClass('select')) {     
                  element.parent().addClass('select2-error');
                  error.addClass('invalid-feedback');
                  element.closest('.form-group').append(error);
              }else if (element.hasClass('input-foto')){
                  element.parent().addClass('input-foto-error');
                  error.addClass('invalid-feedback');
                  element.closest('.form-group').append(error);
              }else {                                      
                  error.addClass('invalid-feedback');
                  element.closest('.form-group').append(error);
              }
          },
          highlight: function (element, errorClass, validClass) {
              $(element).addClass('is-invalid');
              if(element.tagName.toLowerCase()=='select'){
              var x = element.getAttribute('id');
              $('#'+x).parent().addClass('select2-error');
              }else if(element.tagName.toLowerCase()=='input'){
              var x = element.getAttribute('class');
              var z = element.getAttribute('id');
              if(x=="input-foto is-invalid"){
                  $('#'+z).parent().addClass('input-foto-error');
              }
              }
          },
          unhighlight: function (element, errorClass, validClass) {
              $(element).removeClass('is-invalid');
              if(element.tagName.toLowerCase()=='select'){
              var x = element.getAttribute('id');
              $('#'+x).parent().removeClass('select2-error');
              }else if(element.tagName.toLowerCase()=='input'){
              var x = element.getAttribute('class');
              var z = element.getAttribute('id');
              if(x=="input-foto"){
                  $('#'+z).parent().removeClass('input-foto-error');
              }
              }
          },

          submitHandler: function () {
          
            var formData = new FormData($('#formData_'+idform)[0]);

            var url = "{{ url('updatetemplate') }}/"+idform;
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


  });
</script>

@endsection