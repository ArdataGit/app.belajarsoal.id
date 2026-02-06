@extends('layouts.Skydash')
<!-- partial -->
@section('content')
<style>
    .sesuai {
        color: #FEA31B;
    }

    .selesai {
        color: green;
    }
</style>
<div class="content-wrapper">
@php

$firstsoal = NULL;

$soals     = implode(',', $soals);

$no = 1;
$selesai = $dataloop[0]->selesai;
$idupaketsoalktg = $dataloop[0]->id;
$judulsesi = "Sesi";

@endphp

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="cardx card-border w-100">
                <div class="card-bodyx">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('home') }}"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item active text-black" aria-current="page">Paket Saya</li>
                            <li class="breadcrumb-item active text-black" aria-current="page">Kerjakan Latihan
                                {{ $umapelmst->judul }}
                            </li>
                        </ol>
                    </nav>
                    <p class="card-description">
                    <h3 class="font-weight-bold text-black"><b>Latihan {{ $umapelmst->judul }}</b></h3>
                    </p>
                    <div class="row">
                        <div class="col-xl-9 col-md-9 col-sm-9 col-xs-9">

                        <div class="soal_master" style="padding-bottom:20px">          
                        <div class="row">
                        <div class="table-responsive text-center" style="border-radius:0; border:solid 1px #ddd; padding:0;">
                        <h3 style="border:solid 1px #ddd; padding:8px 4px; margin:0; color:#fff;">Kolom {{$upaketsoalmst->current_kolom()}}</h3>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                @foreach(json_decode($soalmst->karakter) as $loopdatamaster)
                                <td><h2 class="text-black"><b>{{$loopdatamaster}}</b></h2></td>
                                @endforeach
                                </tr>
                                <tr>
                                @foreach(json_decode($soalmst->kiasan) as $loopdatamaster)
                                <td><h5 class="text-black"><b>{{$loopdatamaster}}</b></h5></td>
                                @endforeach
                                </tr>
                            </tbody>
                        </table>
                        </div>
                        </div>
                        </div>

                        <div class="row">
                            @if(count($soalmst->u_paket_soal_kecermatan_soal_dtl_r)>0)
                            <!--<div class="col-lg-4 col-md-4">-->
                            <div class="col">
                            <div class="_soal_content_kecermatan tab-content" id="pills-tabContent" style="height:auto;">
                                @foreach($soalmst->u_paket_soal_kecermatan_soal_dtl_r as $i=>$key)
                                @php
                                if(!$firstsoal)$firstsoal = $key->id;
                                @endphp
                                
                                <div class="soaldtl tab-pane fade" idsoaldtl="{{$key->id}}" detik_mulai="{{$key->detik_mulai}}" detik_akhir="{{$key->detik_akhir}}" id="pills-{{$key->id}}" role="tabpanel">
                                
                                <div class="parent" style="padding:4px;">
                                    @foreach(json_decode($key->soal) as $loopdatadtl)
                                    <div class="child text-black"><h2 style="margin-bottom:0rem">{{$loopdatadtl}}</h2></div>
                                    @endforeach
                                </div>
                                <div class="soal_dtl_bawah" style="border-top:solid 1px #ddd; padding:4px;">
                                    <div class="parent">
                                    @foreach(json_decode($soalmst->kiasan) as $loopdatamaster)
                                        <div class="child text-center">
                                        <h5 style="font-size:20px" class="text-black">{{$loopdatamaster}}</h5>
                                            <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input _radio" name="radio_{{$key->id}}" value="{{$loopdatamaster}}">
                                                <i class="input-helper"></i>
                                            </label>  
                                            </div>  
                                        </div>
                                    @endforeach
                                    </div>
                                </div>
                                
                                </div>

                                @endforeach
                            </div>
                            </div>
                            @else
                            <div class="col-lg-4 col-md-4">
                            <center class="text-black"><i>Soal Tidak Ditemukan!!!</i></center>
                            </div>
                            @endif
                        </div>
                        </div>
                        
                            <div class="col-xl-3 col-md-3 col-sm-3 col-xs-3" style="text-align:center; float:right;">
                            <div class="card card-border w-100 mb-4">
                                <div class="card-body">
                                    <div class="mb-4 card-border div-waktu">
                                        <div class="mb-0" id="sesiend">
                                            <h6 class="fw-600 text-center mb-3 text-white">Waktu Sesi Tersisa</h6>
                                            <span class="f-waktu" id="sesihours"></span><br />
                                            <span class="f-waktu" id="sesimins"></span>
                                            <span class="f-waktu" id="sesisecs"></span>
                                        </div>
                                    </div>

                                    <div class="mb-4 card-border br-10">
                                        <center class="mb-1 text-black">Sudah Selesai?</center>
                                        @if(count($umapelmst->u_paket_soal_ktg_nonaktif_r)>0)
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#modallanjutsesi" class="btn-block btn btn-primary btn-sm">
                                            <h6 class="mb-0">Lanjut Sesi</h6>
                                        </button>
                                        @else
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#modalselesaiujian" class="btn-block btn btn-primary btn-sm">
                                            <h6 class="mb-0 text-white">Selesaikan Ujian</h6>
                                        </button>
                                        @endif
                                    </div>

                                </div>
                            </div>

                            <button type="button" class="btn btn-outline-primary btn-sm _btn-waktu bg-green">
                            <h6 id="end" class="text-white">Waktu Soal Tersisa<br><span id="hours"></span><span id="mins"></span><span id="secs"></span></h6>
                            </button>

                            <div class="card-border p-3 br-10">
                                <center class="mb-2 text-black">{{$judulsesi}}</center>
                                <div>
                                    @foreach($umapelmst->u_paket_soal_ktg_r as $keyktg)
                                    <h6 class='{{$keyktg->id==$idupaketsoalktg ? "sesuai" : ""}} {{$keyktg->is_mengerjakan==2 ? "selesai" : ""}}'>{{$keyktg->judul}}
                                        @if($keyktg->is_mengerjakan==2)
                                        <i class="fas fa-check"></i>
                                        @endif
                                    </h6>
                                    @endforeach
                                </div>
                            </div>

                        </div>

                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalselanjutnya">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Buka soal selanjutnya ?</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <center><h5 style="font-weight:unset"><i>Anda tidak dapat kembali ke soal sebelumnya</i></h5></center>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer" style="display:block;text-align: center;">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tidak</button>
        <button type="button" class="btn btn-outline-danger" id="btn-selanjutnya" soalmst="{{Crypt::encrypt($soalmst->id)}}">Ya</button>
      </div>

    </div>
  </div>
</div>


@if(count($umapelmst->u_paket_soal_ktg_nonaktif_r)>0)
<div class="modal fade" id="modallanjutsesi">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <!-- <div class="modal-header">
        <h4 class="modal-title">Selesaikan Ujian?</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div> -->

            <!-- Modal body -->
            <div class="modal-body pb-0">
                <center style="font-size:18px"><i style="color:#106571" class="fa fa-check-square"></i> <span style="color:#106571" class="modal-title"><b>Selesaikan Sesi Ini?</b></span></center>
                <h5 class="mt-2">
                    <center>Jawaban yang telah diselesaikan tidak dapat diubah lagi!</center>
                </h5>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer" style="display:block;text-align: center;border-top:0px solid">
                <button type="button" class="btn btn-primary" id="btn-lanjutsesi" upaketsoalmst="{{Crypt::encrypt($umapelmst->id)}}" upaketsoalktg="{{Crypt::encrypt($idupaketsoalktg)}}">Lanjut Sesi</button>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
            </div>

        </div>
    </div>
</div>
@else
<div class="modal fade" id="modalselesaiujian">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <!-- <div class="modal-header">
        <h4 class="modal-title">Selesaikan Ujian?</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div> -->

            <!-- Modal body -->
            <div class="modal-body pb-0">
                <center style="font-size:18px"><i style="color:#106571" class="fa fa-check-square"></i> <span style="color:#106571" class="modal-title"><b>Submit Jawaban Sekarang?</b></span></center>
                <h5 class="mt-2">
                    <center>Jawaban yang telah disubmit tidak dapat diubah!</center>
                </h5>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer" style="display:block;text-align: center;border-top:0px solid">
                <button type="button" class="btn btn-primary" id="btn-selesai" upaketsoalmst="{{Crypt::encrypt($umapelmst->id)}}">Submit</button>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
            </div>

        </div>
    </div>
</div>
@endif
@endsection

@section('footer')
<!-- jQuery -->
<!-- SweetAlert2 -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">

  var nosoal = -1;

  var soals = [{{$soals}}];

    // window.onbeforeunload = function() {
    //     return "Yakin ingin keluar dari halaman ini!";
    // };
    $(document).ready(function() {


        @if($firstsoal)
        ganti_soal();
        @endif


//        $(document).bind("contextmenu", function(e) {
  //          return false;
    //    });

        $('body').on("cut copy paste", function(e) {
            e.preventDefault();
        });


        $(document).on('click', '#btn-selanjutnya', function (e) {
        document.getElementById("end").innerHTML = "Mohon Tunggu...";

        idsoalmst = $('#btn-selanjutnya').attr('soalmst');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "{{url('selesaiujiankecermatan')}}",
            async: false,
            data: {
              idsoalmst : idsoalmst
            },
            beforeSend: function () {
                $.LoadingOverlay("show", {
                    image       : "{{asset('/image/global/loading.gif')}}"
                });
            },
            success: function(response)
            {
              if (response.status) {
                  if(response.isterakhir=='ya'){
                      $('.modal').modal('hide');
                      Swal.fire({
                          html: 'Jawaban telah tersimpan, Ujian selesai',
                          icon: 'success',
                          showConfirmButton: true
                      }).then((result) => {
                          $.LoadingOverlay("show", {
                            image       : "{{asset('/image/global/loading.gif')}}"
                          });
                          reload_url(1500,'{{url("detailhasilkecermatan")}}/{{Crypt::encrypt($upaketsoalmst->id)}}');
                      })
                  }else{
                    $.LoadingOverlay("show", {
                      image       : "{{asset('/image/global/loading.gif')}}"
                    });
                    reload(500);
                  }
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



        $(document).on('change', '._radio', function (e) {
          jawaban = $(this).val();
          idpaketdl = $('.soaldtl.tab-pane.fade.show.active').attr('idsoaldtl');
          if(idpaketdl){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "{{url('updatejawabankecermatan')}}",
                async: false,
                data: {
                  jawaban : jawaban,
                  idpaketdl : idpaketdl
                },
                beforeSend: function () {
                    // $.LoadingOverlay("show", {
                    //     image       : "{{asset('/image/global/loading.gif')}}"
                    // });
                },
                success: function(response){
                    ganti_soal();                  
                },
                error: function (xhr, status) {
                      alert('Error!!!');
                  },
                  complete: function () {
                      // $.LoadingOverlay("hide");
                  }
              });
          }else{
            Swal.fire({
                html: "Tunggu soal muncul terlebih dahulu",
                icon: 'warning',
                confirmButtonText: 'Ok'
            });
            $('._radio').prop('checked', false);
          }

      });


        $(document).on('click', '#btn-selesai', function(e) {
            idpaketmst = $('#btn-selesai').attr('upaketsoalmst');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "{{ url('selesaiujian') }}",
                // async: false,
                data: {
                    idpaketmst: idpaketmst
                },
                beforeSend: function() {
                    $.LoadingOverlay("show", {
                        image: "{{ asset('/image/global/loading.gif') }}"
                    });
                },
                success: function(response) {
                    if (response.status) {

                        $('.modal').modal('hide');
                        document.getElementById("sesiend").innerHTML = "UJIAN SELESAI!!";
                        reload_url(0, response.menu);

                        // Swal.fire({
                        //     html: response.message,
                        //     icon: 'success',
                        //     showConfirmButton: true
                        // }).then((result) => {
                        //     $.LoadingOverlay("show", {
                        //       image       : "{{ asset('/image/global/loading.gif') }}"
                        //     });
                        // })

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
                    // $.LoadingOverlay("hide");
                }
            });
        });

        // Lanjut Sesi
        $(document).on('click', '#btn-lanjutsesi', function(e) {
            document.getElementById("sesiend").innerHTML = "SESI SELESAI!!";

            idpaketmst = $('#btn-lanjutsesi').attr('upaketsoalmst');
            idupaketsoalktg = $('#btn-lanjutsesi').attr('upaketsoalktg');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "{{url('lanjutsesi')}}",
                // async: false,
                data: {
                    idpaketmst: idpaketmst,
                    idupaketsoalktg: idupaketsoalktg
                },
                beforeSend: function() {
                    $.LoadingOverlay("show", {
                        image: "{{asset('/image/global/loading.gif')}}"
                    });
                },
                success: function(response) {
                    if (response.status) {

                        $('.modal').modal('hide');
                        Swal.fire({
                            title: "Sesi Selesai!",
                            html: "Halaman akan diarahakan kesesi selanjutnya...",
                            icon: 'success',
                            showConfirmButton: false
                        })
                        reload(1500);


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

        // COUNDOWN
        // The data/time we want to countdown to
        var countDownDateSesi = new Date("{{$selesai}}").getTime();


        // Run myfunc every second
        i = 0;
        var myfunc = setInterval(function() {

            const now = new Date('{{ $now }}');
            now.setSeconds(now.getSeconds() + i);
            i++;
            // console.log(date.setSeconds(date.getSeconds() + 5));

            // var now = new Date().getTime();
            var timeleft = countDownDateSesi - now;

            // Calculating the days, hours, minutes and seconds left
            // var days = Math.floor(timeleft / (1000 * 60 * 60 * 24));
            var sesihours = Math.floor((timeleft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var sesiminutes = Math.floor((timeleft % (1000 * 60 * 60)) / (1000 * 60));
            var sesiseconds = Math.floor((timeleft % (1000 * 60)) / 1000);

            // Result is output to the specific element
            // document.getElementById("days").innerHTML = days + ""
            if(document.getElementById("sesihours"))document.getElementById("sesihours").innerHTML = sesihours + " Jam "
            if(document.getElementById("sesimins"))document.getElementById("sesimins").innerHTML = sesiminutes + " Menit "
            if(document.getElementById("sesisecs"))document.getElementById("sesisecs").innerHTML = sesiseconds + " Detik"

            // Display the message when countdown is over
            if (timeleft <= 0) {
                clearInterval(myfunc);
                // document.getElementById("days").innerHTML = ""
                // document.getElementById("hours").innerHTML = "" 
                // document.getElementById("mins").innerHTML = ""
                // document.getElementById("secs").innerHTML = ""
                if ("{{count($umapelmst->u_paket_soal_ktg_nonaktif_r)}}" > 0) {

                    document.getElementById("sesiend").innerHTML = "SESI SELESAI!!";

                    idpaketmst = $('#btn-lanjutsesi').attr('upaketsoalmst');
                    idupaketsoalktg = $('#btn-lanjutsesi').attr('upaketsoalktg');
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "POST",
                        dataType: "JSON",
                        url: "{{url('lanjutsesi')}}",
                        // async: false,
                        data: {
                            idpaketmst: idpaketmst,
                            idupaketsoalktg: idupaketsoalktg
                        },
                        beforeSend: function() {
                            $.LoadingOverlay("show", {
                                image: "{{asset('/image/global/loading.gif')}}"
                            });
                        },
                        success: function(response) {
                            if (response.status) {
                                $('.modal').modal('hide');
                                reload(0);
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

                } else {
                    document.getElementById("sesiend").innerHTML = "UJIAN SELESAI!!";

                    idpaketmst = $('#btn-selesai').attr('upaketsoalmst');
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "POST",
                        dataType: "JSON",
                        url: "{{url('selesaiujian')}}",
                        // async: false,
                        data: {
                            idpaketmst: idpaketmst
                        },
                        beforeSend: function() {
                            $.LoadingOverlay("show", {
                                image: "{{asset('/image/global/loading.gif')}}"
                            });
                        },
                        success: function(response) {
                            if (response.status) {
                                $('.modal').modal('hide');
                                Swal.fire({
                                    html: response.message,
                                    icon: 'success',
                                    showConfirmButton: true
                                }).then((result) => {
                                    $.LoadingOverlay("show", {
                                        image: "{{asset('/image/global/loading.gif')}}"
                                    });
                                    reload_url(1500, response.menu);
                                })

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
            }
        }, 1000);
        // END COUNDOWN
    });


    var countDownDate = new Date("{{$soalmst->selesai}}").getTime();

        i=0;
        // Run myfunc every second
        var myfunc = setInterval(function() {

        const now = new Date('{{$now}}');
        now.setSeconds(now.getSeconds() + i);
        i++;

        var timeleft = (countDownDate - now) + 5000;
        var strdetik = Math.floor(timeleft / 1000);

        @if(!$soalmst->waktu_total)
        $('.tab-pane').each(function(i, obj) {
                detik_mulai = $(this).attr('detik_mulai');
                detik_akhir = $(this).attr('detik_akhir');
                if(strdetik<=detik_mulai && strdetik>=detik_akhir){
                var str = $(this).attr('class'), st = "show active";
                if(str.indexOf(st) > -1)
                {

                }else{
                    $('.tab-pane').removeClass('show active');
                    $(this).addClass('show active');
                    $('._radio').prop('checked', false);
                }
                }
        });
        @endif

        // Calculating the days, hours, minutes and seconds left
        // var days = Math.floor(timeleft / (1000 * 60 * 60 * 24));
        var hours = Math.floor((timeleft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((timeleft % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((timeleft % (1000 * 60)) / 1000);
            
        // Result is output to the specific element
        // document.getElementById("days").innerHTML = days + ""
        if(document.getElementById("hours"))document.getElementById("hours").innerHTML = hours + " Jam " 
        if(document.getElementById("mins"))document.getElementById("mins").innerHTML = minutes + " Menit " 
        if(document.getElementById("secs"))document.getElementById("secs").innerHTML = seconds + " Detik" 
            
        // console.log(timeleft);
        // Display the message when countdown is over
        if (timeleft < 0) {
            clearInterval(myfunc);
            // document.getElementById("days").innerHTML = ""
            // document.getElementById("hours").innerHTML = "" 
            // document.getElementById("mins").innerHTML = ""
            // document.getElementById("secs").innerHTML = ""
            document.getElementById("end").innerHTML = "Mohon Tunggu...";

            idsoalmst = $('#btn-selanjutnya').attr('soalmst');
            idpaketmst = "{{Crypt::encrypt($upaketsoalmst->id)}}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "{{url('selesaiujiankecermatan')}}",
                async: false,
                data: {
                    idpaketmst : idpaketmst
                },
                beforeSend: function () {
                    $.LoadingOverlay("show", {
                        image       : "{{asset('/image/global/loading.gif')}}"
                    });
                },
                success: function(response)
                {
                if (response.status) {
                    if(response.isterakhir=='ya'){
                        $('.modal').modal('hide');
                        Swal.fire({
                            html: 'Jawaban telah tersimpan, Ujian selesai',
                            icon: 'success',
                            showConfirmButton: true
                        }).then((result) => {
                            $.LoadingOverlay("show", {
                                image       : "{{asset('/image/global/loading.gif')}}"
                            });
                            if ("{{count($umapelmst->u_paket_soal_ktg_nonaktif_r)}}" > 0) {
                                $('#btn-lanjutsesi').click();
                            }else{
                                $('#btn-selesai').click();
                            }                        
                            //reload_url(1500,'{{url("detailhasilkecermatan")}}/{{Crypt::encrypt($upaketsoalmst->id)}}');
                        })
                    }else{
                        $.LoadingOverlay("show", {
                        image       : "{{asset('/image/global/loading.gif')}}"
                        });
                        reload(500);
                    }
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
        }, 1000);


  function ganti_soal(){
    nosoal++; 
    if(nosoal >= soals.length)return;
    var id = soals[nosoal];
    $('.tab-pane').removeClass('show active');
    $('#pills-' + id).addClass('show active');
    $('.btn-ganti-soal').removeClass('active');
    $('#btn-ganti-soal-' + id).addClass('active');
  }

</script>
<!-- Loading Overlay -->
@endsection