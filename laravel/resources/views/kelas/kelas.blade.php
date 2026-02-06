@extends('layouts.Adminlte3')

@section('header')
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome Icons -->
<link rel="stylesheet" href="{{ asset('layout/adminlte3/plugins/fontawesome-free/css/all.min.css') }}">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="{{ asset('layout/adminlte3/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('layout/adminlte3/dist/css/adminlte.min.css') }}">

<link rel="stylesheet" href="{{ asset('layout/adminlte3/plugins/daterangepicker/daterangepicker.css') }}">
<style>

.box-class{
    width:100%;
    overflow-x:hidden;
    overflow-y:visible;
    background:#fff;
    padding:8px;
    border:solid 1px #ddd;
    border-radius:8px;
    margin-bottom:16px;
}    

.box-class-icon{
    float:left;
    width:60px;
    margin:8px 0px 8px 8px;
    padding:8px;
    background-image: linear-gradient(to right, rgba(200,100,255,0.5) , rgba(200,100,255,1));
    text-align:center;    
    border:solid 1px #ddd;
    border-radius:8px;
}

.box-class-icon > .fa{
    font-size:30px!important;
    color:#fff;
}

.box-class-status{
    display:block;
    width:100%;
    padding:8px;
}

.box-class-tool{
    float:right;
    width:24px;
    margin:0px 4px 0px 0px;
    padding:2px;
    text-align:center;    
}

.box-class-tool > .fa{
    font-size:18px!important;
    margin:8px 0px 8px 0px;
    cursor: pointer;
}

.box-class-title{
    float:left;
    width:calc(100% - 75px - 28px);
    padding:8px;
}

.box-class-head{
    width:100%;        
    overflow-x:hidden;
    overflow-y:visible;
}    
.box-class-body{
    width:100%;        
    overflow-x:hidden;
    overflow-y:visible;
    padding:8px;
}    
.box-class-foot{
    width:100%;        
    overflow-x:hidden;
    overflow-y:visible;
    padding:8px;
}    
.box-class-foot .btn{
    width:100%;
    margin:0px;
    color:#fff;
    font-weight:bold;
    border-radius:16px;
}
</style>
@endsection

@section('contentheader')
<h1 class="m-0">Class</h1>
@endsection

@section('contentheadermenu')
<ol class="breadcrumb float-sm-right">
    <!-- <li class="breadcrumb-item"><a href="#">Home</a></li> -->
    <!-- <li class="breadcrumb-item active">{{Auth::user()->user_level==1 ? "Super Admin" : "Admin Affiliate"}}</li> -->
    <li class="breadcrumb-item"><a href="#">Classrooms</a></li>
    </ol>
@endsection

@section('content')
    <!-- Main content -->
    <section class="content home">
        <div class="container-fluid">
            
            <div class="row" style="margin-bottom:20px;">
            <div class="col-1">
            <a class="btn btn-block btn-info" onclick="addModal();" href="#">+</a>
            </div>
            <div class="col-2">
            <a class="btn btn-block @if($today) btn-outline-primary @else btn-primary @endif" href="{{url('kelas')}}">Semua</a>
            </div>
            <div class="col-2">
            <a class="btn btn-block @if($today) btn-primary @else btn-outline-primary @endif" href="{{url('kelas')}}?today=1">Hari ini</a>
            </div>
            </div>

            <div class="row">
            @foreach($kelass as $kelas) 
              <div class="col-xl-4 col-md-6">  
                    
                    <div class="box-class" id="kelas-{{$kelas->id}}" status-kelas="{{$kelas->time_status}}">
                        <div class="box-class-head">
                        @if(($kelas->time_status=='now') && $kelas->mentor_open)
                            <div class="alert alert-success">Sudah dimulai</div>                            
                            @elseif($kelas->time_status=='now')
                            <div class="alert alert-info">Segera dimulai</div>
                            @elseif($kelas->time_status=='later')                            
                            <div class="alert alert-primary">Akan datang</div>
                            @else
                            <div class="alert alert-warning">Sudah selesai</div>
                            @endif
                            <div class="box-class-icon">
                                <i class="fa fa-video-camera"></i>
                            </div>
                            <div class="box-class-title">
                            <h3>Kelas <span id="nama-{{$kelas->id}}">{{$kelas->name}}</span></h3>
                            <span id="judul-{{$kelas->id}}">{{$kelas->judul}}</span>
                            </div>
                            <div class="box-class-tool">
                            <i class="fa fa-trash text-red" data-toggle="modal" data-target="#modal-hapus-{{$kelas->id}}"></i>
                            <i class="fa fa-edit text-info" onclick="editModal({{$kelas->id}})"></i>
                            </div>
                        </div>
                        <div class="box-class-body">
                        <b id="mentor-{{$kelas->id}}" mentor-id="{{$kelas->mentor_id}}">{{$kelas->mentor_name}}</b>
                        <br>
                        <span id="materi-{{$kelas->id}}">{{$kelas->materi}}</span>
                        <br>
                        Tgl <b id="tanggal-{{$kelas->id}}">{{$kelas->tanggal_mulai}}</b>
                        <br>                      
                        Jam <b id="jam-{{$kelas->id}}">{{$kelas->jam_mulai}}</b> : <b id="menit-{{$kelas->id}}">{{$kelas->menit_mulai}}</b>
                        <i>( <span id="lama-{{$kelas->id}}">{{$kelas->waktu}}</span> menit )</i>
                        </div>                        
                        <div class="box-class-foot"> 
                            <a class="btn btn-sm btn-warning" href="{{url('kelasroom/'.$kelas->id)}}">Lihat Kelas</a>
                        </div>
                    </div>

              </div>          

            @endforeach
            </div>

    @foreach($kelass as $kelas) 
    <!-- Modal Hapus -->
    <div class="modal fade" id="modal-hapus-{{$kelas->id}}">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Konfirmasi</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method="post" id="formHapus_{{$kelas->id}}" class="form-horizontal">
            @csrf
            <div class="modal-body">
                <h6> Apakah anda ingin menghapus kelas <b>"{{$kelas->name}}?"</b></h6>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger btn-hapus" idform="{{$kelas->id}}">Hapus</button>
            </div>
          </form>
        </div>
      <!-- /.modal-content -->
      </div>
    <!-- /.modal-dialog -->
    </div>
    <!-- /.Modal Hapus -->

    @endforeach


        <div class="modal fade" id="modal-kelas" modal-mode="tambah">
        <form method="post" id="_formData" class="form-horizontal">
        @csrf        
          <div class="modal-dialog modal-lg">
          <div class="modal-content">

           <div class="modal-header">
              <h4 class="modal-title"><span id="modal-title">Informasi Kelas</span><span id="modal-id"></span></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              
                <div class="form-group">
                    <label for="nama_kelas">Nama kelas<span class="bintang">*</span></label>
                    <input type="text" class="form-control" id="nama_kelas" name="nama_kelas" placeholder="" required>
                </div>
                <div class="form-group">
                    <label for="judul_kelas">Judul<span class="bintang">*</span></label>
                    <input type="text" class="form-control" id="judul_kelas" name="judul_kelas" placeholder="" required>
                </div>
                <div class="form-group">
                    <label for="materi_kelas">Materi<span class="bintang">*</span></label>
                    <input type="text" class="form-control" id="materi_kelas" name="materi_kelas" placeholder="" required>
                </div>
                <div class="row form-group">
                    <div class="col col-6">
                        <label for="tanggal_mulai">Mulai Tanggal<span class="bintang">*</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="" required>
                            <div class="input-group-append">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col col-6">
                        <label for="exampleInputEmail1">Mulai Jam : Menit<span class="bintang">*</span></label>
                        <div class="input-group">
                        <select class="form-control" id="jam_mulai" name="jam_mulai" value="07" required>
                        @for ($i = 0; $i < 24; $i++)
                            @php
                                if($i<10)$i = "0".$i;
                            @endphp
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                        </select>
                        <div class="input-group-append">
                            <div class="input-group-text"> : </div>
                        </div>
                        <select class="form-control" id="menit_mulai" name="menit_mulai" value="00" required>
                        @for ($i = 0; $i < 4; $i++)
                            @php
                                $x = $i * 15;
                                if($x<10)$x = "0".$x;
                            @endphp
                            <option value="{{ $x }}">{{ $x }}</option>
                        @endfor
                        </select>
                                            
                        <div class="input-group-append">
                            <div class="input-group-text"><i class="far fa-clock"></i></div>
                        </div>
                        </div>                
                    </div>
                </div>
                <div class="form-group">
                    <label for="lama_kelas">Lama sesi<span class="bintang">*</span></label>
                    <div class="input-group">
                            <input type="number" class="form-control" id="lama_kelas" name="lama_kelas" placeholder="" min="0" max="10000" required>
                            <div class="input-group-append">
                                <div class="input-group-text">Menit</div>
                            </div>
                            <div class="input-group-append">
                            <div class="input-group-text bg-info" id="injam"></div>
                            </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="mentor">Mentor<span class="bintang">*</span></label>
                    <select class="form-control" id="mentor" name="mentor">
                    @foreach($mentors as $mentor)
                        <option value="{{$mentor->id}}">{{ $mentor->name }}</option>
                      @endforeach
                    </select>
                </div>

            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <label class="ket-bintang">Bertanda <span class="bintang">*</span> Wajib diisi</label>
              <button type="submit" class="btn btn-primary" id="modal-reactivate" name="submit" value="reactivate">Aktifkan Ulang</button>
              <button type="submit" class="btn btn-primary" id="modal-sumbit" name="submit" value="save">Save changes</button>
            </div>
 
          </div>

          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
        </form>
      </div>


        </div>
        <!--/. container-fluid -->
    </section>
    <!-- /.content -->

@endsection

@section('footer')
<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{ asset('layout/adminlte3/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('layout/adminlte3/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- jquery-validation -->
<script src="{{ asset('layout/adminlte3/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/jquery-validation/additional-methods.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('layout/adminlte3/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

<script src="{{ asset('layout/adminlte3/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>

<!-- AdminLTE App -->
<script src="{{ asset('layout/adminlte3/dist/js/adminlte.js') }}"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="{{ asset('layout/adminlte3/plugins/jquery-mousewheel/jquery.mousewheel.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/jquery-mapael/jquery.mapael.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/jquery-mapael/maps/usa_states.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('layout/adminlte3/plugins/chart.js/Chart.min.js') }}"></script>

<!-- AdminLTE for demo purposes -->
<script src="{{ asset('layout/adminlte3/dist/js/demo.js') }}"></script>

<script>
  $(document).ready(function(){

    $('#tanggal_mulai').daterangepicker({
        singleDatePicker: true,
        autoApply: true,
        autoUpdateInput: true,
        locale:{
            format: 'DD/MM/YYYY'
        }        
    });
    
    $('#jam_mulai').change(function(){
        timeFormat($('#jam_mulai'), true);
    });

    $('#menit_mulai').change(function(){
        timeFormat($('#menit_mulai'), false);
    });

    $('#lama_kelas').change(function(){
        var val = parseInt($('#lama_kelas').val());
        var jam = Math.trunc(val / 60);
        var mnt = val - ( jam * 60 ) ;
        $('#injam').html( '= &nbsp;' + jam + ' jam ' + mnt + ' menit');
    });

    $('#nama_kelas').val('');
    $('#judul_kelas').val('');
    $('#materi_kelas').val('');
    $('#lama_kelas').val(90);
    $('#lama_kelas').change();
    $('#mentor').val('');

    $('#tanggal_mulai').val('{{ date("d/m/Y") }}');
    $('#jam_mulai').val('07');
    $('#menit_mulai').val('00');

    $(document).on('click', '.btn-hapus', function (e) {
        idform = $(this).attr('idform');
        var formData = new FormData($('#formHapus_' + idform)[0]);

        var url = "{{ url('/hapus_kelas') }}/"+idform;
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
    
    $('#_formData').validate({
          rules: {
            nama_kelas: {
              required: true
            },
            judul_kelas: {
              required: true
            },
            materi_kelas: {
              required: true
            },
            tanggal_mulai: {
              required: true
            },
            jam_mulai: {
              required: true
            },
            menit_mulai: {
              required: true
            },
            lama_kelas: {
              required: true
            },
            mentor: {
              required: true
            }
          },
          messages: {
            nama_kelas: {
              required: "Nama kelas tidak boleh kosong"
            },
            judul_kelas: {
              required: "Judul tidak boleh kosong"
            },
            materi_kelas: {
              required: "Materi tidak boleh kosong"
            },
            tanggal_mulai: {
              required: "Tanggal tidak boleh kosong"
            },
            jam_mulai: {
              required: "Jam tidak boleh kosong"
            },
            menit_mulai: {
              required: "Menit tidak boleh kosong"
            },
            lama_kelas: {
              required: "Lama sesi tidak boleh kosong"
            },
            mentor: {
              required: "Mentor tidak boleh kosong"
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

            var edit = $('#modal-kelas').attr('modal-mode')=='edit';
            var eid  = edit ? $('#modal-id').html() : 0;
          
            var formData = new FormData($('#_formData')[0]);

            var url = edit ? "{{url('update_kelas')}}" + "/" + eid : "{{url('add_kelas')}}";

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

    function timeFormat(elm, hour){
        var val  = parseInt(elm.val());
        if(hour){
            if(val<0)val = 23;
            if(val>23)val = 0;
        }else{
            if(val<0)val = 55;
            if(val>59)val = 0;
        }        
        if(val<=9)val = '0' + parseInt(val);
        elm.val(val);
    }

    function addModal(){
    $('#modal-kelas .form-control').removeClass('is-invalid');
    $('#modal-kelas .form-control').removeClass('select2-error');

    $('#modal-kelas').attr('modal-mode','tambah');

    $('#modal-id').html('');

    $('#modal-title').html('Tambah Kelas');
    $('#modal-sumbit').html('Tambah');

    $('#nama_kelas').val('');
    $('#judul_kelas').val('');
    $('#materi_kelas').val('');
    $('#lama_kelas').val(90);
    $('#lama_kelas').change();
    $('#mentor').val('');

    $('#modal-reactivate').addClass('d-none');

    $('#tanggal_mulai').val('{{ date("d/m/Y") }}');
    $('#jam_mulai').val('07');
    $('#menit_mulai').val('00');

    $('#modal-kelas').modal('show');
  }

  function editModal(id){
    
    $('#modal-kelas .form-control').removeClass('is-invalid');
    $('#modal-kelas .form-control').removeClass('select2-error');

    $('#modal-kelas').attr('modal-mode','edit');
 
    $('#modal-id').html(id);

    $('#modal-title').html('Edit Kelas ID ');

    if($('#kelas-'+id).attr('status-kelas')=='end'){
      $('#modal-reactivate').removeClass('d-none');
    }else{
      $('#modal-reactivate').addClass('d-none');
    }
    $('#modal-sumbit').html('Simpan');

    $('#nama_kelas').val($('#nama-'+id).html());
    $('#judul_kelas').val($('#judul-'+id).html());
    $('#materi_kelas').val($('#materi-'+id).html());
    $('#lama_kelas').val($('#lama-'+id).html());
    $('#lama_kelas').change();

    $('#mentor').val($('#mentor-'+id).attr('mentor-id'));

    $('#tanggal_mulai').val($('#tanggal-'+id).html());
    $('#jam_mulai').val($('#jam-'+id).html());
    $('#menit_mulai').val($('#menit-'+id).html());

    $('#modal-kelas').modal('show');
  }

</script>
@endsection