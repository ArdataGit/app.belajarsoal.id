@extends('layouts.SkydashPublic')

@php
    $now = Carbon\Carbon::now()->toDateTimeString();
@endphp

@section('content')
    <style>
        body {
            background: #171A26;
        }

        .navbar {
            background: #2854bc;
            padding: 10px 0;
        }

        .navbar a,
        .navbar .nav-link {
            color: white !important;
        }

        .navbar-brand img {
            height: 40px;
            background: white;
            padding: 5px;
            border-radius: 5px;
        }

        .img-banner {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 15px;
        }

        .carousel-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .slick-prev:before,
        .slick-next:before {
            color: #000 !important;
            font-size: 30px;
        }

        .slick-dots {
            bottom: -30px;
        }

        .promo-banner {
            background-color: #2854bc;
            color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
            text-align: left;
        }

        .promo-banner h3 {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .promo-banner p {
            margin-bottom: 0;
        }

        .subkategori-card {
            background: #2854bc;
            color: white;
            border-radius: 15px;
            overflow: hidden;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
            margin-bottom: 20px;
        }

        .subkategori-card:hover {
            transform: translateY(-5px);
        }

        .subkategori-card img {
            width: 100%;
            /* Agar gambar menyesuaikan lebar kontainer */
            height: 200px;
            /* Ukuran tetap untuk tinggi */
            display: block;
            object-fit: cover;
            /* Memotong gambar agar sesuai ukuran tanpa merubah proporsi */
            border-radius: 10px;
        }


        .subkategori-title {
            font-weight: bold;
            padding: 10px 0;
            background: #153256;
            font-size: 1.1rem;
        }

        .subkategori-button {
            background-color: #1c387a;
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            text-align: center;
            margin: 15px auto;
            display: inline-block;
            font-size: 1rem;
            transition: background 0.3s ease;
            text-decoration: none;

        }

        /* Pastikan container utama tidak melebihi lebar layar */
        .carousel-container {
            width: 100%;
            max-width: 100%;
            overflow: hidden;
        }

        /* Mengatur slide agar tidak keluar dari batas container */
        .slide-home {
            display: flex;
            flex-wrap: nowrap;
            overflow: hidden;
            width: 100%;
        }

        /* Pastikan setiap slide memiliki ukuran penuh */
        .slide-data {
            flex: 0 0 100%;
            text-align: center;
            /* Pusatkan gambar */
        }

        /* Responsif gambar agar sesuai dengan ukuran parent */
        .img-banner {
            width: 100%;
            height: auto;
            max-height: 500px;
            /* Opsional, batasi tinggi gambar */
            object-fit: cover;
        }

        /* Menyesuaikan tampilan untuk layar kecil */
        @media (max-width: 768px) {
            .img-banner {
                max-height: 300px;
                /* Ubah tinggi gambar untuk layar kecil */
            }
        }
    </style>

    <div class="container carousel-container">
        <div class="row">
            <div class="col-md-12">
                <div class="slide-home">
                    <div class="slide-data">
                        <img src="image/global/slideblaj1.png" class="img-banner">
                    </div>
                    <div class="slide-data">
                        <img src="image/global/slideblaj2.png" class="img-banner">
                    </div>
                    <div class="slide-data">
                        <img src="image/global/slideblaj3.png" class="img-banner">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="promo-banner">
                    <h3><strong>Belajar Soal Ujian BUMN, CPNS, dan P3K Tahun 2025</strong></h3>
                    <p class="fs-2"><strong><ul><li>Download modul materi Ujian BUMN, CPNS, PPPK</li><li>Langsung Belajar dari Tryout CBT ribuan soal ujian BUMN, CPNS, P3K</li><li>Akses mudah, Belajar dan Latihan setiap saat dari mana saja</li><li>Setiap hari ditambahkan soal dan pembahasan baru</li></ul><br>Yuk langsung belajar !!</strong></p>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="content-wrapper subkategori-container">
            <div class="row justify-content-center">
                @forelse($subkategori as $key)
                    <a href="{{ url('listpaket') }}/{{ Crypt::encrypt($key->id) }}"
                        class="subkategori-button col-md-4 mb-4">
                        <div class="subkategori-card">
                            <img src="{{ $key->banner ? asset('/' . $key->banner) : asset('image/global/no-paket.png') }}"
                                alt="Paket">
                            <div class="subkategori-title">{{ $key->judul }}</div>
                        </div>
                    </a>
                @empty
                    <center><img class="mb-3 img-no" src="{{ asset('image/global/no-paket.png') }}" alt=""></center>
                    <br>
                    <center text-black>Belum Ada Data</center>
                @endforelse
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
        $(document).ready(function() {
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
    </script>
@endsection
