@extends('layouts.Skydash')

@php
    $now = Carbon\Carbon::now()->toDateTimeString();
@endphp

@section('content')
    <style>
        .img-banner {
            width: 100%;
            height: 20vw;
            object-fit: cover;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }

        .p-relative {
            position: relative;
        }

        .p-absolute {
            position: absolute;
        }

        .txt-white {
            color: white;
        }

        a {
            text-decoration: none;
            color: #7c7c7c;
        }

        a:hover {
            text-decoration: none;
            color: #7c7c7c;
        }

        a .card-body:hover img {
            filter: drop-shadow(2px 4px 6px black);
        }

        @media (max-width: 768px) {
            .img-banner {
                height: 60vw;
            }

            .mt-5-m {
                margin-top: 15vw;
            }
        }

        .card {
            background: linear-gradient(180deg, #1A5085 0%, #06131F 100%);
        }
    </style>

    <div class="content-wrapper">
        <div class="row mb-0">
            <div class="col-md-12">
                <div class="slide-home">
                    <div class="slide-data"><img src="image/global/slideblaj1.png" class="w-100 rounded-3"></div>
                    <div class="slide-data"><img src="image/global/slideblaj2.png" class="w-100 rounded-3"></div>
                    <div class="slide-data"><img src="image/global/slideblaj3.png" class="w-100 rounded-3"></div>
                </div>
                <div class="row mt-3">
                    <div class="col-12 col-lg-3 col-md-3 mb-3 mb-md-0">
                        <a href="{{ url('belipaket') }}">
                            <div class="card">
                                <div class="card-body px-3 py-3">
                                    <div class="row align-items-center">
                                        <div class="col-3 pe-0">
                                            <div class="icon-card bg-blue rounded-circle"><img
                                                    src="{{ asset('image/global/Icon1.png') }}" alt="" width="100%"></div>
                                        </div>
                                        <div class="col-9 ps-3">
                                            <div class="fw-600 text-white">Paket Tersedia</div>
                                            <div class="fs-5 fw-bold text-blue mt-2">{{ $countPaket }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-lg-3 col-md-3 mb-3 mb-md-0">
                        <a href="{{ url('paketsayaktg') }}">
                            <div class="card">
                                <div class="card-body px-3 py-3">
                                    <div class="row align-items-center">
                                        <div class="col-3 pe-0">
                                            <div class="icon-card bg-blue rounded-circle"><img
                                                    src="{{ asset('image/global/Icon2.png') }}" alt="" width="100%"></div>
                                        </div>
                                        <div class="col-9 ps-3">
                                            <div class="fw-600 text-white">Paket Saya</div>
                                            <div class="fs-5 fw-bold text-blue mt-2">{{ count($transaksi) }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-12 col-lg-3 col-md-3 mb-3 mb-md-0">
                        <a href="">
                            <div class="card">
                                <div class="card-body px-3 py-3">
                                    <div class="row align-items-center">
                                        <div class="col-3 pe-0">
                                            <div class="icon-card bg-blue rounded-circle"><i class="ti-file"></i></div>
                                        </div>
                                        <div class="col-9 ps-3">
                                            <div class="fw-600 text-white">Bank Soal</div>
                                            <div class="fs-5 fw-bold text-blue mt-2">1500+</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-lg-3 col-md-3 mb-3 mb-md-0">
                        <a href="">
                            <div class="card">
                                <div class="card-body px-3 py-3">
                                    <div class="row align-items-center">
                                        <div class="col-3 pe-0">
                                            <div class="icon-card bg-blue rounded-circle"><i class="ti-user"></i></div>
                                        </div>
                                        <div class="col-9 ps-3">
                                            <div class="fw-600 text-white">Total Pengguna</div>
                                            <div class="fs-5 fw-bold text-blue mt-2">1000+</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>


                <div class="row mt-4" id="paketContainer">
                    <p class="fs-1 text-white fw-bold mb-4">Paket Terbaru</p>
                    @forelse($paket as $key)
                                    @php
                                        $ceksudahbeli = App\Models\Transaksi::where('fk_paket_mst', $key->id)
                                            ->where('status', 1)
                                            ->where('aktif_sampai', '>=', \Carbon\Carbon::now())
                                            ->where('fk_user_id', Auth::id())
                                            ->first();
                                    @endphp
                                    <div class="col-md-4 stretch-card mb-4 paket-item" data-judul="{{ strtolower($key->judul) }}">
                                        <a href="{{ $ceksudahbeli
                            ? url('paketsayadetail') . '/' . Crypt::encrypt($key->id)
                            : url('paketdetail') . '/' . Crypt::encrypt($key->id) }}" class="hrefpaket d-flex w-100">
                                            <div class="w-100"
                                                style="border: 2px solid white; background-color: black; color: white; padding: 10px; border-radius: 25px;">
                                                <div class="card-body px-7 py-6 w-100">
                                                    <h3 class="fs-5 text-white mb-4"><b>{{ $key->judul }}</b></h3>
                                                    <div class="row" style="align-items:center">
                                                        <div class="col-12">
                                                            <span class="coret me-2 mt-1 text-yellow">{{ formatCoret($key->harga) }}</span>
                                                            <span
                                                                class="btn text-xs btn-sm btn-primary bg-blue py-1 px-2 text-sm me-3">Diskon
                                                                50%</span>
                                                            <div class="fs-3 text-white fw-bold mt-1 mb-4">
                                                                {{ formatRupiah($key->harga) }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <h6>/ {{ count($key->paket_dtl_r) }} Paket</h6>
                                                    <div class="row mt-3">
                                                        @foreach ($key->fitur_r as $keydata)
                                                            <div class="col-md-12 mt-3">
                                                                <div class="row" style="align-items:center">
                                                                    <div class="col-2 col-md-2 pe-0">
                                                                        <img src="{{ asset('image/global/check.png') }}" alt="check">
                                                                    </div>
                                                                    <div class="col-10 col-md-10 ps-0">
                                                                        <span>{{ $keydata->judul }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <button
                                                        class="mt-4 btn btn-md btn-primary fw-600 btn-block py-3 border-2 rounded-3 border-blue text-blue bg-white">Lihat
                                                        Paket</button>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                    @empty
                        <center><img class="mb-3 img-no" src="{{ asset('image/global/no-paket.png') }}" alt="">
                        </center>
                        <br>
                        <center class="text-white">Belum Ada Data</center>
                    @endforelse

                    <!-- Tombol "Lihat Semua Paket" di tengah -->
                    <div class="text-center mt-4">
                        <a href="{{ url('belipaket') }}"
                            class="btn btn-lg btn-primary fw-bold px-5 py-3 border-2 rounded-3 border-white text-white bg-dark">
                            Lihat Semua Paket
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.5.9/slick.min.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.5.9/slick.css" />
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.5.9/slick-theme.css" />
    <script src='https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.6/dist/loadingoverlay.min.js'>
    </script>

    <script>
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })

        $(document).ready(function () {
            $('.slide-home').slick({
                infinite: true,
                slidesToShow: 1,
                dots: true,
                speed: 800,
                autoplay: true,
                autoplaySpeed: 2000,
                easing: 'linear',
                arrows: true,
                fade: false,
                pauseOnHover: true,
                swipe: true,
            });
        });

        $(document).ready(function () {
            $('.my-class').slick({
                infinite: true,
                slidesToShow: 1,
                dots: false,
                speed: 800,
                autoplay: true,
                autoplaySpeed: 2000,
                easing: 'linear',
                arrows: false,
                fade: false,
                pauseOnHover: true,
                swipe: true,
            });
        });
    </script>
@endsection