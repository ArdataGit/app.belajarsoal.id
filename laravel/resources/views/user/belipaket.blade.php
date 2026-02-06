@extends('layouts.Skydash')
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="cardx card-border w-100">
                    <div class="card-bodyx">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item text-white"><a href="{{ url('home') }}"><i
                                            class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item active text-white" aria-current="page"><a
                                        href="{{ url('belipaketktg') }}">Beli Paket</a></li>
                            </ol>
                        </nav>
                        <p class="card-description">
                        <h3 class="font-weight-bold text-white"><b>Pilih Paket</b></h3>
                        </p>

                        <!-- Input Search -->
                        <input type="text" id="searchPaket" class="form-control mb-3 mt-3" placeholder="Cari paket...">

                        <div class="row mt-4" id="paketContainer">
                            @forelse($paket as $key)
                                @if ($key->is_gratis != 1)
                                    <div class="col-md-4 stretch-card mb-4 paket-item"
                                        data-judul="{{ strtolower($key->judul) }}">
                                        @php
                                            $ceksudahbeli = App\Models\Transaksi::where('fk_paket_mst', $key->id)
                                                ->where('status', 1)
                                                ->where('aktif_sampai', '>=', \Carbon\Carbon::now())
                                                ->where('fk_user_id', Auth::id())
                                                ->first();
                                        @endphp

                                        <a href="{{ $ceksudahbeli
                                            ? url('paketsayadetail') . '/' . Crypt::encrypt($key->id)
                                            : url('paketdetail') . '/' . Crypt::encrypt($key->id) }}"
                                            class="hrefpaket d-flex w-100">

                                            <div class=" w-100"
                                                style="border: 1px solid white; background-color: #1B1F2B; color: white; padding: 10px; border-radius: 25px;">
                                                <div class="card-body px-7 py-6 w-100">
                                                    <h3 class="fs-5 text-white mb-4"><b>{{ $key->judul }}</b></h3>
                                                    <div class="row" style="align-items:center">
                                                        <div class="col-12">
                                                            <span
                                                                class="coret me-2 mt-1 text-yellow">{{ formatCoret($key->harga) }}</span>
                                                            <span
                                                                class="btn text-xs btn-sm btn-primary bg-blue py-1 px-2 text-sm me-3">Diskon
                                                                50%</span>
                                                            <div class="fs-3 text-white fw-bold mt-1 mb-4">
                                                                {{ formatRupiah($key->harga) }}</div>
                                                        </div>
                                                    </div>
                                                    <h6>/ {{ count($key->paket_dtl_r) }} Paket</h6>
                                                    <div class="row mt-3">
                                                        @foreach ($key->fitur_r as $keydata)
                                                            <div class="col-md-12 mt-3">
                                                                <div class="row" style="align-items:center">
                                                                    <div class="col-2 col-md-2 pe-0">
                                                                        <img src="{{ asset('image/global/check.png') }}"
                                                                            alt="check">
                                                                    </div>
                                                                    <div class="col-10 col-md-10 ps-0">
                                                                        <span>{{ $keydata->judul }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <button
                                                        class="mt-4 btn btn-md fw-600 btn-block py-3 border-2 rounded-4 text-light" style="background-color: #1d7128" >Lihat
                                                        Paket</button>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endif
                            @empty
                                <center><img class="mb-3 img-no" src="{{ asset('image/global/no-paket.png') }}"
                                        alt=""></center>
                                <br>
                                <center class="text-white">Belum Ada Data</center>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#searchPaket').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('.paket-item').filter(function() {
                    $(this).toggle($(this).attr('data-judul').indexOf(value) > -1)
                });
            });
        });
    </script>
@endsection
