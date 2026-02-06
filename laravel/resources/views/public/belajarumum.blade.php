@extends('layouts.SkydashPublic')
@php
    $now = Carbon\Carbon::now()->toDateTimeString();
@endphp

@section('header')
    <script>
        window.MathJax = {
            tex: {
                inlineMath: [
                    ["\\(", "\\)"],
                    ["$", "$"]
                ],
                displayMath: [
                    ["\\[", "\\]"],
                    ["$$", "$$"]
                ],
                processEscapes: true
            },
            svg: {
                fontCache: "global"
            }
        };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-chtml.js"></script>
@endsection

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
            background-color: #1e2538;
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

        /* Pilihan Jawaban: Gabungkan radio dan teks dalam satu label */
        .form-check {}

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
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
        }

        .btn-next-back {
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
        }

        /* Tombol Lihat Pembahasan */
        .btn-pembahasan {
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
            background-color: #ffc107;
            border: none;
            border-radius: 5px;
            color: #000;
            margin: 10px auto;
            display: block;
        }

        /* Pembahasan Container (hidden secara default) */
        .pembahasan-container {
            display: none;
            margin-top: 10px;
            padding: 10px;
            border: 1px solid #444;
            border-radius: 5px;
        }

        /* Timer dan Sesi */
        .div-waktu {
            background-color: #1d6c2b;
            color: #fff;
            padding: 1rem;
            border-radius: 8px;
            text-align: center;
        }

        .f-waktu {
            font-size: 1.5rem;
            font-weight: bold;
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
                        <h3 class="font-weight-bold text-white"><b>{{ $upaketsoalmst->judul }} (Mode Belajar)</b>
                        </h3>
                        </p>
                        <div class="row mt-3">
                            <div class="col-xl-9 col-md-9 col-sm-9 col-xs-9">
                                <div class="_soal_content tab-content card card-border mb-3" id="pills-tabContent">
                                    @foreach($upaketsoalmst->u_paket_soal_dtl_r as $key)
                                        <div class="tab-pane fade {{$key->no_soal == 1 ? 'show active' : ''}}"
                                            id="pills-{{ $key->id }}" role="tabpanel" style="font-size: 1rem important;">
                                            <div class="mb-3 p-3 card-border" style="border-radius: 10px;">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <h4 class="mb-0 mt-2"><b>Soal No.{{ $key->no_soal }}</b></h4>
                                                    </div>
                                                    <div class="col-6">
                                                        <!-- Info tambahan jika diperlukan -->
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="_soal">{!! $key->soal !!}</div>
                                                <div class="form-group">
                                                    <!-- Opsi A -->
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input _radio"
                                                                idpaketdtl="{{ $key->id }}" name="radio_{{ $key->id }}"
                                                                value="a" {{ $key->jawaban_user == 'a' ? 'checked' : '' }}>
                                                            <span class="option-label"><b>a.</b></span>
                                                            <span class="option-text">{!! $key->a !!}</span>
                                                        </label>
                                                    </div>
                                                    <!-- Opsi B -->
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input _radio"
                                                                idpaketdtl="{{ $key->id }}" name="radio_{{ $key->id }}"
                                                                value="b" {{ $key->jawaban_user == 'b' ? 'checked' : '' }}>
                                                            <span class="option-label"><b>b.</b></span>
                                                            <span class="option-text">{!! $key->b !!}</span>
                                                        </label>
                                                    </div>
                                                    @if ($key->c)
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input type="radio" class="form-check-input _radio"
                                                                    idpaketdtl="{{ $key->id }}" name="radio_{{ $key->id }}"
                                                                    value="c" {{ $key->jawaban_user == 'c' ? 'checked' : '' }}>
                                                                <span class="option-label"><b>c.</b></span>
                                                                <span class="option-text">{!! $key->c !!}</span>
                                                            </label>
                                                        </div>
                                                    @endif

                                                    @if ($key->d)
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input type="radio" class="form-check-input _radio"
                                                                    idpaketdtl="{{ $key->id }}" name="radio_{{ $key->id }}"
                                                                    value="d" {{ $key->jawaban_user == 'd' ? 'checked' : '' }}>
                                                                <span class="option-label"><b>d.</b></span>
                                                                <span class="option-text">{!! $key->d !!}</span>
                                                            </label>
                                                        </div>
                                                    @endif

                                                    @if ($key->e)
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input type="radio" class="form-check-input _radio"
                                                                    idpaketdtl="{{ $key->id }}" name="radio_{{ $key->id }}"
                                                                    value="e" {{ $key->jawaban_user == 'e' ? 'checked' : '' }}>
                                                                <span class="option-label"><b>e.</b></span>
                                                                <span class="option-text">{!! $key->e !!}</span>
                                                            </label>
                                                        </div>
                                                    @endif

                                                    @if ($key->f)
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input type="radio" class="form-check-input _radio"
                                                                    idpaketdtl="{{ $key->id }}" name="radio_{{ $key->id }}"
                                                                    value="f" {{ $key->jawaban_user == 'f' ? 'checked' : '' }}>
                                                                <span class="option-label"><b>f.</b></span>
                                                                <span class="option-text">{!! $key->f !!}</span>
                                                            </label>
                                                        </div>
                                                    @endif

                                                    @if ($key->g)
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input type="radio" class="form-check-input _radio"
                                                                    idpaketdtl="{{ $key->id }}" name="radio_{{ $key->id }}"
                                                                    value="g" {{ $key->jawaban_user == 'g' ? 'checked' : '' }}>
                                                                <span class="option-label"><b>g.</b></span>
                                                                <span class="option-text">{!! $key->g !!}</span>
                                                            </label>
                                                        </div>
                                                    @endif

                                                    @if ($key->h)
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input type="radio" class="form-check-input _radio"
                                                                    idpaketdtl="{{ $key->id }}" name="radio_{{ $key->id }}"
                                                                    value="h" {{ $key->jawaban_user == 'h' ? 'checked' : '' }}>
                                                                <span class="option-label"><b>h.</b></span>
                                                                <span class="option-text">{!! $key->h !!}</span>
                                                            </label>
                                                        </div>
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="pembahasan-container mt-3"
                                                style="display:none; border: 1px solid #444; border-radius: 5px; padding: 10px;">

                                                <!-- ALERT BENAR/SALAH (jika Anda memerlukan) -->
                                                <div class="alert-jawaban"></div>

                                                <!-- PEMBAHASAN AKAN DI-UPDATE OLEH AJAX -->
                                                <div class="jawaban-benar-container"></div>
                                                <div class="pembahasan-container">
                                                    <div class="isi-pembahasan"></div>
                                                </div>
                                            </div>


                                            <!-- Navigation Buttons -->
                                            <div class="question-footer">
                                                <span>
                                                    @if (!$loop->first)
                                                        <button idsoal="{{ $key->id - 1 }}" type="button"
                                                            class="btn-next-back btn btn-sm btn-primary btn-rounded btn-fw"
                                                            style="border-radius:20px">
                                                            <i class="ti-back-left btn-icon-prepend"></i>
                                                            Sebelumnya
                                                        </button>
                                                    @endif

                                                </span>
                                                <div>
                                                    <button type="button"
                                                        class="btn btn-success btn-sm btn-rounded btn-pembahasan-toggle"
                                                        style="margin: 0 10px;">
                                                        <i class="fas fa-book-open"></i> Lihat Pembahasan
                                                    </button>
                                                </div>
                                                <span>
                                                    @if (!$loop->last)
                                                        <button idsoal="{{ $key->id + 1 }}" type="button"
                                                            class="btn-next-back btn btn-sm btn-primary btn-rounded btn-fw mr-3"
                                                            style="border-radius:20px" @if ($loop->iteration  == $gratis_belajar)
                                                            data-limit="true" @endif>
                                                            Selanjutnya
                                                            <i class="ti-back-right btn-icon-prepend"></i>
                                                        </button>
                                                    @endif

                                                </span>
                                            </div>
                                            <!-- Tombol Lihat Pembahasan -->
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-3 col-sm-3 col-xs-3">
                                <div class="card card-border w-100 mb-4">
                                    <div class="card-body">
                                        <div class="mb-4 card-border" style="border-radius: 8px;">
                                            <center class="mb-1">Sudah Selesai?</center>

                                            <center>
                                                <button type="button" class="btn-block btn btn-primary btn-sm"
                                                    id="btn-submit-ujian"
                                                    upaketsoalmst="{{ Crypt::encrypt($upaketsoalmst->id) }}">
                                                    <h6 class="mb-0">Selesaikan Belajar</h6>
                                                </button>
                                            </center>

                                        </div>
                                    </div>
                                </div>
                                <div class="card-border p-3" style="border-radius: 8px;">
                                    <center class="mb-3">Nomor Soal</center>
                                    <ul class="_soal nav nav-pills mb-0" id="pills-tab" role="tablist">
                                        @foreach ($upaketsoalmst->u_paket_soal_dtl_r as $key)

                                            <li class="nav-item" role="presentation">
                                                <button id="btn_no_soal_{{ $key->id }}"
                                                    class="btn-sm {{ $key->jawaban_user ? '_ada_isi' : '' }} nav-link {{ $key->no_soal == 1 ? 'active' : '' }}"
                                                    type="button" role="     aria-selected=" true">{{ $key->no_soal }}</button>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
            var gratisLimit = {{ $gratis_belajar }};

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

            // Tombol Lihat Pembahasan: Toggle tampilan container pembahasan
            $(document).on('click', '.btn-pembahasan-toggle', function (e) {
                // Toggle div pembahasan di dalam tab-pane saat ini
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
                    url: "{{ url('updatejawabanpublic') }}", // Pastikan route ini benar
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
                        $.LoadingOverlay("hide");

                        if (response.status) {
                            if (response.data) {
                                var isCorrect = response.data.isCorrect;
                                var jawabanBenar = (response.data.jawabanBenar || '')
                                    .toUpperCase();
                                var htmlJawabanBenar = response.data.htmlJawabanBenar || '';
                                var pembahasan = response.data.pembahasan || '';
                            }

                            var $tabPane = $('#pills-' + idpaketdl);
                            var $alertJawaban = $tabPane.find('.alert-jawaban');
                            var $pembahasanDiv = $tabPane.find(
                                '.pembahasan-container .isi-pembahasan');
                            var $jawabanBenarContainer = $tabPane.find(
                                '.jawaban-benar-container');

                            if (isCorrect) {
                                $alertJawaban
                                    .removeClass('alert-danger')
                                    .addClass('alert alert-success')
                                    .html(
                                        `<i class="fas fa-check-circle"></i> <strong>Jawaban Anda Benar!</strong>`
                                    );

                                $jawabanBenarContainer.html(''); // Kosongkan jika jawaban benar
                            } else {
                                $alertJawaban
                                    .removeClass('alert-success')
                                    .addClass('alert alert-danger')
                                    .html(
                                        `<i class="fas fa-times-circle"></i> <strong>JAWABAN ANDA SALAH!</strong>`
                                    );

                                // Tampilkan jawaban yang benar di luar box merah
                                $jawabanBenarContainer.html(`
                                                                                    <strong>Jawaban yang benar:</strong> ${jawabanBenar}
                                                                                    <div>${htmlJawabanBenar}</div>
                                                                                `);
                            }

                            // Isi pembahasan dengan judul "PEMBAHASAN"
                            if ($pembahasanDiv.length > 0) {
                                $pembahasanDiv.html(`
                                                                                    <h5 class="mt-3"><strong>PEMBAHASAN</strong></h5>
                                                                                    ${pembahasan}
                                                                                `);
                            }

                            if (window.MathJax && window.MathJax.typesetPromise) {
                                MathJax.typesetPromise([$tabPane[0]]).catch(function (err) {
                                    console.log("MathJax error:", err.message);
                                });
                            }

                            $('#btn_no_soal_' + idpaketdl).addClass('_ada_isi');

                        } else {
                            Swal.fire({
                                html: response.message,
                                icon: 'error',
                                confirmButtonText: 'Ok'
                            });
                        }
                    },
                    error: function (xhr, status) {
                        $.LoadingOverlay("hide");
                        alert('Terjadi kesalahan, silakan coba lagi.');
                    }
                });
            });

            // Tombol Submit Ujian: Munculkan SweetAlert untuk mengarahkan ke pendaftaran
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
        });
    </script>
@endsection
