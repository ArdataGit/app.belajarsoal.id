@extends($extend)

<!-- partial -->

@section('content')

<style>
    .form-check .form-check-label input[type="radio"]+.input-helper:before {

        cursor: unset;

    }

    iframe{
        width: 100% !important;
    }

    .btn-tab {

        border: 1px solid transparent !important;

        color: #686868;

    }

    .btn-tab:focus {

        box-shadow: unset !important;

    }
</style>

@php

if (app('request')->input('tab')) {

  $tab = app('request')->input('tab');

} else {

  $tab = 'statistik';

}

$lulus = $upaketsoalmst->nilai >= $upaketsoalmst->kkm;
           
function check_decimal($number){
  $number = number_format($number, 2, ',', ' ');
  if(substr($number,-1)=='0')$number = substr($number, 0, -1);
  if(substr($number,-2)==',0')$number = substr($number, 0, -2);
  return $number;
}

@endphp

<div class="content-wrapper">

    <div class="row">

        <div class="col-md-12 grid-margin stretch-card">

            <div class="card card-border">

                <div class="card-body">

                    <nav aria-label="breadcrumb">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a href="{{ url('home') }}"><i class="fas fa-home"></i></a></li>

                            <li class="breadcrumb-item active text-white" aria-current="page">Paket Saya</li>

                            <li class="breadcrumb-item active text-white" aria-current="page">Hasil & Pembahasan</li>

                        </ol>

                    </nav>

                    <p class="card-description">

                    <h3 class="font-weight-bold text-white"><b>Detail Hasil Latihan</b></h3>

                    <div class="row">

                        <div class="col-12 col-md-3 col-lg-3">

                            <table class="table table-borderless text-white">

                                <thead>

                                    <tr>

                                        <th class="pb-0" style="padding-left:0px">Latihan</th>

                                        <th class="pb-0">{{ $upaketsoalmst->judul }}</th>

                                    </tr>

                                    <tr>

                                        <th style="padding-left:0px">Nama</th>

                                        <th>{{ Auth::user()->name }}</th>

                                    </tr>

                                </thead>

                            </table>

                        </div>

                        <div class="col-12">

                            <ul class="pb-3 nav nav-pills btn-menu-paket" role="tablist">

                                <li class="nav-item">

                                    <a style="" class="btn btn-sm btn-primary nav-link btn-tab-hasil btn-tab {{ $tab == 'statistik' ? 'active' : '' }}" data-toggle="pill" href="#statistik"><i class="fas fa-chart-pie"></i> Hasil</a>

                                </li>

                                <li class="nav-item">

                                    <a style="" class="btn btn-sm btn-primary nav-link btn-tab-hasil btn-tab {{ $tab == 'pembahasan' ? 'active' : '' }}" data-toggle="pill" href="#pembahasan"><i class="fa fa-list-alt"></i>

                                        Pembahasan</a>

                                </li>

                            </ul>

                            <div class="tab-content tab-hasil-ujian">

                                <div id="statistik" class="tab-pane {{ $tab == 'statistik' ? 'active' : '' }}"><br>

                                    <div class="" style="overflow: hidden">
                                        <h4 style="color: white;" >Skor hasil perolehan <span class="badge badge-info">{{$upaketsoalmst->judul}}</span></h4>

                                                @if ($lulus)

                                                <div class="badge badge-danger rounded-3 w-100 py-3 mt-2">

                                                    <h5 class="mb-0 p-0">Maaf Anda Tidak Lulus</h5>

                                                </div>

                                                @else

                                                <div class="badge badge-success rounded-3 w-100 py-3 mt-2">

                                                    <h5 class="mb-0 p-0">Selamat Anda Lulus</h5>

                                                </div>

                                                @endif


                                            <div class="row mt-3" style="justify-content: center">

                                                <div class="col-12 col-md-3" style="background: #ccf1d0e3 !important;margin-left:0.5%;margin-right:0.5%;border-radius:10px">

                                                    <div class="px-3 py-5 card-border" style="text-align:center;border-radius:10px;display:flex;flex-direction:column;justify-content:center">

                                                        <div style="display:flex;justify-content:center">

                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="height: 50px;width:50px;color:green;background-color:white;border-radius:100%;padding:10px;margin-bottom:10px">

                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />

                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />

                                                            </svg>

                                                        </div>



                                                        <h6 class="fw-bold mt-3">Total Skor</h6>

                                                        <div class=""><span style="font-size: 36pt;color: #106571;font-weight: bold;display: block;">
                                                        {{ $upaketsoalmst->nilai <= 0 ? 0 : check_decimal($upaketsoalmst->nilai) }}
                                                      </span>

                                                        </div>



                                                    </div>

                                                </div>


                                            </div>

                                    </div>

                                </div>

                                <div id="pembahasan" class="tab-pane {{ $tab == 'pembahasan' ? 'active' : '' }}"><br>

                                <div class="row">
    <div class="col-xl-9 col-md-9 col-sm-9 col-xs-9 push-left">
    <div class="_soal_content tab-content" id="pills-tabContent">
      @foreach($soalmst as $key)
      <div class="tab-pane fade {{$loop->iteration==1 ? 'show active' : ''}}" id="pills-{{$key->id}}" role="tabpanel">
        <div class="soal_master">
            <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                    <table class="table table-bordered" style="margin-bottom:0">
                        <tbody>
                          <tr>
                            @foreach(json_decode($key->karakter) as $loopdatamaster)
                            <td><h2><b>{{$loopdatamaster}}</b></h2></td>
                            @endforeach
                          </tr>
                          <tr>
                            @foreach(json_decode($key->kiasan) as $loopdatamaster)
                            <td><h5><b>{{$loopdatamaster}}</b></h5></td>
                            @endforeach
                          </tr>
                        </tbody>
                    </table>
                  </div>
                </div>
            </div>
            <br>
            <h3 style="padding-bottom:15px text-white">Pembahasan :</h3>
            @foreach($key->u_paket_soal_kecermatan_soal_dtl_r as $key2)
            <div class="row">
              <div class="col-12">
                <div class="_soal_content_kecermatan tab-content" id="pills-tabContent">
                  <div class="tab-pane fade show active">
                    <div class="parent">
                      @foreach(json_decode($key2->soal) as $loopdatadtl)
                        <div class="child"><h2>{{$loopdatadtl}}</h2></div>
                      @endforeach
                    </div>
                  </div>
                </div>
                <div class="soal_dtl_bawah">
                  <div class="parent">
                    @foreach(json_decode($key->kiasan) as $loopdatamaster)
                      <div class="child">
                        <h5>{{$loopdatamaster}}</h5>
                          <div class='form-check {{$key2->jawaban==$loopdatamaster? "_form-check-success" : "_form-check-danger"}} {{$key2->jawaban_user==$loopdatamaster ? "_form-check-user-kec" : "" }}'>
                            <label class="form-check-label">
                              <input type="radio" class="form-check-input" value="{{$loopdatamaster}}" disabled>
                              <i class="input-helper"></i></label>
                          </div>  
                      </div>
                    @endforeach
                  </div>
                </div>
                <div>
                  <h6 style="color: white;">Kunci Jawaban : <b>{{$key2->jawaban}}</b></h6>
                  <h6 class="mb-3 text-white">Jawaban : <b>{{$key2->jawaban_user ? $key2->jawaban_user : "-"}} 
                      @if($key2->jawaban_user==$key2->jawaban)
                        <span class='text-success'>(Benar)</span>
                      @else
                        <span class='text-danger'>(Salah)</span>
                      @endif
                    </b></h6>
                </div>
              </div>
            </div>
            <br>
            @endforeach

        </div>
      </div>
      <!-- <div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">2</div> -->
      @endforeach
      
    </div>
    </div>
    <div class="col-xl-3 col-md-3 col-sm-3 col-xs-3">
      
    <center class="mb-3 fw-bold text-white">Nomor Soal</center>

    <ul class="_soal nav nav-pills mb-3" id="pills-tab" role="tablist">
      @foreach($soalmst as $key)

      <!-- <li class="nav-item" role="presentation">
        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">1</button>
      </li> -->
      <li class="nav-item" role="presentation">
        <button id="btn_no_soal_{{$key->id}}" class="_benar nav-link {{$loop->iteration==1 ? 'active' : ''}}" data-bs-toggle="pill" data-bs-target="#pills-{{$key->id}}" type="button" role="tab" aria-selected="true">{{$loop->iteration}}</button>
      </li>
      @endforeach
    </ul>
    
    </div>
  </div> 

                                </div>

                            </div>

                        </div>

                    </div>

                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection



@section('footer')

<!-- jQuery -->

<!-- SweetAlert2 -->

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {



        $(document).bind("contextmenu", function(e) {

            return false;

        });



        $('body').on("cut copy paste", function(e) {

            e.preventDefault();

        });

    });
</script>

<!-- Loading Overlay -->

@endsection