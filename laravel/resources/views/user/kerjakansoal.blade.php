@extends('layouts.Skydash')
<!-- partial -->
<style>
  .modal-footer{
    display: block !important;
    text-align: center;
  }
  .card{
    box-shadow: rgb(0 0 0 / 25%) 0px 54px 55px, rgb(0 0 0 / 12%) 0px -12px 30px, rgb(0 0 0 / 12%) 0px 4px 6px, rgb(0 0 0 / 17%) 0px 12px 13px, rgb(0 0 0 / 9%) 0px -3px 5px !important;
  }
  h5.txt-success{
    font-size:1.125rem;
    margin-bottom:0px;
    color:green;
  }
  h5.txt-danger{
    font-size:1.125rem;
    margin-bottom:0px;
    color:red;
  }
  .template-demo span{
    padding:0px 10px;
  }
  .img-banner{
    width:100%;height:15vw;object-fit:cover;margin-bottom: 0px;border-radius: 20px;
  }
  ._mb-4{
      margin-bottom:1rem;
    }
  @media(max-width: 768px){
    .template-demo span{
       padding:0px 0.5vw;
    } 
    .img-banner{
      height:50vw;
      margin-bottom: 5vw;
    }
    ._mb-4{
      margin-bottom:1vw;
    }
  }
</style>
@php
  $now = Carbon\Carbon::now()->toDateTimeString();
  $datenow = Carbon\Carbon::now()->toDateString();
  $val = 0;
  $x = "";
@endphp
@section('content')
<div class="content-wrapper">
  <!-- <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-12 col-xl-12 _mb-4" style="text-align:center">
          <h3 class="font-weight-bold">Jadwal</h3>
          <h2 class="font-weight-bold"></h2>
        </div>  
      </div>
    </div>
  </div> -->
  <div class="row pilihan_ganda mt-3">
  @if(count($paket)>0)
  @foreach($paket as $key)
    @php
      $cekdata = App\Models\Transaksi::where('fk_user_id','=',Auth::user()->id)->where('status',1)->pluck('fk_event_mst_id')->all();
      if($cekdata){
        $arr = App\Models\EventDtl::whereIn('fk_event_mst',$cekdata)->pluck('fk_mapel_mst')->all(); 
        if (in_array($key->id, $arr))
          {
            $val = 1;
          }
          else
          {
            $val = 0;
          }
        }else{
          $val = 0;
      }

      $eventdtl_cek = App\Models\EventDtl::where('fk_mapel_mst',$key->id)->first();
      if($eventdtl_cek){
        $eventmst_cek = App\Models\EventMst::find($eventdtl_cek->fk_event_mst);
        
        $cekdata2 = App\Models\Transaksi::where('fk_user_id','=',Auth::user()->id)->where('status',1)->where('fk_event_mst_id',$eventdtl_cek->fk_event_mst)->first();
   
        if($cekdata2){
          if (in_array($eventdtl_cek->id, json_decode($cekdata2->fk_mapel_mst)))
              {
                $val = 1;
              }
              else
              {
                $val = 0;
              }
        }
      }else{
        $val=0;
      }

    @endphp

    @if($key->total_soal>0 && $val==1)
    @php
      $x = "ada";
    @endphp
    <div class="col-md-12 grid-margin-md-0 stretch-card" style="margin-bottom:15px">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-4">
              <img class="img-banner" src="{{asset($key->banner)}}" alt="">
            </div>
            <div class="col-md-8">
              <h3>{{$eventmst_cek->judul}}</h3>
              <h4 style="color:#999999">{{$key->judul}}</h4>
              <h6 style="margin-bottom: 1rem;">{{waktuIndo($key->mulai)}} s/d {{waktuIndo($key->selesai)}}</h6>
              <div class="row" style="align-items:center;">
                <div class="col-3 col-md-1 col-lg-1" style="padding:0px 0px 0px 15px">
                  <img width="80%" src="{{asset('image/global/jam.png')}}" alt="">
                </div>
                <div class="col-9 col-md-11 col-lg-11" style="padding:0px">
                  @php
                  $datediff = Carbon\Carbon::parse($key->mulai);
                  $datemulai = $datediff->toDateString();
                  
                  $dateselesai = Carbon\Carbon::parse($key->selesai)->toDateTimeString();
                  
                  $nowdiff = Carbon\Carbon::now();
                  $diff = $datediff->diffInDays($nowdiff);
                  @endphp
                  @if($datenow==$datemulai)
                  <h5 class="txt-success">
                    Hari ini
                  </h5>
                  @elseif($datemulai>$datenow)
                  <h5 class="txt-success">
                    {{$diff+1}} Hari Lagi
                  </h5>
                  @else
                    @if($now >$dateselesai)
                    <h5 class="txt-danger">
                      Berakhir
                    </h5>
                    @else
                    <h5 class="txt-success">
                      Sedang Berlangsung
                    </h5>
                    @endif
                  @endif
                </div>
              </div>
       
              <div class="template-demo mt-4 d-flex justify-content-center flex-nowrap">
                  <span data-bs-toggle="tooltip" data-bs-placement="left" title="Pengumuman">
                    <button data-bs-toggle="modal" data-bs-target="#myModalPengumuman_{{$key->id}}" type="button" class="btn btn-primary btn-rounded btn-icon">
                      <img style="width:100%" src="{{asset('image/global/speaker.png')}}" alt="">
                    </button>
                  </span>
                  <span data-bs-toggle="tooltip" data-bs-placement="left" title="Ranking">
                    <a target="_blank" href="{{url('rankingpaket')}}/{{Crypt::encrypt($key->id)}}" type="button" class="btn btn-danger btn-rounded btn-icon">
                      <img style="width:90%" src="{{asset('image/global/ranking.png')}}" alt="">
                    </a>
                  </span>
    
                  @php
                      $ceksudah = App\Models\UMapelMst::where('fk_user_id',Auth::id())->where('fk_mapel_mst',$key->id)->first();
                    @endphp

                      @if($ceksudah)
                        <span data-bs-toggle="tooltip" data-bs-placement="left" title="Klaim Hadiah">
                          <a href="{{url('klaimhadiah')}}/{{Crypt::encrypt($key->id)}}" type="button" class="btn btn-info btn-rounded btn-icon">
                            <img style="width:85%" src="{{asset('image/global/gift.png')}}" alt="">
                          </a>
                        </span>
                      @else
                          @if($now>$key->mulai && $now<$key->selesai)
                          <span data-bs-toggle="tooltip" data-bs-placement="left" title="Kerjakan">
                            <button data-bs-toggle="modal" data-bs-target="#myModal_{{$key->id}}" type="button" class="btn btn-success btn-rounded btn-icon">
                              <img style="width:60%" src="{{asset('image/global/pencil.png')}}" alt="">
                            </button>
                          </span>
                          @elseif($now<$key->mulai)
                            <span class="disabled" data-bs-toggle="tooltip" data-bs-placement="left" title="Ujian belum dimulai">
                              <button type="button" class="disabled btn btn-secondary btn-rounded btn-icon">
                                <img style="width:60%" src="{{asset('image/global/pencil.png')}}" alt="">
                              </button>
                            </span>
                            @else
                            <span class="disabled" data-bs-toggle="tooltip" data-bs-placement="left" title="Ujian sudah berakhir">
                                  <button type="button" class="disabled btn btn-secondary btn-rounded btn-icon">
                                    <img style="width:60%" src="{{asset('image/global/pencil.png')}}" alt="">
                                  </button>
                            </span>
                          @endif
                      @endif
                  
                       @if($ceksudah && $key->bagi_jawaban==1)
                      <!-- <button type="button" class="btn disabled btn-secondary btn-icon-text btn-block btn-sm">
                        <i class="ti-lock btn-icon-prepend"></i>
                        Sudah Mengerjakan
                      </button> -->
                      <span data-bs-toggle="tooltip" data-bs-placement="left" title="Pembahasan">
                        <a target="_blank" href="{{url('detailhasil')}}/{{Crypt::encrypt($ceksudah->id)}}" type="button" class="btn btn-info btn-rounded btn-icon">
                          <img style="width:85%" src="{{asset('image/global/note.png')}}" alt="">
                        </a>
                      </span>
                      @else
                      <span class="disabled" data-bs-toggle="tooltip" data-bs-placement="left" title="Belum ada pembahasan">
                        <button type="button" class="disabled btn btn-secondary btn-rounded btn-icon">
                          <img style="width:85%" src="{{asset('image/global/note.png')}}" alt="">
                        </button>
                      </span>
                      @endif

                      @if($ceksudah && $key->sertifikat==1)
                      <!-- <button type="button" class="btn disabled btn-secondary btn-icon-text btn-block btn-sm">
                        <i class="ti-lock btn-icon-prepend"></i>
                        Sudah Mengerjakan
                      </button> -->
                      <span data-bs-toggle="tooltip" data-bs-placement="left" title="Sertifikat">
                        <a target="_blank" href="{{url('sertifikat')}}/{{base64_encode($ceksudah->id)}}/{{base64_encode(Auth::user()->id)}}" type="button" class="btn btn-primary btn-rounded btn-icon">
                          <img style="width:85%" src="{{asset('image/global/certificate.png')}}" alt="">
                        </a>
                      </span>
                      <span data-bs-toggle="tooltip" data-bs-placement="left" title="Piagam">
                        <a target="_blank" href="{{url('piagam')}}/{{base64_encode($ceksudah->id)}}/{{base64_encode(Auth::user()->id)}}" type="button" class="btn btn-warning btn-rounded btn-icon">
                          <img style="width:85%" src="{{asset('image/global/medall.png')}}" alt="">
                        </a>
                      </span>
                      @else
                      <span class="disabled" data-bs-toggle="tooltip" data-bs-placement="left" title="Belum ada sertifikat">
                        <button type="button" class="disabled btn btn-secondary btn-rounded btn-icon">
                          <img style="width:85%" src="{{asset('image/global/certificate.png')}}" alt="">
                        </button>
                      </span>
                      <span class="disabled" data-bs-toggle="tooltip" data-bs-placement="left" title="Belum ada piagam">
                        <button type="button" class="disabled btn btn-secondary btn-rounded btn-icon">
                          <img style="width:85%" src="{{asset('image/global/medall.png')}}" alt="">
                        </button>
                      </span>
                      @endif
                </div>
                <br>
              <!-- <p class="card-description">Add class <code>.list-star</code> to <code>&lt;ul&gt;</code></p> -->
              <!-- <div>
                {!!$key->ket!!}
              </div> -->
            </div>
          </div>
          
        </div>
      </div>
    </div>

    <!-- The Modal -->
    <div class="modal fade" id="myModal_{{$key->id}}">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Kerjakan Soal {{$key->judul}}</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <h5>Peraturan</h5>
            <ul>
              <li>
                Waktu akan berjalan ketika anda klik tombol <b>Mulai Ujian</b>
              </li>
              <li>
                Jawaban anda akan tersimpan secara otomatis
              </li>
              <li>
                Jika waktu habis maka halaman akan otomatis keluar dan anda tidak bisa lagi mengerjakan soal
              </li>
              <li>
                Jika waktu masi tersisa dan soal sudah selesai dikerjakan, silahkan klik tombol selesai ujian maka nilai akan keluar otomatis
              </li>
              <li>
                Silahkan klik tombol <b>Mulai Ujian</b> di bawah ini untuk memulai ujian.
              </li>
              <li>
                Jangan lupa berdoa sebelum mengerjakan ujian.
              </li>
            </ul>
            <div class="table-responsive">

            <table class="table table-warning">
            <tbody>
              <!-- <tr>
                <td>Waktu</td>
                <td>{{$key->waktu}} Menit</td>
              </tr> -->
              <tr>
                <td>Total Soal</td>
                <td>{{$key->total_soal}} Butir</td>
              </tr>
              <!-- <tr>
                <td>Sistem Penilaian</td>
                <td>{{$key->nama_jenis_penilaian}}</td>
              </tr> -->
              <!-- <tr>
                  <td>Passing Grade</td>
                  <td>{{$key->kkm}}</td>
                </tr> -->
            </tbody>
          </table>
          </div>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <form method="post" id="formKerjakan_{{$key->id}}" class="form-horizontal">
              @csrf
              <input type="hidden" name="id_paket_soal_mst[]" value="{{Crypt::encrypt($key->id)}}">
              <button type="button" class="btn btn-outline-primary btn-kerjakan" idform="{{$key->id}}">Mulai Ujian</button>
            </form>
          </div>

        </div>
      </div>
    </div>

    <!-- The Modal -->
    <div class="modal fade" id="myModalPengumuman_{{$key->id}}">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Pengumuman</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
              @if($key->pengumuman)
                {!!$key->pengumuman!!}
              @else
                <center>Belum Ada Pengumuman</center>
              @endif
          </div>



        </div>
      </div>
    </div>
    @endif
    @endforeach
    
    @if($x=="")
    <div style="text-align:center;padding-top:15px">
      <h5>Belum Ada Jadwal</h5>
    </div>
    @endif

  @else
    <div style="text-align:center;padding-top:15px">
      <h5>Belum Ada Jadwal</h5>
    </div>
  @endif
  </div>
</div>

@endsection

@section('footer')
<!-- SweetAlert2 -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  // Initialize tooltips
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})
  $(document).ready(function(){
    // $('[data-bs-toggle="tooltip"]').tooltip({
    //     trigger : 'hover'
    // });
    //Fungsi Kerjakan Soal
    $(document).on('click', '.btn-kerjakan', function (e) {

        idform = $(this).attr('idform');
        var formData = new FormData($('#formKerjakan_' + idform)[0]);

        var url = "{{ url('/mulaiujian') }}/"+idform;
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
                $.LoadingOverlay("show", {
                    image       : "{{asset('/image/global/loading.gif')}}"
                });
            },
            success: function (response) {
                    if (response.status == true) {
                      $('.modal').modal('hide');
                      Swal.fire({
                          html: response.message,
                          icon: 'success',
                          showConfirmButton: false
                        });
                        reload_url(2000,'{{url("ujian")}}/'+response.id);
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

    //Fungsi Kerjakan Soal
      $(document).on('click', '.btn-kerjakan-kecermatan', function (e) {
        idform = $(this).attr('idform');
        var formData = new FormData($('#formKerjakanKecermatan_' + idform)[0]);

        var url = "{{ url('/mulaiujiankecermatan') }}/"+idform;
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
                $.LoadingOverlay("show", {
                    image       : "{{asset('/image/global/loading.gif')}}"
                });
            },
            success: function (response) {
                    if (response.status == true) {
                      $('.modal').modal('hide');
                      Swal.fire({
                          html: response.message,
                          icon: 'success',
                          showConfirmButton: false
                        });
                        reload(2000);
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


