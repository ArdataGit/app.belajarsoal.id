@extends('layouts.Skydash')
<!-- partial -->
@section('content')
<style>
  .select2-container--default .select2-selection--single {
      border: 1px solid #CED4DA !important;
  }
  .select2-container .select2-selection--single .select2-selection__rendered {
    padding-left: 0px !important;
  }
  .custom-file-label {
    padding: 0.375rem 20px;
  }
</style>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<div class="content-wrapper">
  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-12 col-xl-12 mb-4 mb-xl-0">
          <h3 class="font-weight-bold">Tambah Alamat</h3>
          <!-- <h6 class="font-weight-normal mb-0">Sudah siap belajar apa hari ini? Jangan lupa semangat karena banyak latihan dan tryout yang masih menunggu untuk diselesaikan.</h6> -->
        </div>
        <div class="col-12 col-xl-4">
          <div class="justify-content-end d-flex">
          <!-- <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
            <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
              <i class="mdi mdi-calendar"></i> Today (10 Jan 2021)
            </button>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
              <a class="dropdown-item" href="#">January - March</a>
              <a class="dropdown-item" href="#">March - June</a>
              <a class="dropdown-item" href="#">June - August</a>
              <a class="dropdown-item" href="#">August - November</a>
            </div>
          </div> -->
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">

        <!-- <ul class="nav nav-pills btn-menu-hasil" role="tablist">
          <li class="nav-item">
            <a class="btn btn-primary nav-link btn-tab-hasil active" data-toggle="pill" href="#profiltab">Profil</a>
          </li>
          <li class="nav-item">
            <a class="btn btn-primary nav-link btn-tab-hasil" data-toggle="pill" href="#passwordtab">Password</a>
          </li>
        </ul> -->

        <!-- Tab panes -->
        <div class="tab-content tab-hasil-ujian">
          <div id="profiltab" class="tab-pane active"><br>
              <form id="formUserSetting" class="form-horizontal" method="post">
                    @csrf
                      <!-- <div class="form-group row"`>
                        <label for="username" class="col-sm-2 col-form-label">Username/Email</label>
                        <div class="col-sm-10">
                          <input readonly type="text" name="username" class="form-control" id="username" placeholder="Username" value="{{ Auth::user()->username }}">
                        </div>
                      </div> -->

                      <!-- <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                          <input name="email" type="email" class="form-control" id="email" placeholder="Email" value="{{ Auth::user()->email }}"> 
                        </div>
                      </div> -->
                      <div class="form-group row">
                        <label for="nama_penerima" class="col-sm-2 col-form-label">Nama Penerima</label>
                        <div class="col-sm-10">
                          <input name="nama_penerima" type="text" class="form-control" id="nama_penerima" placeholder="Nama Penerima"> 
                        </div>
                      </div>
                      <!-- <div class="form-group row">
                        <label for="jenis_kelamin" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-10">
                          <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option {{ Auth::user()->jenis_kelamin=='l' ? 'selected' : '' }} value="l">Laki-laki</option>
                            <option {{ Auth::user()->jenis_kelamin=='p' ? 'selected' : '' }} value="p">Perempuan</option>
                          </select>
                        </div>
                      </div> -->

                      <div class="form-group row">
                        <label for="no_hp_penerima" class="col-sm-2 col-form-label">Nomor Hp</label>
                        <div class="col-sm-10">
                          <input name="no_hp_penerima" type="text" class="form-control int" id="no_hp_penerima" placeholder="Nomor Hp"> 
                        </div>
                      </div>

                    

                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Provinsi</label>
                        <div class="col-sm-10">
                          <select class="form-control form-control-lg _select2" id="provinsi" name="provinsi">
                            <option value=""></option>
                            @foreach($provinsi as $key)
                            <option value="{{$key['province_id']}}">{{$key['province']}}</option>
                            @endforeach
                          </select>
                        </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Kabupaten/Kota</label>
                      <div class="col-sm-10">
                        <select class="form-control form-control-lg _select2" id="kabupaten" name="kabupaten">
                          <option value=""></option>
                        </select>
                      </div>
                    </div>

                    <div class="form-group row">
                        <label for="alamat_lengkap" class="col-sm-2 col-form-label">Alamat Lengkap</label>
                        <div class="col-sm-10">
                          <textarea name="alamat_lengkap" id="alamat_lengkap" rows="5" class="form-control" placeholder="Alamat Lengkap"></textarea>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="kode_pos" class="col-sm-2 col-form-label">Kode POS</label>
                        <div class="col-sm-10">
                          <input name="kode_pos" type="text" class="form-control int" id="kode_pos" placeholder="Kode POS" maxlength="10"> 
                        </div>
                      </div>

                    <!-- <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Kecamatan</label>
                      <div class="col-sm-10">
                        <select class="form-control form-control-lg _select2" id="kecamatan" name="kecamatan">
                          @php
                          $kec = App\Models\MasterKecamatan::where('id_kab',Auth::user()->kabupaten)->get();
                          @endphp
                          <option value=""></option>
                          @foreach($kec as $data)
                          <option value="{{$data->id_kec}}" {{Auth::user()->kecamatan==$data->id_kec ? 'selected' : ''}}>{{$data->nama}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div> -->
                      <!-- <div class="form-group row">
                        <label for="ttl" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="ttl" id="ttl" placeholder="Tanggal Lahir" value="{{tglEdit(Auth::user()->ttl)}}"> 
                        </div>
                      </div> -->
                    
                   
                      <!-- <div class="form-group row" style="align-items:center">
                        <label class="col-sm-2 col-form-label">Photo<br><span class="input-keterangan">(jpg/jpeg/png)</span></label>
                        <div class="col-sm-10">
                          <div class="input-group">
                            <div class="custom-file">
                              <input type="file" class="input-foto" id="photo" name="photo" idlabel="label-photo">
                              <label id="label-photo" class="custom-file-label" style="border-radius: .25rem;" for="photo">Choose file</label>
                            </div>
                          </div> 
                        </div>
                      </div> -->
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10 _align_right">
                          <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                      </div>
                    </form>
                  </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('footer')
<!-- jQuery -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- jquery-validation -->
<script src="{{ asset('layout/adminlte3/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/jquery-validation/additional-methods.min.js') }}"></script>
<!-- Custom Input File -->
<script src="{{ asset('layout/adminlte3/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
  $(document).ready(function(){
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    bsCustomFileInput.init();

    // getKabupaten('provinsi','kabupaten','kecamatan','{{ url("/getKabupaten") }}','{{asset("/image/global/loading.gif")}}');
    //     getKecamatan('kabupaten','kecamatan','{{ url("/getKecamatan") }}','{{asset("/image/global/loading.gif")}}');

    $(".int").on('input paste', function () {
      hanyaAngka(this);
    });

    $('#provinsi').select2({
      placeholder: "Silahkan Pilih Provinsi"
    });

      // $( "#provinsi" ).select2({
      //     placeholder: "Silahkan Pilih Provinsi",
      //     ajax: { 
      //     url: "{{url('getprovinsiro')}}",
      //     type: "post",
      //     dataType: 'json',
      //     delay: 100,
      //     data: function (params) {
      //         return {
      //         _token: CSRF_TOKEN,
      //         search: params.term 
      //         };
      //     },
      //     processResults: function (response) {
      //       return {
      //           results: $.map(response.data, function (item) {
      //               return {
      //                   text: item.province,
      //                   id: item.province_id
      //               }
      //           })
      //       };
      //     },
      //     cache: true
      //     }
      // }); 

      $( "#kabupaten" ).select2({
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
              provid:$("#provinsi").val()
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

      $( "#provinsi" ).on('select2:select', function (e) {
        $('#kabupaten').empty();
      });

    $('#formUserSetting').validate({
      rules: {
        nama_penerima :{
          required:true
        },
        no_hp_penerima :{
          required:true
        },
        provinsi :{
          required:true
        },
        kabupaten :{
          required:true
        },
        kode_pos :{
          required:true
        },
        alamat_lengkap :{
          required:true
        }
      },
      messages: {
        nama_penerima : {
          required: "Nama penerima tidak boleh kosong"
        },
        no_hp_penerima : {
          required: "Nomor whatsapp tidak boleh kosong"
        },
        provinsi : {
          required: "Provinsi tidak boleh kosong"
        },
        kabupaten : {
          required: "Kabupaten/Kota tidak boleh kosong"
        },
        kode_pos : {
          required: "Kode POS tidak boleh kosong"
        },
        alamat_lengkap : {
          required: "Alamat lengkap tidak boleh kosong"
        }
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
          if (element.hasClass('select')) {     
              element.parent().addClass('select2-error');
              error.addClass('invalid-feedback');
              element.closest('.col-sm-10').append(error);
          }else if (element.hasClass('input-foto')){
              element.parent().addClass('input-foto-error');
              error.addClass('invalid-feedback');
              element.closest('.col-sm-10').append(error);
          }else {                                      
              error.addClass('invalid-feedback');
              element.closest('.col-sm-10').append(error);
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

        var formData = new FormData($('#formUserSetting')[0]);

        var url = "{{ url('/simpanalamat') }}";
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
                // $.LoadingOverlay("show");
            },
            success: function (response) {
                if (response.status == true) {
                  Swal.fire({
                      html: response.message,
                      icon: 'success',
                      showConfirmButton: false
                    });
                    reload_url(1000,"{{url('listalamat')}}");
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
                // $.LoadingOverlay("hide");
            }
        });

        }

    });

  });
</script>
<!-- Loading Overlay -->
@endsection


