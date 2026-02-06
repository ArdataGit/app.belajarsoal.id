@extends('layouts.Skydash')
<!-- partial -->
@section('content')
<style>
  .badge{
    opacity:0.7;
  }
</style>
<div class="content-wrapper">
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card card-border">
        <div class="card-body">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{url('home')}}"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item active" aria-current="page">Pembelian</li>
            </ol>
          </nav>
          <p class="card-description">
            <h3 class="font-weight-bold mb-3"><b>Pembelian</b></h3>
            <div class="card card-inverse-info mb-3">
                <div class="card-body">
                  <p class="card-text">
                    <h4><i class="ti-info"></i> Informasi</h4>
                    <div class="informasi">
                      <ul>
                        <li>Pembayaran diverifikasi otomatis oleh sistem.</li>
                        <li>Apabila dalam 30 menit setelah pembayaran namun pembelian belum terkonfirmasi, silahkan hubungi kami melalui WhatsApp {{ $template->no_hp }}</li>
                      </ul>
                    </div>
                  </p>
                </div>
             </div>
          </p>
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="">

                <ul class="nav nav-pills btn-menu-hasil" role="tablist">
                  <li class="nav-item">
                    <a class="btn btn-sm btn-primary nav-link btn-tab-hasil active" data-toggle="pill" href="#menunggu"><i class="ti-timer"></i> Menunggu pembayaran</a>
                  </li>
                  <li class="nav-item">
                    <a class="btn btn-sm btn-primary nav-link btn-tab-hasil" data-toggle="pill" href="#batal"><i class="ti-close"></i> Pembayaran batal</a>
                  </li>
                  <li class="nav-item">
                    <a class="btn btn-sm btn-primary nav-link btn-tab-hasil" data-toggle="pill" href="#selesai"><i class="ti-check"></i> Pembayaran selesai</a>
                  </li>
                </ul>
                
                <!-- Tab panes -->
                <div class="tab-content tab-hasil-ujian">
                  <div id="menunggu" class="tab-pane active"><br>
                        @forelse($data->where('status',0) as $key)
                        @php
                        $idstatus = $key->status;
                        if(Carbon\Carbon::now()  > $key->expired && $idstatus==0){
                          $idstatus = 2;
                          $dataupdate['status'] = 2;
                          \App\Models\Transaksi::find($key->id)->update($dataupdate);
                        }
                        @endphp
                        @if($idstatus==0)
                        <div class="row mb-3">
                          <div class="col-md-9">
                              <p>No.Pembelian : <b>{{$key->merchant_order_id}}</b></p>
                              <p>Pembelian : {{$key->paket_mst_r->judul}}</p>
                              <p>{{Carbon\Carbon::parse($key->created_at)->translatedFormat('l, d F Y , H:i:s')}}</p>
                              @if($key->channel_r)
                              <div class="row mt-3 mb-3" style="align-items:center">
                                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                    <img src="{{$key->channel_r->img}}" alt="" width="100%">
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                  <p>{{$key->channel_r->nama}}</p>
                                  <p>Total Pembayaran : {{formatRupiahCekGratis($key->harga)}}</p>
                                  <p style="margin-bottom:0px">Batas Pembayaran : <span class="text-danger">{{Carbon\Carbon::parse($key->expired)->translatedFormat('l, d F Y , H:i:s')}} WIB</span></p>
                                </div>
                              </div>
                              @else
                              <p>Total Pembayaran : {{formatRupiahCekGratis($key->harga)}}</p>
                              <p style="margin-bottom:0px">Batas Pembayaran : <span class="text-danger">{{Carbon\Carbon::parse($key->expired)->translatedFormat('l, d F Y , H:i:s')}} WIB</span></p>
                              @endif
                          </div>
                          <div class="col-md-3" style="text-align:right">
                          <label class="badge badge-outline-primary mb-4 mt-1">Menunggu Pembayaran</label>
                          <p><a target="_blank" href="{{$key->payment_url}}" type="button" class="mt-1 btn btn-primary btn-sm btn-fw" style="color: white !important;">Panduan Pembayaran</a></p>
                          <p><button data-bs-toggle="modal" data-bs-target="#myModal{{$key->id}}" type="button" class="mt-1 btn btn-danger btn-sm btn-fw">Batalkan Pembelian</button></p>
                          </div>
                        </div>

                          <!-- The Modal -->
                            <div class="modal fade" id="myModal{{$key->id}}">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <form method="post" id="formHapus_{{$key->id}}" class="form-horizontal">
                                    @csrf
                                        <div class="modal-body">
                                          Apakah kamu yakin ingin membatalkan pembelian paket {{$key->paket_mst_r->judul}}?
                                        </div>
                                        <!-- Modal footer -->
                                        <div class="modal-footer" id="modal-batal-beli">
                                        <!-- <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">Tidak</button> -->
                                        <input type="hidden" name="idtransaksi[]" value="{{Crypt::encrypt($key->id)}}">

                                        <button type="button" class="btn-batalkan btn btn-md btn-danger" idform="{{$key->id}}">Ya, Batalkan</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                                        </div>
                                  </form>
                                </div>
                              </div>
                            </div>

                        @endif
                      @empty
                      <center><img class="mb-3 img-no" src="{{asset('image/global/no-transaksi.png')}}" alt=""></center>
                      <br>
                      <center>Belum Ada Data</center>
                      @endforelse
                      <!-- <div class="table-responsive">
                          <table class="table table-hover">
                            <thead>
                              <tr>
                                <th>No.Transaksi</th>
                                <th>Paket</th>
                                <th>Jumlah</th>
                                <th>Tanggal Transaksi</th>
                                <th>Bayar Sebelum</th>
                                <th>Status</th>
                              </tr>
                            </thead>
                            <tbody>
                              @if(count($data)>0)
                              @foreach($data->where('status',0) as $key)
                              <tr>
                                <td width="40%">{{$key->merchant_order_id}}</td>
                                <td width="40%">{{$key->paket_mst_r->judul}}</td>
                                  <td width="10%" style="text-align:right" class="font-weight-bold">{{formatRupiahCekGratis($key->harga)}}</td>
                                  <td>
                                    {{Carbon\Carbon::parse($key->created_at)->translatedFormat('l, d F Y , H:i:s')}}
                                  </td>
                                  <td>
                                    @php
                                    $idstatus = $key->status;
                                 
                                    @endphp

                                    @if($idstatus==0)
                                      {{Carbon\Carbon::parse($key->expired)->translatedFormat('l, d F Y , H:i:s')}}
                                    @endif
                                  </td>
                                  <td width="10%">
                                  
                                    <label class="{{statuspayment($idstatus,2)}}">{{statuspayment($idstatus,1)}}</label>
                                    @if($idstatus==0)
                                    <a target="_blank" href="{{$key->payment_url}}">
                                      <label class="_hover badge badge-info">Konfirmasi</label>
                                    </a>
                                    @endif
                                  </td>

                                  @php
                                  $idstatus = $key->status;

                                  if($key->expired < Carbon\Carbon::now()){
                                  }
                                  else{
                                  }
                                  @endphp
                         
                                
                                </tr>
                                @endforeach
                              @else
                                <tr>
                                  <td colspan="5" style="text-align:center" class="font-weight-bold">Belum Ada Transaksi</td>
                                </tr>
                              @endif
                            </tbody>
                          </table>
                        </div> -->
                  </div>
                  <div id="batal" class="tab-pane"><br>
                        @forelse($data->where('status',2) as $key)
                        
                        <div class="row mb-3">
                          <div class="col-md-8">
                              <p>No.Pembelian : <b>{{$key->merchant_order_id}}</b></p>
                              <p>Pembelian : {{$key->paket_mst_r->judul}}</p>
                              <p>{{Carbon\Carbon::parse($key->created_at)->translatedFormat('l, d F Y , H:i:s')}}</p>
                              @if($key->channel_r)
                              <div class="row mt-3 mb-3" style="align-items:center">
                                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                    <img src="{{$key->channel_r->img}}" alt="" width="100%">
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                  <p>{{$key->channel_r->nama}}</p>
                                  <p style="margin-bottom:0px">Total Pembayaran : {{formatRupiahCekGratis($key->harga)}}</p>
                                  <!-- <p style="margin-bottom:0px">Batas Pembayaran : <span class="text-danger">{{Carbon\Carbon::parse($key->expired)->translatedFormat('l, d F Y , H:i:s')}} WIB</span></p> -->
                                </div>
                              </div>
                              @else
                              <p>Total Pembayaran : {{formatRupiahCekGratis($key->harga)}}</p>
                              <!-- <p style="margin-bottom:0px">Batas Pembayaran : <span class="text-danger">{{Carbon\Carbon::parse($key->expired)->translatedFormat('l, d F Y , H:i:s')}} WIB</span></p> -->
                              @endif
                          </div>
                          <div class="col-md-4" style="text-align:right">
                          <label class="badge badge-outline-danger mb-4 mt-1">Pembayaran Batal</label>
                          
                          </div>
                        </div>
                      
                      @empty
                      <center><img class="mb-3 img-no" src="{{asset('image/global/no-transaksi.png')}}" alt=""></center>
                      <br>
                      <center>Belum Ada Data</center>
                      @endforelse
                  </div>
                  <div id="selesai" class="tab-pane"><br>
                      @forelse($data->where('status',1) as $key)
                        <div class="row mb-3">
                          <div class="col-md-8">
                              <p>No.Pembelian : <b>{{$key->merchant_order_id}}</b></p>
                              <p>Pembelian : {{$key->paket_mst_r->judul}}</p>
                              <p>{{Carbon\Carbon::parse($key->created_at)->translatedFormat('l, d F Y , H:i:s')}}</p>
                              @if($key->channel_r)
                              <div class="row mt-3 mb-3" style="align-items:center">
                                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                    <img src="{{$key->channel_r->img}}" alt="" width="100%">
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                  <p>{{$key->channel_r->nama}}</p>
                                  <p style="margin-bottom:0px">Total Pembayaran : {{formatRupiahCekGratis($key->harga)}}</p>
                                  <!-- <p style="margin-bottom:0px">Batas Pembayaran : <span class="text-danger">{{Carbon\Carbon::parse($key->expired)->translatedFormat('l, d F Y , H:i:s')}} WIB</span></p> -->
                                </div>
                              </div>
                              @else
                              <p>Total Pembayaran : {{formatRupiahCekGratis($key->harga)}}</p>
                              <!-- <p style="margin-bottom:0px">Batas Pembayaran : <span class="text-danger">{{Carbon\Carbon::parse($key->expired)->translatedFormat('l, d F Y , H:i:s')}} WIB</span></p> -->
                              @endif
                          </div>
                          <div class="col-md-4" style="text-align:right">
                          <label class="badge badge-outline-success mb-4 mt-1">Pembayaran Selesai</label>
                          
                          </div>
                        </div>
                      @empty
                      <center><img class="mb-3 img-no" src="{{asset('image/global/no-transaksi.png')}}" alt=""></center>
                      <br>
                      <center>Belum Ada Data</center>
                      @endforelse
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
<!-- jQuery -->
<script>
  $(document).ready(function(){
      // alert('x');
          //Fungsi Hapus Data
    $(document).on('click', '.btn-batalkan', function (e) {
        idform = $(this).attr('idform');
        var formData = new FormData($('#formHapus_' + idform)[0]);

        var url = "{{ url('/batalkanpesanan') }}";
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


