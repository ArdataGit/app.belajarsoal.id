@extends('layouts.SkydashPublic')
@php
    $now = Carbon\Carbon::now()->toDateTimeString();
@endphp

@section('content')
    <style>
        /* Global Styles */
        body {
            background-color: #171A26;
            font-family: 'Roboto', sans-serif;
            color: #fff;
        }

        .content-wrapper {
            padding: 2rem;
        }

        /* Breadcrumb */
        .breadcrumb {
            background: transparent;
            padding: 0;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .breadcrumb-item a {
            color: #1d6c2b;
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: #aaa;
        }

        /* Card Container */
        .cardx {
            background-color: #171A26;
            border: 1px solid #333;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .card-bodyx {
            padding: 1.5rem;
        }

        /* Headings */
        h3.font-weight-bold {
            font-size: 1.75rem;
            margin-bottom: 1rem;
            color: #fff;
        }

        h4.ktg-soal {
            font-size: 1.25rem;
            margin-bottom: 1rem;
            color: #32cd32;
        }

        .h6 {
            font-size: 0.95rem;
            color: #fff;
        }

        .sesuai {
            color: #FEA31B;
            font-weight: bold;
        }

        .selesai {
            color: #28a745;
            font-weight: bold;
        }

        /* Kartu Soal (Dark Mode) */
        ._soal_content {
            background-color: #171A26;
            border: 1px solid #333;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            color: #fff;
        }

        ._soal {
            font-size: 17.6px !important;
            line-height: 1.6;
            margin-bottom: 1rem;
            color: #fff;
        }

        /* Pilihan Jawaban: Gabungkan radio button dan teks dalam satu label */
        .form-check {
            flex: 1;
        }

        .form-check-label {
            display: flex;
            align-items: unset;
            cursor: pointer;
            font-size: 1rem;
            color: #fff;
        }

        .form-check-input {
            margin: 0;
            vertical-align: middle;
            margin-right: 10px;
        }

        .option-label {
            margin-right: 10px;
            font-weight: bold;
            color: #fff;
            text-transform: uppercase;
        }

        .option-text {
            flex: 1;
        }

        /* Navigasi Soal (Next/Back) */
        .question-footer {
            padding-bottom: 30px;
            display: flex;
            justify-content: space-between;
        }

        .btn-next-back {
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
        }

        /* Timer dan Sesi */
        .div-waktu {
            background-color: #1E2538;
            color: #fff;
            padding: 1rem;
            border-radius: 8px;
            text-align: center;
        }

        .f-waktu {
            font-size: 1.5rem;
            font-weight: bold;
            color: #ff831f;
        }

        .card.card-border {
            background-color: #1e2538;
            border: 1px solid #333;
            border-radius: 8px;
        }

        /* Nomor Soal Navigation */
        ul._soal.nav.nav-pills {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 0;
            margin: 1rem 0;
            list-style: none;
        }

        ul._soal.nav.nav-pills li {
            margin: 0.25rem;
        }

        ul._soal.nav.nav-pills li button {
            border-radius: 50%;
            width: 36px;
            height: 36px;
            padding: 0;
            font-size: 0.9rem;
            background-color: #e9ecef;
            border: 1px solid #ccc;
            color: #333;
        }

        ul._soal.nav.nav-pills li button.active,
        ul._soal.nav.nav-pills li button._ada_isi {
            background-color: #1d6c2b;
            color: #fff;
        }

        /* SweetAlert custom styling */
        .swal2-popup {
            font-size: 1rem;
            background: #1e2538;
            color: #fff;
        }

        .swal2-title {
            color: #1d6c2b;
        }

        .swal2-confirm {
            background-color: #1d6c2b;
            border: none;
        }

        .swal2-cancel {
            background-color: #6c757d;
            border: none;
        }

        .btn-primary {
            background-color: #1d6c2b;
        }
    </style>

    <div class="">
        <!-- Tampilan Soal -->
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="cardx card-border w-100">
                    <div class="card-bodyx">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('home') }}"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page">Paket Saya</li>
                                <li class="breadcrumb-item active" aria-current="page">Kerjakan Latihan
                                    {{ $upaketsoalmst->judul }}
                                </li>
                            </ol>
                        </nav>
                        <p class="card-description">
                        <h3 class="font-weight-bold text-white"><b>{{ $upaketsoalmst->judul }}</b></h3>
                        </p>
                        <div class="row">
                            <div class="col-xl-9 col-md-8 col-sm-12 col-xs-12">
                                <div class="_soal_content tab-content card card-border mb-3 " id="pills-tabContent">
                                    @php
                                        $no = 1;
                                        $dataloop = $upaketsoalmst->u_paket_soal_ktg_aktif_r;
                                        $selesai = $dataloop[0]->selesai;
                                        $idupaketsoalktg = $dataloop[0]->id;
                                        $judulsesi = 'Sesi';
                                    @endphp

                                    @foreach ($dataloop as $datakategori)
                                        @foreach ($datakategori->u_paket_soal_dtl_r as $key)
                                            <div class="tab-pane fade {{ $no == 1 ? 'show active' : '' }}" id="pills-{{ $key->id }}"
                                                role="tabpanel">
                                                <div class="mb-3 p-3 card-border" style="border-radius: 10px;">
                                                    <h4 class="ktg-soal">{{ $judulsesi }} {{ $datakategori->judul }}</h4>
                                                    <div class="row">
                                                        <div class="col-12 col-md-6">
                                                            <h4 class="mb-0 mt-2"><b>Soal No.{{ $key->no_soal }}</b></h4>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="_soal">{!! $key->soal !!}</div>
                                                    <div class="form-group">
                                                        @foreach (['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'] as $option)
                                                            @if ($key->$option)
                                                                <div class="form-check">
                                                                    <label class="form-check-label">
                                                                        <input type="radio" class="form-check-input _radio"
                                                                            idpaketdtl="{{ $key->id }}" name="radio_{{ $key->id }}"
                                                                            value="{{ $option }}" {{ $key->jawaban_user == $option ? 'checked' : '' }}>
                                                                        <span class="option-label"><b>{{ $option }}.</b></span>
                                                                        <span class="option-text">{!! $key->$option !!}</span>
                                                                    </label>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="question-footer d-flex justify-content-between">
                                                    <span>
                                                        @if ($loop->parent->first && $loop->first)
                                                            <!-- Tombol sebelumnya tidak muncul pada soal pertama -->
                                                        @else
                                                            <button idsoal="{{ $key->id - 1 }}" type="button"
                                                                class="btn-next-back btn btn-sm btn-primary btn-rounded btn-fw"
                                                                style="border-radius:20px">
                                                                <i class="ti-back-left btn-icon-prepend"></i>
                                                                Sebelumnya
                                                            </button>
                                                        @endif
                                                    </span>
                                                    <span>
                                                        @if ($loop->parent->last && $loop->last)
                                                            <!-- Tombol selanjutnya tidak muncul pada soal terakhir -->
                                                        @else
                                                            <button idsoal="{{ $key->id + 1 }}" type="button"
                                                                class="btn-next-back btn btn-sm btn-primary btn-rounded btn-fw mr-3"
                                                                style="border-radius:20px" @if ($no == $gratis_ujian) data-limit="true"
                                                                @endif>
                                                                Selanjutnya
                                                                <i class="ti-back-right btn-icon-prepend"></i>
                                                            </button>
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                            @php $no++; @endphp
                                        @endforeach
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-4 col-sm-12 col-xs-12">
                                <div class="card card-border w-100 mb-4">
                                    <div class="card-body">
                                        <div class="mb-4 card-border div-waktu">
                                            <div id="end">
                                                <h6 class="fw-600 text-center mb-3">Waktu Tersisa</h6>
                                                <span class="f-waktu" id="hours"></span><br />
                                                <span class="f-waktu" id="mins"></span>
                                                <span class="f-waktu" id="secs"></span>
                                            </div>
                                        </div>
                                        <div class="mb-4 card-border" style="border-radius: 8px;">
                                            <center class="mb-1">Sudah Selesai?</center>
                                            @if (count($upaketsoalmst->u_paket_soal_ktg_nonaktif_r) > 0)
                                                <center>
                                                    <button type="button" class="btn-block btn btn-primary btn-sm"
                                                        style="border-radius:15px" id="btn-lanjut-sesi"
                                                        upaketsoalmst="{{ Crypt::encrypt($upaketsoalmst->id) }}"
                                                        upaketsoalktg="{{ Crypt::encrypt($idupaketsoalktg) }}">
                                                        <p class="mb-0">Lanjut Sesi</p>
                                                    </button>
                                                </center>
                                            @else
                                                <center>
                                                    <button type="button" class="btn-block btn btn-primary btn-sm"
                                                        id="btn-submit-ujian"
                                                        upaketsoalmst="{{ Crypt::encrypt($upaketsoalmst->id) }}">
                                                        <h6 class="mb-0">Selesaikan Ujian</h6>
                                                    </button>
                                                </center>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card-border p-3" style="border-radius: 8px;">
                                    <center class="mb-2">{{ $judulsesi }}</center>
                                    <div>
                                        @foreach ($upaketsoalmst->u_paket_soal_ktg_r as $keyktg)
                                            <h6
                                                class="{{ $keyktg->id == $idupaketsoalktg ? 'sesuai' : 'text-white' }} {{ $keyktg->is_mengerjakan == 2 ? 'selesai' : '' }}">
                                                {{ $keyktg->judul }}
                                                @if ($keyktg->is_mengerjakan == 2)
                                                    <i class="fas fa-check"></i>
                                                @endif
                                            </h6>
                                        @endforeach
                                    </div>
                                    <br>
                                    <center class="mb-3">Nomor Soal</center>
                                    <ul class="_soal nav nav-pills mb-0" id="pills-tab" role="tablist">
                                        @php $no = 1; @endphp
                                        @foreach ($dataloop as $datakategori)
                                            @foreach ($datakategori->u_paket_soal_dtl_r as $key)
                                                <li class="nav-item" role="presentation">
                                                    <button id="btn_no_soal_{{ $key->id }}"
                                                        class="btn-sm {{ $key->jawaban_user ? '_ada_isi' : '' }} nav-link {{ $no == 1 ? 'active' : '' }}"
                                                        type="button" role="tab" aria-selected="true">{{ $key->no_soal }}</button>
                                                </li>
                                                @php $no++; @endphp
                                            @endforeach
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <style>
                            @media (max-width: 576px) {
                                .ktg-soal {
                                    font-size: 1.8rem;
                                    /* Ukuran font lebih besar di mobile */
                                }

                                ._soal {
                                    font-size: 1.4rem;
                                    /* Ukuran font lebih besar di mobile */
                                }

                                .form-check-label {
                                    font-size: 1.1rem;
                                    /* Ukuran font untuk opsi */
                                }

                                .btn-next-back {
                                    font-size: 1rem;
                                    /* Ukuran font tombol */
                                    padding: 10px 15px;
                                    /* Padding tombol */
                                }

                                .card-border {
                                    padding: 0px;
                                    /* Padding untuk card */
                                }
                            }
                        </style>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <!-- jQuery, SweetAlert2, dan LoadingOverlay -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.6/dist/loadingoverlay.min.js">
    </script>

    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        $(document).ready(function () {
            var gratisLimit = {{ $gratis_ujian }};
            let idPaket = @json($idpaket);
            // Mencegah klik kanan dan cut-copy-paste
            $(document).bind("contextmenu", function (e) {
                return false;
            });
            $('body').on("cut copy paste", function (e) {
                e.preventDefault();
            });

            // Navigasi soal Next/Back
            $(document).on('click', '.btn-next-back', function (e) {
                var idsoal = $(this).attr('idsoal');
                var isLimit = $(this).data('limit');

                if (isLimit) {
                    Swal.fire({
                        title: "AYO UPGRADE !",
                        text: "Hanya dengan Rp. {{ $paketmst->harga }} KAMU BISA AKSES RIBUAN SOAL DAN PEMBAHASANNYA",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Upgrade/Login",
                        cancelButtonText: "Kembali"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "{{ url('checkout') }}/" + idPaket;
                        }
                    });
                    return false; // Hentikan navigasi
                } else {
                    // Lanjutkan navigasi ke soal berikutnya
                    $('.tab-pane').removeClass('show active');
                    $('.nav-link').removeClass('active');
                    $('#pills-' + idsoal).addClass('show active');
                    $('#btn_no_soal_' + idsoal).addClass('active');

                    $('html, body').animate({
                        scrollTop: 0
                    }, 'slow');
                }
            });

            // Tombol Lihat Pembahasan: Toggle pembahasan
            $(document).on('click', '.btn-pembahasan-toggle', function (e) {
                $(this).closest('.tab-pane').find('.pembahasan-container').slideToggle();
            });

            // Batas gratis jawaban

            function checkUpgradeModal() {
                var count = $('input._radio:checked').length;
                return (count > gratisLimit);
            }

            // Saat ada perubahan pada pilihan jawaban
            $(document).on('change', '._radio', function (e) {
                if (checkUpgradeModal()) {
                    $(this).prop('checked', false);
                    Swal.fire({
                        title: "AYO UPGRADE !",
                        text: "Hanya dengan Rp. {{ $paketmst->harga }} KAMU BISA AKSES RIBUAN SOAL DAN PEMBAHASANNYA",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Upgrade/Login",
                        cancelButtonText: "Kembali"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "{{ url('checkout') }}/" + idPaket;
                        }
                    });
                    return false;
                }
                var jawaban = $(this).val();
                var idpaketdl = $(this).attr('idpaketdtl');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: "{{ url('updatejawabanpublic') }}",
                    data: {
                        jawaban: jawaban,
                        idpaketdl: idpaketdl
                    },
                    beforeSend: function () {
                        $.LoadingOverlay("show", {
                            image: "{{ asset('/image/global/loading.gif') }}"
                        });
                    },
                    success: function (response) {
                        if (response.status) {
                            $('#btn_no_soal_' + idpaketdl).addClass('_ada_isi');
                            if (checkUpgradeModal()) {
                                Swal.fire({
                                    title: "AYO UPGRADE !",
                                    text: "Hanya dengan Rp. {{ $paketmst->harga }} KAMU BISA AKSES RIBUAN SOAL DAN PEMBAHASANNYA",
                                    icon: "warning",
                                    showCancelButton: true,
                                    confirmButtonText: "Upgrade/Login",
                                    cancelButtonText: "Kembali"
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "{{ url('checkout') }}/" + idPaket;
                                    }
                                });
                            }
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

            // Tombol Submit Ujian: Munculkan SweetAlert untuk mendorong pendaftaran
            $(document).on('click', '#btn-submit-ujian', function (e) {
                Swal.fire({
                    title: "Submit Jawaban Sekarang?",
                    text: "Jawaban yang telah disubmit tidak dapat diubah!",
                    icon: "info",
                    showCancelButton: true,
                    confirmButtonText: "Submit",
                    cancelButtonText: "Kembali"
                }).then((result) => {
                    if (result.isConfirmed) {
                        var idpaketmst = $(this).attr('upaketsoalmst');
                        var idupaketsoalktg = $(this).attr('upaketsoalktg');
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            type: "POST",
                            dataType: "JSON",
                            url: "{{ url('selesaiujianpublic') }}",
                            data: {
                                idpaketmst: idpaketmst,
                                idupaketsoalktg: idupaketsoalktg
                            },
                            beforeSend: function () {
                                $.LoadingOverlay("show", {
                                    image: "{{ asset('/image/global/loading.gif') }}"
                                });
                            },
                            success: function (response) {
                                if (response.status) {
                                    Swal.fire({
                                        title: "Sesi Selesai!",
                                        text: "Halaman akan diarahakan ke halaman selanjutnya...",
                                        icon: "success",
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                    reload_url(0, response.menu);
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
                    }
                });
            });
            // Tombol Lanjut Sesi
            $(document).on('click', '#btn-lanjut-sesi', function (e) {
                Swal.fire({
                    title: "Lanjutkan Sesi?",
                    text: "Jawaban yang telah diselesaikan tidak dapat diubah!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Lanjut Sesi",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        var idpaketmst = $(this).attr('upaketsoalmst');
                        var idupaketsoalktg = $(this).attr('upaketsoalktg');
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            type: "POST",
                            dataType: "JSON",
                            url: "{{ url('lanjutsesipublic') }}",
                            data: {
                                idpaketmst: idpaketmst,
                                idupaketsoalktg: idupaketsoalktg
                            },
                            beforeSend: function () {
                                $.LoadingOverlay("show", {
                                    image: "{{ asset('/image/global/loading.gif') }}"
                                });
                            },
                            success: function (response) {
                                if (response.status) {
                                    Swal.fire({
                                        title: "Sesi Selesai!",
                                        text: "Halaman akan diarahakan ke sesi selanjutnya...",
                                        icon: "success",
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                    reload(1500);
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
                    }
                });
            });

            // Countdown Timer
            var countDownDate = new Date("{{ $selesai }}").getTime();
            var i = 0;
            var myfunc = setInterval(function () {
                const now = new Date('{{ $now }}');
                now.setSeconds(now.getSeconds() + i);
                i++;
                var timeleft = countDownDate - now;
                var hours = Math.floor((timeleft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((timeleft % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((timeleft % (1000 * 60)) / 1000);
                document.getElementById("hours").innerHTML = hours + " Jam ";
                document.getElementById("mins").innerHTML = minutes + " Menit ";
                document.getElementById("secs").innerHTML = seconds + " Detik";
                if (timeleft <= 0) {
                    clearInterval(myfunc);
                    if ("{{ count($upaketsoalmst->u_paket_soal_ktg_nonaktif_r) }}" > 0) {
                        document.getElementById("end").innerHTML = "SESI SELESAI!!";
                        var idpaketmst = $('#btn-lanjut-sesi').attr('upaketsoalmst');
                        var idupaketsoalktg = $('#btn-lanjut-sesi').attr('upaketsoalktg');
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            type: "POST",
                            dataType: "JSON",
                            url: "{{ url('lanjutsesipublic') }}",
                            data: {
                                idpaketmst: idpaketmst,
                                idupaketsoalktg: idupaketsoalktg
                            },
                            beforeSend: function () {
                                $.LoadingOverlay("show", {
                                    image: "{{ asset('/image/global/loading.gif') }}"
                                });
                            },
                            success: function (response) {
                                if (response.status) {
                                    $('.modal').modal('hide');
                                    reload(0);
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
                    } else {
                        document.getElementById("end").innerHTML = "UJIAN SELESAI!!";
                        idpaketmst = $('#btn-submit-ujian').attr('upaketsoalmst');
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            type: "POST",
                            dataType: "JSON",
                            url: "{{ url('selesaiujianpublic') }}",
                            // async: false,
                            data: {
                                idpaketmst: idpaketmst
                            },
                            beforeSend: function () {
                                $.LoadingOverlay("show", {
                                    image: "{{ asset('/image/global/loading.gif') }}"
                                });
                            },
                            success: function (response) {
                                if (response.status) {
                                    Swal.fire({
                                        title: "UJIAN SELESAI!",
                                        text: response.message,
                                        icon: "success",
                                        confirmButtonText: "OK"
                                    }).then(() => {
                                        reload_url(1500, response.menu);
                                    });
                                } else {
                                    Swal.fire({
                                        html: response.message,
                                        icon: "error",
                                        confirmButtonText: "Ok"
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
                }
            }, 1000);
            // END COUNTDOWN
        });
    </script>
@endsection
