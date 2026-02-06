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
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('layout/adminlte3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('layout/adminlte3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('layout/adminlte3/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('layout/adminlte3/dist/css/adminlte.min.css') }}">

<!-- summernote -->
<link rel="stylesheet" href="{{ asset('layout/adminlte3/plugins/summernote/summernote-bs4.min.css') }}">

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
  margin:4px;
}

.box-class-foot .active,
.box-class-foot .btn-warning{
    display:inline-block!important;
    width:auto;
    margin:0px;
    padding: 4px 16px!important;
    color:#000!important;    
    background:#fff!important;
    border-color:#fa0!important;
    border-radius:16px;
}
.box-class-foot .active{
    background:#fa0!important;
    color:#fff!important;    
}
</style>
@endsection

@section('contentheader')
<h1 class="m-0">Mentor Class Presensi</h1>
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
                <div class="col-12">  
                <a class="btn btn-info" href="{{url('mentor')}}"><i class="fa fa-arrow-left"></i> Back</a>
                </div>
            </div>
            
            <div class="row">
              <div class="col-12">  
                    
                    <div class="box-class">
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
                        <a class="btn btn-sm btn-warning" href="{{url('mentorroom/'.$kelas->id)}}">Live Class</a>
                        <a class="btn btn-sm btn-warning active" href="{{url('mentorroom/'.$kelas->id.'/presensi')}}">Data Presensi</a>
                        @if($kelas->mentor_hadir)
                        <a class="btn btn-sm btn-success" href="#">Sudah Presensi</a>
                          @if($kelas->mentor_open)
                          <a class="btn btn-sm btn-success" href="#">Sudah Live</a>
                          @else
                          <a class="btn btn-sm btn-danger" href="#" data-toggle="modal" data-target="#modal-buka">Buka Live</a>
                          @endif
                        @else
                        <a class="btn btn-sm btn-danger" href="#" data-toggle="modal" data-target="#modal-presensi">Belum Presensi</a>
                        <a class="btn btn-sm btn-danger disabled" href="#">Buka Live</a>
                        @endif
                        <a class="btn btn-sm btn-primary" href="#" data-toggle="modal" data-target="#modal-edit"><i class="fa fa-edit"></i> Edit</a>
                        </div>
                    </div>

              </div>          

            </div>
            
            <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="row">
                    @if($kelas->mentor_open)
                    <div class="col-12"><b class="text-success">Live Class Dibuka {{$kelas->mentor_open}}</b></div>
                    @else
                    <div class="col-12"><b class="text-danger">Live Class Belum Dibuka Oleh Mentor</b></div>
                    @endif
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive">
              <!-- <button data-toggle="modal" data-target="#modal-tambah" type="button" class="btn btn-md btn-primary btn-absolute">Tambah</button> -->
                <table id="tabledata" class="table table-striped table-bordered">
                  <thead>
                  <tr>
                    <th width="100px">No</th>
                    <th>Nama</th>
                    <th width="200px">Jam Bergabung</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                    <td><b>Mentor</b></td>
                    <td><b>{{$kelas->mentor_name}}</b></td>
                    @if($kelas->mentor_hadir)
                    <td><b class="text-success">{{$kelas->mentor_hadir}}</b></td>
                    @else
                    <td><b class="text-danger">Belum Hadir</b></td>
                    @endif
                  </tr>                    
                  @foreach($presensi as $id=>$p)
                  <tr>
                    <td><b>{{$loop->iteration}}</b></td>
                    <td><b>{{$p['nama']}}</b></td>
                    @if($p['hadir'])
                    <td><b class="text-success">{{$p['hadir']}}</b></td>
                    @else
                    <td><b class="text-danger">Belum Hadir</b></td>
                    @endif
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


    <!-- Modal Presensi -->
    <div class="modal fade" id="modal-presensi">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Konfirmasi</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method="post" id="formPresensi" class="form-horizontal">
            @csrf
            <div class="modal-body">
                <h6> Presensi hadir dalam live class?</b></h6>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger btn-presensi" idform="{{$kelas->id}}">Presensi</button>
            </div>
          </form>
        </div>
      <!-- /.modal-content -->
      </div>
    <!-- /.modal-dialog -->
    </div>
    <!-- /.Modal Presensi -->

    <!-- Modal Buka -->
    <div class="modal fade" id="modal-buka">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Konfirmasi</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method="post" id="formBuka" class="form-horizontal">
            @csrf
            <div class="modal-body">
                <h6> Buka untuk memulai live class ?</b></h6>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary btn-buka" idform="{{$kelas->id}}">Buka Live</button>
            </div>
          </form>
        </div>
      <!-- /.modal-content -->
      </div>
    <!-- /.modal-dialog -->
    </div>
    <!-- /.Modal Presensi -->


        <!-- Modal Edit -->
        <div class="modal fade" id="modal-edit">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Edit Class</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method="post" id="formEdit" class="form-horizontal">
            @csrf
            <div class="modal-body">
              <!-- <div class="card-body"> -->
              <div class="form-group">
                    <label for="link_live">Link</label>
                    <input type="text" class="form-control" id="link_live" name="link_live" placeholder="Link URL dimana anda live" value="{{$kelas->link}}">
                </div>            
                <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <textarea class="form-control" id="keterangan" name="keterangan" placeholder="Informasi tentang live class" rows="20">{{$kelas->keterangan}}</textarea>
                </div>            
                <!-- /.form-group -->
              <!-- </div> -->
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <label class="ket-bintang">Bertanda <span class="bintang">*</span> Wajib diisi</label>
                <button type="button" class="btn btn-danger btn-submit-data" idform="{{$kelas->id}}">Simpan</button>
            </div>
          </form>
        </div>
      <!-- /.modal-content -->
      </div>
    <!-- /.modal-dialog -->
    </div>
    <!-- /.modal edit -->    




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

<!-- Summernote -->
<script src="{{ asset('layout/adminlte3/plugins/summernote/summernote-bs4.min.js') }}"></script>

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

    $('#keterangan').summernote({
      height:200
    });

    $('#tabledata').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : false
    })

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

    $(document).on('click', '.btn-presensi', function (e) {
        idform = $(this).attr('idform');
        var formData = new FormData($('#formPresensi')[0]);

        var url = "{{ url('mentorroom') }}/"+ idform + "/hadir";
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
    
    $(document).on('click', '.btn-buka', function (e) {
        idform = $(this).attr('idform');
        var formData = new FormData($('#formBuka')[0]);

        var url = "{{ url('mentorroom') }}/"+ idform + "/buka";
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

     $(document).on('click', '.btn-submit-data', function (e) {
         idform = $(this).attr('idform');
          
             var formData = new FormData($('#formEdit')[0]);

             var url = "{{ url('mentorroom') }}/"+ idform + "/edit";
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


</script>
@endsection