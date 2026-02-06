@extends('layouts.Skydash')
<!-- partial -->
@section('content')
<style>
    .badge {
        opacity: 0.7;
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
                            <li class="breadcrumb-item active text-white" aria-current="page">Pembelian</li>
                            <li class="breadcrumb-item active text-white" aria-current="page">{{
                                $data->paket_mst_r->judul }}</li>
                        </ol>
                    </nav>
                    <p class="card-description">
                        <h3 class="font-weight-bold mb-4 text-white"><b>Panduan Pembayaran</b></h3>
                    </p>

                    <div class="text-white mb-4">
                        <p>No.Pembelian : <b>{{$data->merchant_order_id}}</b></p>
                        <p>Pembelian : {{$data->paket_mst_r->judul}}</p>
                        <p>{{Carbon\Carbon::parse($data->created_at)->translatedFormat('l, d
                            F Y , H:i:s')}}</p>
                        @if($data->channel_r)
                        <div class="row mt-3 mb-3" style="align-items:center">
                            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                <img src="{{$data->channel_r->img}}" alt="" width="100%">
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                <p>{{$data->channel_r->nama}}</p>
                                <p>Total Pembayaran : <strong>{{formatRupiahCekGratis($data->harga)}}</strong>
                                </p>
                            </div>
                        </div>
                        @else
                        <p>Total Pembayaran : <strong>{{formatRupiahCekGratis($data->harga)}}</strong></p>
                        @endif
                    </div>

                    <ol class="text-white mb-4">
                        <li>
                            <h6>Lakukan Transfer Pembayaran</h6>
                            <ul>
                                <li>Lakukan pembayaran sesuai jumlah yang tertera.</li>
                                <li>
                                    <div class="mb-2">
                                        Transfer ke salah satu nomer rekening berikut:
                                    </div>
                                    <div class="row">
                                        @foreach($daftar_rekening as $rekening)
                                            <div class="col-md-6 col-lg-4 mb-3">
                                                <div class="p-4 border rounded-4">
                                                    <div class="d-flex w-100 justify-content-between">
                                                        <div>
                                                            <h6>{{ $rekening['atas_nama'] }}</h6>
                                                            <h3>{{ $rekening['no_rek'] }}</h3>
                                                        </div>
                                                        <div>{{ $rekening['bank'] }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <div>Kirim Bukti Pembayaran ke Admin</div>
                            <ul>
                                <li>Setelah melakukan transfer, unggah bukti pembayaran Anda (foto/tangkapan layar) melalui WhatsApp admin.</li>
                            </ul>
                        </li>
                        <li>
                            <div>Konfirmasi dan Pemrosesan Pesanan melalui Whatsapp</div>
                            <ul>
                                <li>Admin akan memeriksa bukti pembayaran.</li>
                                <li>Jika bukti pembayaran valid, Admin akan memverifikasi pembayaran Anda.</li>
                            </ul>
                        </li>
                    </ol>

                    <div class="text-center">
                        <a href="https://wa.me/{{ $no_whatsapp }}?text=Halo%20Admin,%20saya%20ingin%20konfirmasi%20pembayaran.%20Berikut%20detail%20pesanan%20saya:%0A%0ANama:%20{{ $data->user_r->name }}%0ANomor%20Transaksi:%20{{ $data->merchant_order_id }}%0ATotal%20Pembayaran:%20{{ formatRupiah($data->harga) }}"
                            target="_blank"
                            style="display: inline-block; padding: 10px 20px; background-color: #25D366; color: #fff; text-decoration: none; border-radius: 5px;">
                            Konfirmasi Pembayaran ke WhatsApp
                        </a>
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
    $(document).ready(function () {
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
                        image: "{{asset('/image/global/loading.gif')}}"
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
                    } else {
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
