@extends('layouts.Skydash')
<!-- partial -->
<style>
  .modal-footer{
    display: block !important;
    text-align: center;
  }
</style>
@section('content')
<div class="content-wrapper">
  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-12 col-xl-12 mb-4 mb-xl-0" style="text-align:center">
          <h3 class="font-weight-bold">Paket Soal Umum</h3>
          <h2 class="font-weight-bold"></h2>
          <!-- <h6 class="font-weight-normal mb-0">Sudah siap belajar apa hari ini? Jangan lupa semangat karena banyak latihan dan tryout yang masih menunggu untuk diselesaikan.</h6> -->
        </div>  
      </div>
    </div>
  </div>
  <div class="row pilihan_ganda">
  @php
    $cekpaket = App\Models\PaketUser::where('fk_user','=',Auth::user()->id)->where('jenis',1)->get();
  @endphp

  @if(count($paket)>0 && count($cekpaket)>0)
  @foreach($paket as $key)
    @php
      $cekdata = App\Models\PaketUser::where('fk_user','=',Auth::user()->id)->where('jenis',1)->where('fk_paket_soal_mst',$key->id)->first();
    @endphp
      @if($cekdata && $key->total_soal>0)
      <div class="col-md-4 grid-margin-md-0 stretch-card" style="margin-bottom:15px">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title card-header-paket">{{$key->judul}}</h4>
            <!-- <p class="card-description">Add class <code>.list-star</code> to <code>&lt;ul&gt;</code></p> -->
            <div>
              {!!$key->ket!!}
            </div>
            <div>
                  <button type="button" class="btn btn-primary btn-icon-text btn-block btn-sm" data-bs-toggle="modal" data-bs-target="#myModal_{{$key->id}}">
                  <i class="ti-unlock btn-icon-prepend"></i>
                  Kerjakan Soal
                </button>
                <a href="{{url('rankingpaket')}}/{{Crypt::encrypt($key->id)}}" type="button" class="btn btn-success btn-icon-text btn-block btn-sm">
                <i class="ti-medall btn-icon-prepend"></i>
                Ranking
              </a>
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
              <h4 class="modal-title">Kerjakan Paket Soal {{$key->judul}}</h4>
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
                <tr>
                  <td>Waktu</td>
                  <td>{{$key->waktu}} Menit</td>
                </tr>
                <tr>
                  <td>Total Soal</td>
                  <td>{{$key->total_soal}} Butir</td>
                </tr>
                <tr>
                <td>Sistem Penilaian</td>
                <td>{{$key->nama_jenis_penilaian}}</td>
              </tr>
              <tr>
                  <td>KKM</td>
                  <td>{{$key->kkm}}</td>
                </tr>
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
      @endif
    @endforeach
  @else
    <div style="text-align:center;padding-top:15px">
      <h5>Belum Ada Paket</h5>
    </div>
  @endif
  </div>
  <br>
  <br>
  <br>
  <div class="row">
    <div class="col-12 col-xl-12 mb-4 mb-xl-0" style="text-align:center">
      <h3 class="font-weight-bold">Paket Soal Kecermatan</h3>
      <h2 class="font-weight-bold"></h2>
      <!-- <h6 class="font-weight-normal mb-0">Sudah siap belajar apa hari ini? Jangan lupa semangat karena banyak latihan dan tryout yang masih menunggu untuk diselesaikan.</h6> -->
    </div>  
  </div>
  <div class="row kecermatan">
  @php
    $cekpaket = App\Models\PaketUser::where('fk_user','=',Auth::user()->id)->where('jenis',2)->get();
  @endphp

  @if(count($paketkecermatan)>0 && count($cekpaket)>0)
  @foreach($paketkecermatan as $key)
      @php
        
        $cekdata = App\Models\PaketUser::where('fk_user','=',Auth::user()->id)->where('jenis',2)->where('fk_paket_soal_mst',$key->id)->first();
        
        $idmastersoal = App\Models\PaketSoalKecermatanDtl::where('fk_paket_soal_kecermatan_mst',$key->id)->pluck('fk_master_soal_kecermatan')->all();
        $jumlahsoaldtl = App\Models\DtlSoalKecermatan::whereIn('fk_master_soal_kecermatan',$idmastersoal)->get();

      @endphp
      @if($cekdata && $key->total_soal>0 && count($jumlahsoaldtl)>0)
      <div class="col-md-4 grid-margin-md-0 stretch-card" style="margin-bottom:15px">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title card-header-paket">{{$key->judul}}</h4>
            <!-- <p class="card-description">Add class <code>.list-star</code> to <code>&lt;ul&gt;</code></p> -->
            <div>
              {!!$key->ket!!}
            </div>
            <div>
                <button type="button" class="btn btn-primary btn-icon-text btn-block btn-sm" data-bs-toggle="modal" data-bs-target="#myModalKecermatan_{{$key->id}}">
                  <i class="ti-unlock btn-icon-prepend"></i>
                  Kerjakan Soal
                </button>
                <a href="{{url('rankingpaketkec')}}/{{Crypt::encrypt($key->id)}}" type="button" class="btn btn-success btn-icon-text btn-block btn-sm">
                  <i class="ti-medall btn-icon-prepend"></i>
                  Ranking
                </a>
            </div>
          </div>
        </div>
      </div>

      <!-- The Modal -->
      <div class="modal fade" id="myModalKecermatan_{{$key->id}}">
        <div class="modal-dialog">
          <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Kerjakan Paket Soal {{$key->judul}}</h4>
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
                <tr>
                  <td>Waktu</td>
                  <td>Per/Soal</td>
                </tr>
                <tr>
                  <td>Total Soal</td>
                  <td>{{$key->total_soal}} Butir Master / {{count($jumlahsoaldtl)}} Butir Detail</td>
                </tr>
                <tr>
                  <td>KKM</td>
                  <td>{{$key->kkm}}</td>
                </tr>
              </tbody>
            </table>
              </div>
              
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
              <form method="post" id="formKerjakanKecermatan_{{$key->id}}" class="form-horizontal">
                @csrf
                <input type="hidden" name="id_paket_soal_mst[]" value="{{Crypt::encrypt($key->id)}}">
                <button type="button" class="btn btn-outline-primary btn-kerjakan-kecermatan" idform="{{$key->id}}">Mulai Ujian</button>
              </form>
            </div>

          </div>
        </div>
      </div>
      @endif
    @endforeach
    @else
    <div style="text-align:center;padding-top:15px">
      <h5>Belum Ada Paket</h5>
    </div>
    @endif
  </div>
</div>

@endsection

@section('footer')
<!-- SweetAlert2 -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  $(document).ready(function(){
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


