@extends('layouts.SkydashPublic')
<!-- partial -->
@section('content')
    <style>
        /* Global dark mode */
        body,
        .content-wrapper {
            background-color: #171A26;
            color: #ffffff;
        }

        /* Card styling */
        .card.card-border {
            background-color: #1e1e2d;
            border: 1px solid #2a2a3c;
        }

        .card-body {
            background-color: #1e1e2d;
            color: #ffffff;
        }

        /* Breadcrumb */
        .breadcrumb {
            background-color: transparent;
        }

        .breadcrumb-item a {
            color: #4fc3f7;
        }

        .breadcrumb-item.active {
            color: #ffffff;
        }

        /* Button Tab */
        .btn-tab {
            border: 1px solid transparent !important;
            color: #b0b0b0;
            background-color: #2a2a3c;
        }

        .btn-tab:hover,
        .btn-tab:focus,
        .btn-tab.active {
            color: #ffffff;
            background-color: #4fc3f7;
        }

        /* Badges */
        .badge-danger {
            background-color: #d32f2f;
            color: #ffffff;
        }

        .badge-success {
            background-color: #388e3c;
            color: #ffffff;
        }

        .badge-info {
            background-color: #1976d2;
            color: #ffffff;
        }

        /* Table & Links */
        table.table-borderless {
            color: #ffffff;
        }

        a {
            color: #4fc3f7;
        }

        a:hover {
            color: #81d4fa;
        }

        /* Nav Pills */
        .nav-pills .nav-link.active {
            background-color: #4fc3f7;
            color: #ffffff;
        }

        /* Other Elements */
        .form-check .form-check-label input[type="radio"]+.input-helper:before {
            cursor: unset;
        }

        iframe {
            width: 100% !important;
        }

        /* Container styling untuk "card" skor */
        .px-3.py-5.card-border {
            background-color: #242834;
            border: 1px solid #2a2a3c;
            border-radius: 10px;
        }

        /* Style khusus untuk kolom skor */
        .col-12.col-md-3,
        .col-12.col-sm-3 {
            background-color: #1e1e2d !important;
            border-radius: 10px;
            margin: 0.5% !important;
        }

        /* Style SVG icon jika ingin disesuaikan */
        svg {
            background-color: #2a2a3c;
            border-radius: 50%;
            padding: 10px;
        }
    </style>
    @php
if ($upaketsoalmst->is_kkm) {
    $lulus = true;
    foreach ($upaketsoalmst->u_paket_soal_ktg_r as $key) {
        if ($key->nilai < $key->kkm) {
            $lulus = false;
        }
    }
} else {
    $lulus = $upaketsoalmst->nilai >= $upaketsoalmst->kkm;
}
function check_decimal($number)
{
    $number = number_format($number, 2, ',', ' ');
    if (substr($number, -1) == '0') {
        $number = substr($number, 0, -1);
    }
    if (substr($number, -2) == ',0') {
        $number = substr($number, 0, -2);
    }
    return $number;
}
    @endphp
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card card-border">
                    <div class="card-body">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('home') }}"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item active text-white" aria-current="page">Hasil & Pembahasan</li>
                            </ol>
                        </nav>
                        <p class="card-description">
                        <h3 class="font-weight-bold text-white"><b>Detail Hasil Latihan</b></h3>
                        <div class="row">
                            <div class="col-12 col-md-3 col-lg-3">
                                <table class="table table-borderless text-white">
                                    <thead>
                                        <tr>
                                            <th class="pb-0" style="padding-left:0px">Latihan</th>
                                            <th class="pb-0 text-white">{{ $upaketsoalmst->judul }}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="col-12">
                                <div class="tab-content tab-hasil-ujian">
                                    <div id="statistik" class="tab-pane active"><br>
                                        <div class="text-white" style="overflow: hidden">
                                            <h4>Skor hasil perolehan <span
                                                    class="badge badge-info">{{ $upaketsoalmst->judul }}</span></h4>
                                            @if (!$lulus)
                                                <div class="badge badge-danger rounded-3 w-100 py-3 mt-2">
                                                    <h5 class="mb-0 p-0">Maaf Anda Tidak Lulus</h5>
                                                </div>
                                            @else
                                                <div class="badge badge-success rounded-3 w-100 py-3 mt-2">
                                                    <h5 class="mb-0 p-0">Selamat Anda Lulus</h5>
                                                </div>
                                            @endif
                                            <div class="row mt-3" style="justify-content: center">
                                                <div class="col-12 col-md-3"
                                                    style="margin-left:0.5%;margin-right:0.5%;border-radius:10px">
                                                    <div class="px-3 py-5 card-border"
                                                        style="text-align:center;display:flex;flex-direction:column;justify-content:center">
                                                        @php
$getpoint = App\Models\UPaketSoalDtl::select('max_point')
    ->where('fk_u_paket_soal_mst', $upaketsoalmst->id)
    ->sum('max_point');
                                                        @endphp
                                                        <div style="display:flex;justify-content:center">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                                style="height: 50px;width:50px;color:green;margin-bottom:10px">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
                                                            </svg>
                                                        </div>
                                                        <h6 class="fw-bold mt-3 text-white">Total Skor</h6>
                                                        <div>
                                                            <span
                                                                style="font-size: 36pt;color: #4fc3f7;font-weight: bold;display: block;">
                                                                {{ check_decimal($upaketsoalmst->nilai) }}
                                                            </span>
                                                            @if (!$upaketsoalmst->is_kkm)
                                                                <h6 class="fw-bold mt-3 text-center text-white">KKM
                                                                    {{ $upaketsoalmst->kkm }} </h6>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                @foreach ($upaketsoalmst->u_paket_soal_ktg_r as $key)
                                                    <div class="col-12 col-sm-3 mt-3"
                                                        style="margin-left:0.5%;margin-right:0.5%;border-radius:10px">
                                                        <div class="px-3 py-5 card-border"
                                                            style="text-align:center;display:flex;flex-direction:column;justify-content:center">
                                                            <div style="display:flex;justify-content:center">
                                                                <svg style="height: 50px;width:50px;color:blue;margin-bottom:10px"
                                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5m.75-9 3-3 2.148 2.148A12.061 12.061 0 0 1 16.5 7.605" />
                                                                </svg>
                                                            </div>
                                                            <h6 class="fw-bold mt-3 text-white">{{ $key->judul }}</h6>
                                                            <div>
                                                                <span
                                                                    style="font-size: 26pt;color: #4fc3f7;font-weight: bold;display: block;">
                                                                    @if ($key->bobot)
                                                                        {{ check_decimal((float) ($key->nilai * (float) ($key->bobot / 100.0))) }}
                                                                    @elseif($key->fk_u_paket_soal_kecermatan_mst)
                                                                        {{ $key->point <= 0 ? 0 : check_decimal($key->point) }}
                                                                    @else
                                                                        {{ check_decimal($key->nilai) }}
                                                                    @endif
                                                                </span>
                                                            </div>
                                                            @if ($upaketsoalmst->is_kkm == 1)
                                                                <h6 class="fw-bold mt-3 text-white">KKM {{ $key->kkm }}
                                                                </h6>
                                                                <h6>
                                                                    @if ($key->nilai >= $key->kkm)
                                                                        <span class="badge badge-info">Lulus</span>
                                                                    @else
                                                                        <span class="badge badge-danger">Tidak Lulus</span>
                                                                    @endif
                                                                </h6>
                                                            @elseif($key->bobot)
                                                                <h6 class="fw-bold mt-3 text-white">Nilai Sesi
                                                                    {{ check_decimal($key->nilai) }}</h6>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.6/dist/loadingoverlay.min.js">
    </script>

    <script>
        $(document).ready(function() {
            // Menampilkan SweetAlert otomatis saat halaman dimuat
             let idPaket = @json($idpaket);
            Swal.fire({
                title: "Untuk melihat hasil, upgrade dulu",
                text: "Hanya dengan Rp. {{ $paketmst->harga }} KAMU BISA AKSES RIBUAN SOAL DAN PEMBAHASANNYA",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Daftar",
                cancelButtonText: "Kembali"
            }).then((result) => {
                if (result.isConfirmed) {
                      window.location.href = "{{ url('checkout') }}/" + idPaket; // Redirect ke halaman checkout
                } else {
                    window.location.href = "{{ url('/') }}"; // Redirect ke halaman utama
                }
            });

            // Menonaktifkan klik kanan
            $(document).bind("contextmenu", function(e) {
                return false;
            });

            // Menonaktifkan copy-paste
            $('body').on("cut copy paste", function(e) {
                e.preventDefault();
            });

            // Navigasi soal
            $(document).on('click', '.list-nomor .nav-link', function(e) {
                $('.nav-link').removeClass('active');
                $(this).addClass('active');
            });

            $(document).on('click', '.btn-next-back', function(e) {
                let idsoal = $(this).attr('idsoal');
                $('.tab-pane-soal').removeClass('show active');
                $('.nav-link-soal').removeClass('active');
                $('#pills-' + idsoal).addClass('show active');
                $('#btn_no_soal_' + idsoal).addClass('active');
            });
        });
    </script>
@endsection
