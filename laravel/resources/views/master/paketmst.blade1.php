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



<h1 class="m-0">Paket</h1>



@endsection







@section('contentheadermenu')



<ol class="breadcrumb float-sm-right">



  <!-- <li class="breadcrumb-item">Master</li> -->



  <li class="breadcrumb-item active">Paket</li>



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



              <button data-toggle="modal" data-target="#modal-tambah" type="button" class="btn btn-sm btn-primary">



                <i class="fa fa-plus" aria-hidden="true"></i>



              </button>



            </span>



            <!-- <button data-toggle="modal" data-target="#modal-tambah" type="button" class="btn btn-md btn-primary btn-absolute">Tambah</button> -->



            <table id="tabledata" class="table  table-striped">



              <thead>



                <tr>



                  <th>No</th>



                  <th>Judul</th>



                  <!-- <th>Tanggal</th> -->



                  <th>Keterangan</th>



                  <th>Harga</th>



                  <th>Aksi</th>



                </tr>



              </thead>



              <tbody>



                @foreach($data as $key)



                <tr>



                  <td width="1%">{{$loop->iteration}}</td>



                  <td width="20%">{{$key->judul}}</td>



                  <!-- <td style="white-space:nowrap"width="15%" class="_align_center"><span class="d-none">{{$key->mulai}}</span>{{tglIndoSingkat($key->mulai)}} - {{tglIndoSingkat($key->selesai)}}</td> -->



                  <td>{!!$key->ket!!}</td>



                  <td width="15%" class="_bold _align_right"><span class="d-none">{{$key->harga}}</span>{{$key->is_gratis==1 ? "Gratis" : formatRupiah($key->harga)}}</td>



                  <td width="1%" class="_align_center">



                    <div class="btn-group">



                      <span data-toggle="tooltip" data-placement="left" title="Fitur">



                        <a href="{{url('paketfitur')}}/{{$key->id}}" class="btn btn-sm btn-outline-primary"><i class="fas fa-list-ol"></i></a>



                      </span>



                      <span data-toggle="tooltip" data-placement="left" title="Materi">



                        <a href="{{url('paketmateri')}}/{{$key->id}}" class="btn btn-sm btn-outline-primary"><i class="far fa-newspaper"></i></a>



                      </span>



                      <span data-toggle="tooltip" data-placement="left" title="Zoom">



                        <a href="{{url('paketzoom')}}/{{$key->id}}" class="btn btn-sm btn-outline-primary"><i class="fas fa-chalkboard-teacher"></i></a>



                      </span>
					  
                      <span data-toggle="tooltip" data-placement="left" title="Mentor Class">



                        <a href="{{url('paketkelas')}}/{{$key->id}}" class="btn btn-sm btn-outline-primary"><i class="fas fa-video-camera"></i></a>



                      </span>
					  

                      <span data-toggle="tooltip" data-placement="left" title="Detail Paket">



                        <a href="{{url('paketdtl')}}/{{$key->id}}" class="btn btn-sm btn-outline-success"><i class="fas fa-th-list"></i></a>



                      </span>



                      <span data-toggle="tooltip" data-placement="left" title="Ubah Data">



                        <button data-toggle="modal" data-target="#modal-edit-{{$key->id}}" type="button" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></button>



                      </span>



                      @php



                      $cekdata = App\Models\Transaksi::where('fk_paket_mst',$key->id)->whereNull('deleted_by')->get();



                      @endphp



                      @if(count($cekdata)<=0) <span data-toggle="tooltip" data-placement="left" title="Hapus Data">



                        <button data-toggle="modal" data-target="#modal-hapus-{{$key->id}}" type="button" class="btn btn-sm btn-outline-danger"><i class="far fa-trash-alt"></i></button>



                        </span>



                        @else



                        <span data-toggle="tooltip" data-placement="left" title="Data tidak bisa dihapus karena sudah ada yang membeli / sedang membeli paket ini">



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



      <form method="post" id="formData_{{$key->id}}" class="form-horizontal">



        @csrf



        <div class="modal-body">



          <!-- <div class="card-body"> -->



          <div class="form-group">



            <label for="fk_paket_kategori_{{$key->id}}">Kategori Paket<span class="bintang">*</span></label>



            <select class="form-control fk_paket_kategori" name="fk_paket_kategori[]" id="fk_paket_kategori_{{$key->id}}" idsub="#fk_paket_subkategori_{{$key->id}}">



              <option value=""></option>



              @foreach($kategori as $keydata)



              <option value="{{$keydata->id}}" {{$keydata->id==$key->fk_paket_kategori ? "selected" : ""}}>{{$keydata->judul}}</option>



              @endforeach



            </select>



          </div>



          @php



          $subkategori = App\Models\PaketSubkategori::where('fk_paket_kategori',$key->fk_paket_kategori)->get();



          @endphp



          <div class="form-group">



            <label for="fk_paket_subkategori_{{$key->id}}">Subkategori Paket<span class="bintang">*</span></label>



            <select class="form-control fk_paket_subkategori" name="fk_paket_subkategori[]" id="fk_paket_subkategori_{{$key->id}}">



              <option value=""></option>



              @foreach($subkategori as $keydata)



              <option value="{{$keydata->id}}" {{$keydata->id==$key->fk_paket_subkategori ? "selected" : ""}}>{{$keydata->judul}}</option>



              @endforeach



            </select>



          </div>



          <div class="form-group">



            <label for="judul_{{$key->id}}">Judul<span class="bintang">*</span></label>



            <input type="text" class="form-control" id="judul_{{$key->id}}" name="judul[]" placeholder="Judul" value="{{$key->judul}}">



          </div>



          <div class="form-group">
    <label>Paket Gratis<span class="bintang">*</span></label>
    <br>
    <div class="form-check form-check-inline">
        <input class="form-check-input is_gratis" type="radio" name="is_gratis[]" value="1" harga="form-harga-{{$key->id}}" {{$key->is_gratis==1 ? "checked" : ""}}>
        <label class="form-check-label">Ya</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input is_gratis" type="radio" name="is_gratis[]" value="0" harga="form-harga-{{$key->id}}" {{$key->is_gratis==0 ? "checked" : ""}}>
        <label class="form-check-label">Tidak</label>
    </div>
    <br>
</div>

<!-- Input field untuk password -->
<div class="form-group {{$key->is_gratis==1 ? '' : 'd-none'}}" id="form-password-{{$key->id}}">
    <label for="password_{{$key->id}}">Password<span class="bintang">*</span></label>
    <input type="text" class="form-control" id="password_{{$key->id}}" name="password[]" placeholder="Password" value="{{$key->password}}">
</div>



          <div class="form-group {{$key->is_gratis==1 ? 'd-none' : ''}}" id="form-harga-{{$key->id}}">



            <label for="harga_{{$key->id}}">Harga<span class="bintang">*</span></label>



            <input type="text" class="form-control int" id="harga_{{$key->id}}" name="harga[]" placeholder="Harga" value="{{$key->harga}}">



          </div>







          <!-- <label>Tanggal<span class="bintang">*</span></label>



                <div class="row">



                  <div class="col-6">



                    <div class="form-group">



                      <input value="{{tglEdit($key->mulai)}}" type="text" class="form-control tgl" name="mulai[]" id="mulai_{{$key->id}}" placeholder="Mulai"> 



                    </div>



                  </div>



                  <div class="col-6">



                    <div class="form-group">



                      <input value="{{tglEdit($key->selesai)}}" type="text" class="form-control tgl" name="selesai[]" id="selesai_{{$key->id}}" placeholder="Selesai"> 



                    </div>



                  </div>



                </div>



                



                <label>Tanggal Pendaftaran<span class="bintang">*</span></label>



                <div class="row">



                  <div class="col-6">



                    <div class="form-group">



                      <input value="{{datetimeedit($key->mulai_daftar)}}" type="text" class="form-control waktu" name="mulai_daftar[]" id="mulai_daftar_{{$key->id}}" placeholder="Mulai Daftar"> 



                    </div>



                  </div>



                  <div class="col-6">



                    <div class="form-group">



                      <input value="{{datetimeedit($key->selesai_daftar)}}" type="text" class="form-control waktu" name="selesai_daftar[]" id="selesai_daftar_{{$key->id}}" placeholder="Selesai Daftar"> 



                    </div>



                  </div>



                </div>  -->



          <div class="form-group">



     <!--       <label>Banner <span class="input-keterangan">(jpg/jpeg/png)</span></label>



            <div class="input-group">



              <div class="custom-file">



                <input type="file" class="input-foto custom-file-input" id="banner_{{$key->id}}" name="banner[]" idlabel="label-banner-{{$key->id}}">



                <label id="label-banner-{{$key->id}}" class="custom-file-label" style="border-radius: .25rem;">Pilih file</label>



              </div>



            </div>



          </div>



          <div class="form-group">



            <label>Juknis <span class="input-keterangan">(pdf)</span></label>



            <div class="input-group">



              <div class="custom-file">



                <input type="file" class="input-pdf custom-file-input" name="juknis[]" id="juknis_{{$key->id}}" idlabel="label-juknis-{{$key->id}}">



                <label id="label-juknis-{{$key->id}}" class="custom-file-label">Choose file</label>



              </div>



            </div> -->



          </div>



          <!-- <div class="form-group">



                  <label for="syarat_{{$key->id}}">Syarat</label><br>



                  <input type="checkbox" name="syarat[]" data-on-text="Ya" data-off-text="Tidak" data-bootstrap-switch data-off-color="danger" data-on-color="success" {{$key->syarat=="1" ? "checked" : ""}}>



                </div>   -->



          <div class="form-group">



            <label for="ket_{{$key->id}}">Keterangan</label>



            <textarea name="ket[]" id="ket_{{$key->id}}" rows="5" class="form-control content_" placeholder="Keterangan">{{$key->ket}}</textarea>



          </div>



          <div class="form-group">



            <label for="status_{{$key->id}}">Tampil</label>



            <select name="status[]" id="status_{{$key->id}}" class="form-control">



              <option value="0" {{$key->status==0 ? "selected" : ""}}>Tidak</option>



              <option value="1" {{$key->status==1 ? "selected" : ""}}>Ya</option>



            </select>



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



          <h6> Apakah anda ingin menghapus paket {{$key->judul}}?</h6>



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



          <div class="form-group">



            <label for="fk_paket_kategori_add">Kategori Paket<span class="bintang">*</span></label>



            <select class="form-control fk_paket_kategori" name="fk_paket_kategori_add" id="fk_paket_kategori_add" idsub="#fk_paket_subkategori_add">



              <option value=""></option>



              @foreach($kategori as $keydata)



              <option value="{{$keydata->id}}">{{$keydata->judul}}</option>



              @endforeach



            </select>



          </div>



          <div class="form-group">



            <label for="fk_paket_subkategori_add">Subkategori Paket<span class="bintang">*</span></label>



            <select class="form-control fk_paket_subkategori" name="fk_paket_subkategori_add" id="fk_paket_subkategori_add">



              <option value=""></option>



            </select>



          </div>



          <div class="form-group">



            <label for="judul_add">Judul<span class="bintang">*</span></label>



            <input type="text" class="form-control" id="judul_add" name="judul_add" placeholder="Judul">



          </div>



         <div class="form-group">
    <label>Paket Gratis<span class="bintang">*</span></label>
    <br>
    <div class="form-check form-check-inline">
        <input class="form-check-input is_gratis" type="radio" name="is_gratis_add" value="1" harga="form-harga-add">
        <label class="form-check-label">Ya</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input is_gratis" type="radio" name="is_gratis_add" value="0" harga="form-harga-add">
        <label class="form-check-label">Tidak</label>
    </div>
    <br>
</div>

<!-- Input field untuk password -->
<div class="form-group d-none" id="form-password-add">
    <label for="password_add">Password<span class="bintang">*</span></label>
    <input type="text" class="form-control" id="password_add" name="password_add" placeholder="Password">
</div>




          <div class="form-group d-none" id="form-harga-add">



            <label for="harga_add">Harga<span class="bintang">*</span></label>



            <input type="text" class="form-control int" id="harga_add" name="harga_add" placeholder="Harga" value="0">



          </div>



          <!-- <label>Tanggal<span class="bintang">*</span></label>



              <div class="row">



                <div class="col-6">



                  <div class="form-group">



                    <input type="text" class="form-control tgl" name="mulai_add" id="mulai_add" placeholder="Mulai"> 



                  </div>



                </div>



                <div class="col-6">



                  <div class="form-group">



                    <input type="text" class="form-control tgl" name="selesai_add" id="selesai_add" placeholder="Selesai"> 



                  </div>



                </div>



              </div>



              <label>Tanggal Pendaftaran<span class="bintang">*</span></label>



              <div class="row">



                <div class="col-6">



                  <div class="form-group">



                    <input type="text" class="form-control waktu" name="mulai_daftar_add" id="mulai_daftar_add" placeholder="Mulai Daftar"> 



                  </div>



                </div>



                <div class="col-6">



                  <div class="form-group">



                    <input type="text" class="form-control waktu" name="selesai_daftar_add" id="selesai_daftar_add" placeholder="Selesai Daftar"> 



                  </div>



                </div>



              </div> -->



          <!-- <div class="form-group">



                <label for="syarat_add">Syarat</label><br>



                <input type="checkbox" name="syarat_add" data-on-text="Ya" data-off-text="Tidak" data-bootstrap-switch data-off-color="danger" data-on-color="success">



              </div>  -->



            <!--<div class="form-group">



            <label>Banner<span class="bintang"></span> <span class="input-keterangan">(jpg/jpeg/png)</span></label>



            <div class="input-group">



              <div class="custom-file">



                <input type="file" class="input-foto custom-file-input" id="banner_add" name="banner_add" idlabel="label-banner-add">



                <label id="label-banner-add" class="custom-file-label" style="border-radius: .25rem;">Pilih file</label>



              </div>



            </div>



          </div>



          <div class="form-group">



            <label>Juknis <span class="input-keterangan">(pdf)</span></label>



            <div class="input-group">



              <div class="custom-file">



                <input type="file" class="input-pdf custom-file-input" name="juknis_add" id="juknis_add" idlabel="label-juknis-add">



                <label id="label-juknis-add" class="custom-file-label">Choose file</label>



              </div>



            </div>



          </div> -->



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



<!-- Tinymce -->



<script src="{{ asset('plugins/ckeditor/ckeditor.js') }}" referrerpolicy="origin"></script>



<!-- Bootstrap Switch -->



<script src="{{ asset('layout/adminlte3/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>



<script>

$(".is_gratis").on('change', function() {
    
       $('.content_').each(
      function(){
        CKEDITOR.replace($(this).attr('id'));  
      }
    );
    
    value = $(this).val();
    idpassword = $(this).attr('harga').replace('form-harga', 'form-password');
    if (value == 1) {
        $("#" + idpassword).removeClass('d-none');
    } else {
        $("#" + idpassword).addClass('d-none');
    }
});


  $(document).ready(function() {



    $(".is_gratis").on('change', function() {



      value = $(this).val();



      idharga = $(this).attr('harga');



      if (value == 1) {

        $("#" + idharga).addClass('d-none');

      } else {

        $("#" + idharga).removeClass('d-none');

      }



    });



    $('.fk_paket_subkategori').select2({



      placeholder: "Pilih Subkategori Paket"



    });







    $('.fk_paket_kategori').select2({



      placeholder: "Pilih Kategori Paket"



    });







    $('.fk_paket_kategori').on('select2:select', function(e) {



      var val = $(this).val();



      var idsub = $(this).attr('idsub');



      $.ajaxSetup({



        headers: {



          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')



        }



      });



      $.ajax({



        url: "{{url('getsubkategori')}}",



        type: 'POST',



        dataType: "JSON",



        data: {



          "val": val



        },



        beforeSend: function() {



          $.LoadingOverlay("show");



        },



        success: function(response) {



          if (response.status == true) {



            $(idsub).html("");



            $(idsub).select2({



              data: response.datasub



            })



          } else {



            Swal.fire({



              title: "Error!!!",



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







    $("input[data-bootstrap-switch]").each(function() {



      $(this).bootstrapSwitch('state', $(this).prop('checked'));



    })







    $(".int").on('input paste', function() {



      hanyaInteger(this);



    });



    $(".waktu").flatpickr({



      enableTime: true,



      dateFormat: "d-m-Y H:i",



      disableMobile: "true",



      time_24hr: true



    });



    $(".tgl").flatpickr({



      dateFormat: "d-m-Y",



      disableMobile: "true"



    });



    // bsCustomFileInput.init();



    datatablemasterevent("tabledata");














    //Initialize Select2 Elements



    // $('.select2bs4').select2({



    //   placeholder: "Jenis",



    //   allowClear: true,



    //   theme: 'bootstrap4'



    // })







    bsCustomFileInput.init();



    $(document).on('change', '.input-foto', function(e) {



      var idphoto = $(this).attr('id');



      onlyPhoto(idphoto);



    });



    $(document).on('change', '.input-pdf', function(e) {



      var idphoto = $(this).attr('id');



      onlyPdf(idphoto);



    });







    // $(document).on('change', '.input-photo', function (e) {



    //     var idphoto = $(this).attr('id');



    //     onlyPhoto(idphoto);



    // });







    //Fungsi Hapus Data



    $(document).on('click', '.btn-hapus', function(e) {



      idform = $(this).attr('idform');



      var formData = new FormData($('#formHapus_' + idform)[0]);







      var url = "{{ url('/hapuseventmst') }}/" + idform;



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



          'fk_paket_subkategori[]': {



            required: true



          },



          'fk_paket_kategori[]': {



            required: true



          },



          'judul[]': {



            required: true



          },



          'mulai[]': {



            required: true



          },



          'harga[]': {



            min: 20000,



            required: true



          },



          'selesai[]': {



            required: true



          },



          'mulai_daftar[]': {



            required: true



          },



          'selesai_daftar[]': {



            required: true



          }



        },



        messages: {



          'fk_paket_subkategori[]': {



            required: "Subkategori paket tidak boleh kosong"



          },



          'fk_paket_kategori[]': {



            required: "Kategori paket tidak boleh kosong"



          },



          'judul[]': {



            required: "Judul tidak boleh kosong"



          },



          'harga[]': {



            min: "Harga minimal 20000",



            required: "Harga tidak boleh kosong"



          },



          'mulai[]': {



            required: "Mulai tidak boleh kosong"



          },



          'selesai[]': {



            required: "Selesai tidak boleh kosong"



          },



          'mulai_daftar[]': {



            required: "Mulai daftar tidak boleh kosong"



          },



          'selesai_daftar[]': {



            required: "Selesai daftar tidak boleh kosong"



          }



        },



        errorElement: 'span',



        errorPlacement: function(error, element) {



          if (element.hasClass('_select2')) {



            element.parent().addClass('select2-error');



            error.addClass('invalid-feedback');



            element.closest('.form-group').append(error);



          } else {



            error.addClass('invalid-feedback');



            element.closest('.form-group').append(error);



          }



        },



        highlight: function(element, errorClass, validClass) {



          $(element).addClass('is-invalid');



          if (element.tagName.toLowerCase() == 'select') {



            var x = element.getAttribute('id');



            y = $('#' + x).parent().addClass('select2-error');



          }



        },



        unhighlight: function(element, errorClass, validClass) {



          $(element).removeClass('is-invalid');



          if (element.tagName.toLowerCase() == 'select') {



            var x = element.getAttribute('id');



            y = $('#' + x).parent().removeClass('select2-error');



          }



        },







        submitHandler: function() {







          var formData = new FormData($('#formData_' + idform)[0]);







          var url = "{{ url('/updateeventmst') }}/" + idform;



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







    // Fungsi Add Data



    $('#_formData').validate({



      rules: {



        judul_add: {



          required: true



        },



        is_gratis_add: {



          required: true



        },



        fk_paket_kategori_add: {



          required: true



        },



        fk_paket_subkategori_add: {



          required: true



        },



        harga_add: {



          min: 20000,



          required: true



        },



        // juknis_add: {



        //   required: true



        // },



    //    banner_add: {



      //    required: true



        //},



        mulai_add: {



          required: true



        },



        selesai_add: {



          required: true



        },



        mulai_daftar_add: {



          required: true



        },



        selesai_daftar_add: {



          required: true



        }



      },



      messages: {



        judul_add: {



          required: "Judul tidak boleh kosong"



        },



        is_gratis_add: {



          required: "Paket gratis harus dipilih"



        },



        fk_paket_kategori_add: {



          required: "Kategori paket tidak boleh kosong"



        },



        fk_paket_subkategori_add: {



          required: "Subkategori paket tidak boleh kosong"



        },



        harga_add: {



          min: "Harga minimal 20000",



          required: "Harga tidak boleh kosong"



        },



        //banner_add: {



      //    required: "Banner tidak boleh kosong"



      //  },



        // juknis_add: {



        //   required: "Juknis tidak boleh kosong"



        // },



        mulai_add: {



          required: "Mulai tidak boleh kosong"



        },



        selesai_add: {



          required: "Selesai tidak boleh kosong"



        },



        mulai_daftar_add: {



          required: "Mulai daftar tidak boleh kosong"



        },



        selesai_daftar_add: {



          required: "Selesai daftar tidak boleh kosong"



        }



      },



      errorElement: 'span',



      errorPlacement: function(error, element) {



        if (element.hasClass('_select2')) {



          element.parent().addClass('select2-error');



          error.addClass('invalid-feedback');



          element.closest('.form-group').append(error);



        } else {



          error.addClass('invalid-feedback');



          element.closest('.form-group').append(error);



        }



      },



      highlight: function(element, errorClass, validClass) {



        $(element).addClass('is-invalid');



        if (element.tagName.toLowerCase() == 'select') {



          var x = element.getAttribute('id');



          y = $('#' + x).parent().addClass('select2-error');



        }



      },



      unhighlight: function(element, errorClass, validClass) {



        $(element).removeClass('is-invalid');



        if (element.tagName.toLowerCase() == 'select') {



          var x = element.getAttribute('id');



          y = $('#' + x).parent().removeClass('select2-error');



        }



      },







      submitHandler: function() {







        var formData = new FormData($('#_formData')[0]);







        var url = "{{ url('storeeventmst') }}";



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

</script>







@endsection