@extends('layouts.Skydash')
<!-- partial -->
@section('content')

@php

$firstsoal = NULL;
$soals     = implode(',', $soals);

@endphp

<div class="content-wrapper">
  <div class="row">    
    <div class="col-xl-9 col-md-9 col-sm-9 col-xs-9">
        <div class="soal_master" style="padding-bottom:20px">          
            <div class="row">
                <div class="table-responsive text-center" style="border-radius:0; border:solid 1px #ddd; padding:0;">
                  <h3 style="border:solid 1px #ddd; padding:8px 4px; margin:0; color:white;">Kolom {{$upaketsoalmst->current_kolom()}}</h3>
                  <table class="table table-bordered">
                      <tbody>
                        <tr>
                          @foreach(json_decode($soalmst->karakter) as $loopdatamaster)
                          <td><h2 style="color: white;"><b >{{$loopdatamaster}}</b></h2></td>
                          @endforeach
                        </tr> 
                        <tr>
                          @foreach(json_decode($soalmst->kiasan) as $loopdatamaster)
                          <td><h5 style="color: white;"><b>{{$loopdatamaster}}</b></h5></td>
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
                  <div class="child text-black"><h2 style="margin-bottom:0rem color: white">{{$loopdatadtl}}</h2></div>
                @endforeach
              </div>
              <div class="soal_dtl_bawah" style="border-top:solid 1px #ddd; padding:4px;">
                <div class="parent">
                  @foreach(json_decode($soalmst->kiasan) as $loopdatamaster)
                    <div class="child text-center text-black">
                      <h5 style="font-size:20px">{{$loopdatamaster}}</h5>
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
          <center><i>Soal Tidak Ditemukan!!!</i></center>
        </div>
        @endif
      </div>
    </div>

    <div class="col-xl-3 col-md-3 col-sm-3 col-xs-3" style="text-align:center;">   
    <div>
        <button type="button" class="btn btn-outline-primary btn-sm _btn-waktu">
          <h6 id="end text-black">Waktu Tersisa<br><span id="hours"></span><span id="mins"></span><span id="secs"></span></h6>
        </button>
    </div>
    <div style="margin-top:8px;">
      <button type="button" data-bs-toggle="modal" data-bs-target="#modalselesaiujian" class="btn btn-success btn-sm _btn_selesai_ujian _btn-waktu">
        <h6 class="text-black">Selesaikan Ujian</h6>
      </button>
    </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalselesaiujian">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Selesaikan Ujian?</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <center><h5 style="font-weight:unset"><i>Jika anda menyelesaikan ujian, anda tidak dapat lagi mengubah jawaban sebelumnya. Apakah anda yakin untuk menyelesaikan ujian ini?</i></h5></center>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer" style="display:block;text-align: center;">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tidak</button>
        <button type="button" class="btn btn-outline-danger" id="btn-selesai" soalmst="{{Crypt::encrypt($soalmst->id)}}">Ya</button>
      </div>

    </div>
  </div>
</div>

@endsection

@section('footer')
<!-- jQuery -->
<!-- SweetAlert2 -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">

  var nosoal = -1;

  var soals = [{{$soals}}];

  
  $(document).ready(function(){

      @if($firstsoal)
        ganti_soal();
      @endif

      $(document).on('click', '#btn-selesai', function (e) {
          idpaketmst = "{{Crypt::encrypt($upaketsoalmst->id)}}";
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.ajax({
              type: "POST",
              dataType: "JSON",
              url: "{{url('selesaiujiankecermatanfix')}}",
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
                    $('.modal').modal('hide');
                    Swal.fire({
                        html: 'Jawaban telah tersimpan. Ujian selesai!',
                        icon: 'success',
                        showConfirmButton: true
                    }).then((result) => {
                        $.LoadingOverlay("show", {
                          image       : "{{asset('/image/global/loading.gif')}}"
                        });
                        reload_url(1500,'{{url("detailhasilkecermatan")}}/{{Crypt::encrypt($upaketsoalmst->id)}}');
                    });
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

      // COUNDOWN
      // The data/time we want to countdown to

      var countDownDate = new Date("{{$soalmst->selesai}}").getTime();

      i=0;
      // Run myfunc every second
      var myfunc = setInterval(function() {

      const now = new Date('{{$now}}');
      now.setSeconds(now.getSeconds() + i);
      i++;

      var timeleft = (countDownDate - now);
      var strdetik = Math.floor(timeleft / 1000);

      @if(!$soalmst->waktu_total)
        $('.tab-pane').each(function(i, obj) {
              detik_mulai = $(this).attr('detik_mulai');
              detik_akhir = $(this).attr('detik_akhir');
              if(strdetik<=detik_mulai && strdetik>=detik_akhir){
                ganti_soal();

                //var str = $(this).attr('class'), st = "show active";
                //if(str.indexOf(st) > -1)
                //{

                //}else{
                  //$('.tab-pane').removeClass('show active');
                  //$(this).addClass('show active');
                  //$('._radio').prop('checked', false);
                //}
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
      document.getElementById("hours").innerHTML = hours + " Jam " 
      document.getElementById("mins").innerHTML = minutes + " Menit " 
      document.getElementById("secs").innerHTML = seconds + " Detik" 
          
      // console.log(timeleft);
      // Display the message when countdown is over
      if (timeleft < 0) {
          clearInterval(myfunc);
          // document.getElementById("days").innerHTML = ""
          // document.getElementById("hours").innerHTML = "" 
          // document.getElementById("mins").innerHTML = ""
          // document.getElementById("secs").innerHTML = ""
          document.getElementById("end").innerHTML = "Mohon Tunggu...";

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
        }
      }, 1000);
      // END COUNDOWN
  });

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


