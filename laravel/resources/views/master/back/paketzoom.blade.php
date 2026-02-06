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
<h1 class="m-0">Paket Zoom</h1>
@endsection

@section('contentheadermenu')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a class="_kembali" href="{{url('paketmst')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</a></li>
</ol>
@endsection

@section('content')
  
<script>
  kategoris = [];
  @php
    if($kategoris){
      echo '
  katroot = ['.implode(",", $kategoris[0]).'];
  ';

      foreach($kategoris as $id=>$kategori){
        if($id){
          $items = $kategori['items'] ? implode(',', $kategori['items']) : '';
          echo '
  kategoris['.$id.'] = {
  "name": "'.$kategori['name'].'",
  "items": ['.$items.']
  };';        
        }
      }
    }
  @endphp

</script>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="row">
                    <div class="col-sm-2">Judul Paket</div>
                    <div class="col-sm-10">: {{$datamst->judul}}</div>
                </div>
                <!-- <div class="row">
                    <div class="col-sm-2">Tanggal</div>
                    <div class="col-sm-10">: {{tglIndo($datamst->mulai)}} - {{tglIndo($datamst->selesai)}}</div>
                </div> -->
              </div>
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
                    <th>Judul</th>
                    <th>Link</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($data as $key)
                  <tr>
                    <td width="1%">{{$loop->iteration}}</td>
                    <td width="10%">{{$key->judul}}</td>
                    <td class="_align_center" width="10%"><a target="_blank" href="{{asset($key->link)}}">Link</a></td>
                    <td>{{$key->ket}}</td>
                    <td width="1%" class="_align_center">
                      <div class="btn-group">
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
            
            <div class="modal-body">
              <!-- <div class="card-body"> -->
              <div class="katsel">
                @php                  
                  $kats = [];
                  $id   = $key->kategori_id;
                  while($id>0){
                    $kats[] = $id;
                    $id = isset($kategoris[$id]) ? $kategoris[$id]['parent_id'] : '0';
                  }

                  $s = '';
                  $i = count($kats);

                  if($i>1){
                    $i--;
                    while($i>0){
                      $pid = $kats[$i];
                      $i--;
                      $id = $kats[$i];
                      $s.= '<div class="form-group">';
                      if(!isset($kategoris[$pid]))$s.= '<label for="kategori_edit">Kategori<span class="bintang">*</span></label>';
                      $s.= '<select class="form-control" name="kategori[]" onchange="kategorichanged(this);">';
                      if(!isset($kategoris[$pid])){
                        $s.= '<option value="0">[ Tanpa Kategori ]</option>';
                        $items = $kategoris[0];
                      }else{
                        $items = $kategoris[$pid]['items'];
                      }
                      foreach($items as $item){
                        $sel = $id===$item ? ' selected' : '';
                        $s.= '<option value="'.$item.'"'.$sel.'>'.$kategoris[$item]['name'].'</option>';
                      }
                      $s.= '</select>
                    </div>';
                    }      
                  }else{

                    $s.= '
                    <div class="form-group">
                    <label for="kategori_edit">Kategori<span class="bintang">*</span></label>
                    <select class="form-control" name="kategori[]" onchange="kategorichanged(this);">';
                    $s.= '
                      <option value="0">[ Tanpa Kategori ]</option>
                      ';
                    $i = 0;
                    foreach($kategoris[0] as $id){
                      $s.= '
                      <option value="'.$id.'">'.$kategoris[$id]['name'].'</option>
                      ';
                      $i++;
                    }
                    $s.= '</select>
                  </div>';

                  }

                  echo $s;
                @endphp
              </div>

                <div class="form-group">
                    <label for="judul_{{$key->id}}">Judul<span class="bintang">*</span></label>
                    <input type="text" class="form-control" id="judul_{{$key->id}}" name="judul[]" placeholder="Judul" value="{{$key->judul}}">
                </div>

                <div class="form-group">
                    <label for="link_{{$key->id}}">Link<span class="bintang">*</span></label>
                    <input type="text" class="form-control" id="link_{{$key->id}}" name="link[]" placeholder="Link" value="{{$key->link}}">
                </div>
                
                <div class="form-group">
                    <label for="ket_{{$key->id}}">Keterangan</label>
                    <textarea name="ket[]" id="ket_{{$key->id}}" rows="5" class="form-control content_" placeholder="Keterangan">{{$key->ket}}</textarea>  
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
                <h6> Apakah anda ingin menghapus zoom {{$key->judul}}?</h6>
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
              <input type="hidden" class="form-control" id="fk_paket_mst" name="fk_paket_mst" value="{{$idmst}}">

              <div class="katsel">
              <div class="form-group">
                <label for="kategori_add">Kategori<span class="bintang">*</span></label>
                <select class="form-control" id="kategori_add" name="kategori[]" onchange="kategorichanged(this);">
                <option value="0">[ Tanpa Kategori ]</option>
                @php
                  $i = 0;
                  foreach($kategoris[0] as $id){
                    echo '
                    <option value="'.$id.'">'.$kategoris[$id]['name'].'</option>
                    ';
                    $i++;
                  }
                @endphp
                </select>
              </div> 
              </div>

              <div class="form-group">
                <label for="judul_add">Judul<span class="bintang">*</span></label>
                <input type="text" class="form-control" id="judul_add" name="judul_add" placeholder="Judul">
              </div> 

              <div class="form-group">
                <label for="link_add">Link<span class="bintang">*</span></label>
                <input type="text" class="form-control" id="link_add" name="link_add" placeholder="Link">
              </div>

              <div class="form-group">
                <label for="ket_add">Keterangan</label>
                <textarea name="ket_add" id="ket_add" rows="5" class="form-control content_" placeholder="Keterangan"></textarea>  
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
<script>
  $(document).ready(function(){

    // $(".int").on('input paste', function () {
    //   hanyaInteger(this);
    // });
    // bsCustomFileInput.init();
    tablepaketzoom("tabledata");

    //Initialize Select2 Elements

    // $('.mapel').select2({
    //   placeholder: "Pilih Mapel"
    // });

    // $('.paketsoal').select2({
    //   placeholder: "Paket Soal"
    // })

    // $('#jenis_soal_add').on('select2:select', function (e) {
    //     var val = $(this).val();
    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    //     });
    //     $.ajax({
    //         url: '{{url("getPaketSoal")}}/{{$idmst}}',
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

        var url = "{{ url('/hapuspaketzoom') }}/"+idform;
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
            'judul[]': {
              required: true
            },
            'link[]': {
              required: true
            }
          },
          messages: {
            'judul[]': {
              required: "Judul tidak boleh kosong"
            },
            'link[]': {
              required: "Link tidak boleh kosong"
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

            var url = "{{ url('/updatepaketzoom') }}/"+idform;
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
            judul_add: {
              required: true
            },
            link_add: {
              required: true
            }
          },
          messages: {
            judul_add: {
              required: "Judul tidak boleh kosong"
            },
            link_add: {
              required: "Link tidak boleh kosong"
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

            var url = "{{ url('storepaketzoom') }}";
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

  function kategorichanged(elm){
    var parent = elm.parentElement;    
    var katsel = parent.parentElement;
    while(katsel.lastElementChild!==parent)katsel.removeChild(katsel.lastChild);

    var katid = elm.value;

    var len   = katid && kategoris[katid] ? kategoris[katid].items.length : 0;

    if(len>0){      
      var select = document.createElement('SELECT');
      select.setAttribute('class', 'form-control');
      select.setAttribute('name', 'kategori[]');
      select.setAttribute('onchange', 'kategorichanged(this);');
      var e;
      for(let i=0; i<len; i++){
        var id = kategoris[katid].items[i];
        e = document.createElement('OPTION');
        e.setAttribute('value', id);
        if(!i){
          e.setAttribute('selected', 'selected');
        }
        e.innerHTML = kategoris[id].name;
        select.appendChild(e);
      }
      e = document.createElement('DIV');
      e.setAttribute('class', 'form-group');
      e.appendChild(select);
      katsel.appendChild(e);
      kategorichanged(select);
    }

  }

</script>

@endsection