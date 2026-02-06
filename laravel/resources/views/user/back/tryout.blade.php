@extends('layouts.Skydash')

@section('content')
<div class="content-wrapper">
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="cardx card-border w-100">
        <div class="card-bodyx">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{url('home')}}"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item active" aria-current="page"><a href="{{url('tryout')}}">Try Out Akbar</a></li>
            </ol>
          </nav>
          <p class="card-description">
            <h3 class="font-weight-bold"><b>Try Out Akbar</b></h3>
          </p>
          <div class="row mt-4">
            @forelse($paket as $key)
            <div class="col-md-4 mb-4 stretch-card">

                <div class="card card-border">
                  <!-- <img src="{{url($key->banner)}}" alt="" style="width:100%;height:300px;object-fit:cover;border-top-left-radius: 20px;border-top-right-radius: 20px;"> -->
                  <div class="card-body py-4">
					<div class="row align-items-center mb-3" style="flex-wrap: nowrap !important;">
						<div class="col-2">
							<div class="icon-card bg-blue rounded-circle iconpaket">
								<i class="p-1 icon-paper position-relative" style="top:-2px"></i>
							</div>
						</div>
						<div class="col-8">
							<h4 class="fs-6 mb-0"><b>{{$key->judul}}</b></h4>
						</div>
					</div>
                      <div class="row align-items-center mb-3 text-xs">
                        <div class="media-body col-3 pe-0">
							<div class="text-xs fw-500 mb-1" style="color:#555">Waktu</div>
							  <h6 class="mb-1 text-sm fw-600"><i class="far fa-clock"></i> {{$key->waktu}} Menit</h6>

                        </div>
                        <div class="media-body col-4 pe-0">
							<div class="text-xs fw-500 mb-1" style="color:#555">Jumlah Soal</div>
                         <h6 class="mb-1 text-sm fw-600"><i class="far fa-sticky-note"></i> {{$key->total_soal}} Soal</h6>
                        </div>
                      </div>
                    <hr>
                    <div class="mb-3">
						<div class="text-xs fw-500 mb-1" style="color:#555">Tanggal Mulai</div>
                        <h6 class="text-sm fw-600">
                          {{$key->mulai}}
                        </h6>

						<div class="text-xs fw-500 mb-1" style="color:#555">Tanggal Selesai</div>
                        <h6 class="text-sm fw-600">
                          {{$key->selesai}}
                        </h6>
                    </div>

                    @php
                      $ceksudah = App\Models\UMapelMst::where('fk_user_id',Auth::id())->where('fk_mapel_mst',$key->id)->first();
                    @endphp

                      @if($ceksudah)
                          <a href="{{url('rankingpaket')}}/{{Crypt::encrypt($key->id)}}" type="button" class="mt-2 btn btn-md btn-new btn-block btn-icon-text">
                          <i class="fas fa-trophy btn-icon-prepend"></i>
                          Peringkat
                        </a>
                      @else
                          @if($now>$key->mulai && $now<$key->selesai)
                          <button data-bs-toggle="modal" data-bs-target="#myModal_{{$key->id}}" type="button" class="mt-2  btn btn-md btn-primary btn-block btn-icon-text  bg-green text-white rounded-pill">
                            <i class="fa fa-edit btn-icon-prepend"></i>
                            Kerjakan Soal
                          </button>
                          @elseif($now<$key->mulai)
                          <button type="button" class="mt-2 btn btn-md btn-warning btn-block btn-icon-text bg-lighrgreen text-white rounded-pill">
                            <i class="fas fa-exclamation-triangle"></i>
                            Belum dimulai
                          </button>
                            @else
                            <a href="{{url('rankingtryout')}}/{{Crypt::encrypt($key->id)}}" type="button" class="mt-2 btn btn-md btn-new btn-block btn-icon-text bg-blue text-white rounded-pill">
                              <i class="fas fa-trophy btn-icon-prepend"></i>
                              Peringkat
                            </a>
                          @endif
                      @endif




                  </div>
                </div>

            </div>

            <!-- The Modal -->
            <div class="modal fade" id="myModal_{{$key->id}}">
              <div class="modal-dialog">
              <div class="modal-content">

                <!-- Modal Header -->
                <!-- <div class="modal-header">
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div> -->

                <!-- Modal body -->
                <div class="modal-body">
                  <center style="font-size:18px"><i style="color:#D97706" class="fa fa-warning"></i> <span style="color:#D97706" class="modal-title"><b>Perhatian Sebelum Mengerjakan</b></span></center>
                  <!-- <h5>Peraturan</h5> -->
                  <div class="table-responsive mt-3">
                    <table class="table table-primary">
                    <tbody>
                      <tr>
                        <td>Try Out</td>
                        <td>{{$key->judul}}</td>
                      </tr>
                      <tr>
                        <td>Jumlah Soal</td>
                        <td>{{$key->total_soal}} Soal</td>
                      </tr>
                      <tr>
                        <td>Waktu Mengerjakan</td>
                        <td>{{$key->waktu}} Menit</td>
                      </tr>
                      @if($key->ket)
                      <tr>
                        <td>Keterangan</td>
                        <td>{!!$key->ket!!}</td>
                      </tr>
                      @endif
                      <!-- <tr>
                          <td>Passing Grade</td>
                          <td>{{$key->kkm}}</td>
                        </tr> -->
                    </tbody>
                    </table>
                  </div>

                  <ul class="mt-3">
                    <li>
                      Waktu akan berjalan ketika anda klik tombol <b>Kerjakan Sekarang</b>
                    </li>
                    <!-- <li>
                      Jawaban anda akan tersimpan secara otomatis
                    </li> -->
                    <li>
                      Jika waktu habis maka halaman akan otomatis keluar dan anda tidak bisa lagi mengerjakan soal
                    </li>
                    <li>
                      Jika waktu masi tersisa dan soal sudah selesai dikerjakan, silahkan klik tombol selesai ujian maka nilai akan keluar otomatis
                    </li>
                    <li>
                      Silahkan klik tombol <b>Kerjakan Sekarang</b> di bawah ini untuk memulai ujian.
                    </li>
                    <li>
                      Pastikan koneksi internet stabil saat mengerjakan soal.
                    </li>
                    <li>
                      Jangan lupa berdoa sebelum mengerjakan ujian.
                    </li>
                  </ul>

                </div>

                <!-- Modal footer -->
                <div class="modal-footer" style="justify-content:center">
                  <form method="post" id="formKerjakan_{{$key->id}}" class="form-horizontal">
                    @csrf
                    <input type="hidden" name="id_paket_soal_mst[]" value="{{Crypt::encrypt($key->id)}}">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary btn-kerjakan" idform="{{$key->id}}">Kerjakan Sekarang</button>
                  </form>
                </div>

              </div>
            </div>
          </div>

            @empty
            <center><img class="mb-3 img-no" src="{{asset('image/global/no-paket.png')}}" alt=""></center>
            <br>
            <center>Belum Ada Data</center>
            @endforelse
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
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})
  $(document).ready(function(){
			$( "li.nav-item.nonactive" ).removeClass( "active" );
			$( "li.nav-item.nonactive .collapse" ).removeClass( "show" );

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
                            // Swal.fire({
                            //   html: response.message,
                            //   icon: 'success',
                            //   showConfirmButton: false
                            // });
                            let timerInterval
                            Swal.fire({
                              title: response.message,
                              html: 'Mohon Tunggu... <b></b>',
                              timer: 2000,
                              timerProgressBar: true,
                              didOpen: () => {
                                Swal.showLoading()
                                const b = Swal.getHtmlContainer().querySelector('b')
                                timerInterval = setInterval(() => {
                                  b.textContent = Swal.getTimerLeft()
                                }, 100)
                              },
                              willClose: () => {
                                clearInterval(timerInterval)
                              }
                            }).then((result) => {
                              /* Read more about handling dismissals below */
                              if (result.dismiss === Swal.DismissReason.timer) {
                                reload_url(0,'{{url("ujian")}}/'+response.id);
                              }
                            })

                        }else{
                          if(response.cek){
                            Swal.fire({
                            icon: 'warning',
                            html: response.message,
                            showDenyButton: true,
                            showCancelButton: true,
                            confirmButtonText: 'Lanjutkan',
                            cancelButtonText: 'Batal',
                            denyButtonText: 'Selesaikan Ujian',
                            }).then((result) => {
                                /* Read more about isConfirmed, isDenied below */
                                if (result.isConfirmed) {
                                  window.location.href = '{{url("ujian")}}/'+response.idpaket;
                                }else if (result.isDenied){
                                  // Selesaikan Ujian
                                  idpaketmst = response.idpaket;
                                  $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });
                                    $.ajax({
                                        type: "POST",
                                        dataType: "JSON",
                                        url: "{{url('selesaiujian')}}",
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
                                                    html: response.message,
                                                    icon: 'success',
                                                    showConfirmButton: true
                                                }).then((result) => {
                                                    $.LoadingOverlay("show", {
                                                      image       : "{{asset('/image/global/loading.gif')}}"
                                                    });
                                                    reload_url(1500,'{{url("paketsayaktg")}}');
                                                })
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
                                  // Akhir Selesaikan Ujian
                                }
                            });
                          }else{
                            Swal.fire({
                                html: response.message,
                                icon: 'error',
                                confirmButtonText: 'Ok'
                            });
                          }
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


