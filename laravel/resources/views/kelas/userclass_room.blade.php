@extends('layouts.Skydash')

@section('header')

<!-- Font Awesome Icons -->
<link rel="stylesheet" href="{{ asset('layout/adminlte3/plugins/fontawesome-free/css/all.min.css') }}">

<style>
        a:hover {
            text-decoration: none;
        }

        .sidebar-offcanvas {
            z-index: 10 !important;
        }


.box-class{
    width:100%;
    overflow-x:hidden;
    overflow-y:visible;
    background:#fff;
    padding:8px;
    border:solid 1px #ddd;
    border-radius:8px;
    margin-top:16px:
}    

.box-class-icon{
    float:left;
    width:60px;
    margin:8px 0px 8px 8px;
    overflow-x: visible;
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
    display:inline-block!important;
    width:auto;
    margin:0px;
    padding: 4px 16px!important;
    border-radius:16px;
}

.box-class-foot .active,
.box-class-foot .btn-warning{
    color:#000!important;    
    background:#fff!important;
    border-color:#fa0!important;
}
.box-class-foot .active{
    background:#fa0!important;
    color:#fff!important;    
}
    </style>

@endsection

@section('content')

    @php
        if (app('request')->input('tab')) {
            $tab = app('request')->input('tab');
        } else {
            $tab = 'pembelajaran';
        }
    @endphp


    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="cardx card-border w-100">
                    <div class="card-bodyx">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('home') }}"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page"><a
                                        href="{{ url('paketsayaktg') }}">Paket Saya</a></li>
                              
                            </ol>
                        </nav>
                        <p class="card-description">
                        <h3 class="font-weight-bold"><b>{{ $data->judul }}</b></h3>
                        <h6 class="txt-abu">{!! $data->ket !!}</h6>
                        </p>
                        <hr>
                        <div class="row mt-4">
                            <div class="col-lg-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <ul class="pb-0 nav nav-pills btn-menu-paket" role="tablist"
                                            style="border-bottom:unset">
                                            <li class="nav-item">
                                                <a class="btn btn-sm btn-primary nav-link btn-tab-hasil"
                                                    href="{{url('paketsayadetail/'.Crypt::encrypt($data->id))}}?tab=latihan">Tryout</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="btn btn-sm btn-primary nav-link btn-tab-hasil"
                                                    href="{{url('paketsayadetail/'.Crypt::encrypt($data->id))}}?tab=hasillatihan">Hasil Tryout</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="btn btn-sm btn-primary nav-link btn-tab-hasil active" 
                                                data-toggle="pill" href="#userclass">Class</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content tab-hasil-ujian">
                                            <!-- Button trigger modal -->
                                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
										
                                            <div id="userclass" class="tab-pane active">
                                                @if($kelas)
            
            <div class="row" style="margin-top:32px;">
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
                        <a class="btn btn-warning active" href="{{url('userclass/'.$idpaketdtl.'/'.$kelas->id.'/room')}}">Live Class</a>
                        <a class="btn btn-warning" href="{{url('userclass/'.$idpaketdtl.'/'.$kelas->id.'/presensi')}}">Data Presensi</a>
                        @if($sudah_presensi)
                        <a class="btn btn-success text-white" href="#">Sudah Presensi</a>
                        @elseif($kelas->time_status=='now')
                            <a class="btn btn-danger text-white" href="#" data-toggle="modal" data-target="#modal-presensi">Presensi dulu disini</a>
                        @endif
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
              <div class="card-body">
              @if($kelas->time_status=='end')
              <b>Live class sudah berakhir</b><br><br>
              @elseif($kelas->time_status=='later')
              <b>Harap tunggu sesuai tanggal dan jam yang ditentukan</b><br><br>
              @elseif(!$kelas->mentor_open)
              <b>Harap tunggu sampai mentor membuka live class</b><br><br>
              @elseif(!$sudah_presensi)
              <i>Silahkan <b>presensi</b> kehadiran dahulu untuk mendapatkan akses</i><br><br>
              @elseif($kelas->link)
              <a class="btn btn-primary text-white" href="{{$kelas->link}}" target="_blank"><i class="fa fa-video-camera"></i> Gabung live disini</a>
              <br><br>
              @else
              <a class="btn btn-primary text-white" href="#" data-toggle="modal" data-target="#modal-link"><i class="fa fa-video-camera"></i> Gabung live disini</a>
              <br><br>
              @endif              
              <i>Note : Refresh untuk mengetahui status terkini</i>
              <br><br>
              {!!$kelas->keterangan!!}
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->





                                                @else
                                                <center><img class="mb-3 img-no"
                                                        src="{{ asset('image/global/no-paket.png') }}" alt="">
                                                </center>
                                                <br>
                                                <center>Belum Ada Data</center>
                                                @endif
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Link -->
    <div class="modal fade" id="modal-link">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Informasi</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <div class="modal-body">
                Link belum disetting oleh mentor
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
            </div>
        </div>
      <!-- /.modal-content -->
      </div>
    <!-- /.modal-dialog -->
    </div>
    <!-- /.Modal Link -->


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

@endsection

@section('footer')
    <!-- SweetAlert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
        $(document).ready(function() {

            $(document).on('click', '.btn-presensi', function (e) {
        idform = $(this).attr('idform');
        var formData = new FormData($('#formPresensi')[0]);

        var url = "{{ url('userclass/'.$idpaketdtl) }}/"+ idform + "/hadir";
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
    </script>
    <!-- Loading Overlay -->
@endsection
