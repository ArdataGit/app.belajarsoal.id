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
    width:100%;
    margin:0px;
    color:#fff;
    font-weight:bold;
    border-radius:16px;
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
                        <h3 class="font-weight-bold text-white"><b>{{ $data->judul }}</b></h3>
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
                                                @if($kelass)

                                                <div class="row" style="margin-top:16px;">
            @foreach($kelass as $kelas) 
              <div class="col-xl-4 col-md-6">  
                    
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
                            <div class="box-class-tool">
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
                            <a class="btn btn-sm btn-warning text-white" href="{{url('userclass/'.$idpaketdtl.'/'.$kelas->id.'/room')}}">Lihat Kelas</a>
                        </div>
                    </div>

              </div>          

            @endforeach
            </div>





                                                @else
                                                <center><img class="mb-3 img-no"
                                                        src="{{ asset('image/global/no-paket.png') }}" alt="">
                                                </center>
                                                <br>
                                                <center class="text-white">Belum Ada Data</center>
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

        });
    </script>
    <!-- Loading Overlay -->
@endsection
