@extends('layouts.Skydash')
<!-- partial -->
@section('content')
    <style>
        * {
            font-size: 16px !important;
            font-family: 'Roboto', sans-serif;
        }

        .h6 {
            color: #fff;
        }

        ._soal {
            font-size: 17.6px !important;
            line-height: 1.6;
            margin-bottom: 1rem;
            color: #fff;
        }

        .sesuai {
            color: #FEA31B;
        }

        .selesai {
            color: white;
        }

        h4.ktg-soal {
            font-size: 1.25rem !important;
            margin-bottom: 1rem;
            color: #32cd32;
            text-align: left;
            font-style: normal;
        }
    </style>

    <div class="content-wrapper">

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="cardx card-border w-100">
                    <div class="card-bodyx">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('home') }}"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item active text-white" aria-current="page">Paket Saya</li>
                                <li class="breadcrumb-item active text-white" aria-current="page">Kerjakan Latihan
                                    {{ $upaketsoalmst->judul }}
                                </li>
                            </ol>
                        </nav>
                        <p class="card-description">
                        <h3 class="font-weight-bold text-white"><b>{{ $upaketsoalmst->judul }}</b></h3>
                        </p>
                        <div class="row mt-3">
                            <div class="col-xl-9 col-md-9 col-sm-9 col-xs-9 fs-2 text-white">
                                <div class="_soal_content tab-content card card-border mb-3 text-xl" id="pills-tabContent"
                                    style="background-color:#1E2538; text-align:left; font-size:16px !important;  font-family: 'Roboto', sans-serif;">
                                    @foreach($upaketsoalmst->u_paket_soal_dtl_r as $key)
                                        <div class="tab-pane fade {{$key->no_soal == 1 ? 'show active' : ''}}" id="pills-{{ $key->id }}"
                                            role="tabpanel" style="font-size: 1rem important;">
                                            <!-- <h6><b>[{{ $key->nama_tingkat }}]</b></h6> -->
                                            <div class="mb-3 p-3 card-border" style="border-radius: 10px; font-size:16px;">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <h4 class="mb-0 mt-2 text-white"><b>Soal
                                                                No.{{ $key->no_soal }}</b></h4>
                                                    </div>
                                                    <div class="col-6">
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="_soal">{!! $key->soal !!}
                                                </div>

                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input _radio"
                                                                idpaketdtl="{{ $key->id }}" name="radio_{{ $key->id }}"
                                                                value="a" {{ $key->jawaban_user == 'a' ? "checked='checked'" : '' }}>
                                                            <i class="input-helper"></i></label>
                                                        <div class="_pilihan">
                                                            <span><b>a.</b> </span>
                                                            <div class="_pilihan_isi">
                                                                {!! $key->a !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input _radio"
                                                                idpaketdtl="{{ $key->id }}" name="radio_{{ $key->id }}"
                                                                value="b" {{ $key->jawaban_user == 'b' ? 'checked' : '' }}>
                                                            <i class="input-helper"></i></label>
                                                        <div class="_pilihan">
                                                            <span><b>b.</b> </span>
                                                            <div class="_pilihan_isi">
                                                                {!! $key->b !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if ($key->c)
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input type="radio" class="form-check-input _radio"
                                                                    idpaketdtl="{{ $key->id }}" name="radio_{{ $key->id }}"
                                                                    value="c" {{ $key->jawaban_user == 'c' ? 'checked' : '' }}>
                                                                <i class="input-helper"></i></label>
                                                            <div class="_pilihan">
                                                                <span><b>c.</b> </span>
                                                                <div class="_pilihan_isi">
                                                                    {!! $key->c !!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if ($key->d)
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input type="radio" class="form-check-input _radio"
                                                                    idpaketdtl="{{ $key->id }}" name="radio_{{ $key->id }}"
                                                                    value="d" {{ $key->jawaban_user == 'd' ? 'checked' : '' }}>
                                                                <i class="input-helper"></i></label>
                                                            <div class="_pilihan">
                                                                <span><b>d.</b> </span>
                                                                <div class="_pilihan_isi">
                                                                    {!! $key->d !!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if ($key->e)
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input type="radio" class="form-check-input _radio"
                                                                    idpaketdtl="{{ $key->id }}" name="radio_{{ $key->id }}"
                                                                    value="e" {{ $key->jawaban_user == 'e' ? 'checked' : '' }}>
                                                                <i class="input-helper"></i></label>
                                                            <div class="_pilihan">
                                                                <span><b>e.</b> </span>
                                                                <div class="_pilihan_isi">
                                                                    {!! $key->e !!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if ($key->f)
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input type="radio" class="form-check-input _radio"
                                                                    idpaketdtl="{{ $key->id }}" name="radio_{{ $key->id }}"
                                                                    value="f" {{ $key->jawaban_user == 'f' ? 'checked' : '' }}>
                                                                <i class="input-helper"></i></label>
                                                            <div class="_pilihan">
                                                                <span><b>f.</b> </span>
                                                                <div class="_pilihan_isi">
                                                                    {!! $key->f !!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if ($key->g)
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input type="radio" class="form-check-input _radio"
                                                                    idpaketdtl="{{ $key->id }}" name="radio_{{ $key->id }}"
                                                                    value="g" {{ $key->jawaban_user == 'g' ? 'checked' : '' }}>
                                                                <i class="input-helper"></i></label>
                                                            <div class="_pilihan">
                                                                <span><b>g.</b> </span>
                                                                <div class="_pilihan_isi">
                                                                    {!! $key->g !!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if ($key->h)
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input type="radio" class="form-check-input _radio"
                                                                    idpaketdtl="{{ $key->id }}" name="radio_{{ $key->id }}"
                                                                    value="h" {{ $key->jawaban_user == 'h' ? 'checked' : '' }}>
                                                                <i class="input-helper"></i></label>
                                                            <div class="_pilihan">
                                                                <span><b>h.</b> </span>
                                                                <div class="_pilihan_isi">
                                                                    {!! $key->h !!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div style="padding-bottom:30px">
                                                <span>
                                                    @if (!$loop->first)
                                                        <button idsoal="{{ $key->id - 1 }}" type="button"
                                                            class="btn-next-back btn btn-sm btn-primary btn-rounded btn-fw mr-3">
                                                            <i class="ti-back-left btn-icon-prepend"></i>
                                                            Sebelumnya
                                                        </button>
                                                    @endif
                                                </span>
                                                <span style="float:right;padding-bottom:30px;">
                                                    @if (!$loop->last)
                                                        <button idsoal="{{ $key->id + 1 }}" type="button"
                                                            class="btn-next-back btn btn-sm btn-primary btn-rounded btn-fw ml-3">
                                                            Selanjutnya
                                                            <i class="ti-back-right btn-icon-prepend"></i>
                                                        </button>
                                                    @endif
                                                </span>
                                            </div>
                                            <!-- Tambahkan ini di dalam setiap tab soal -->
                                            <div class="pembahasan-container mt-3" id="pembahasan-{{ $key->id }}" style="display:none; border: 1px solid #444; border-radius: 5px; padding: 10px;">
                                                <div class="alert-jawaban"></div>
                                                <div class="jawaban-benar-container"></div>
                                                <div class="isi-pembahasan"></div>
                                            </div>

                                            <!-- Tombol toggle pembahasan (harus di dalam tab juga) -->
                                            <div>
                                                <button type="button"
                                                    class="btn btn-success btn-sm btn-rounded btn-pembahasan-toggle"
                                                    data-id="{{ $key->id }}">
                                                    <i class="fas fa-book-open"></i> Lihat Pembahasan
                                                </button>
                                            </div>  
                                        </div>
                                                        
                                    @endforeach
                                </div>
                                
                            </div>
                            <div class="col-xl-3 col-md-3 col-sm-3 col-xs-3">
                                <div class="mb-4 card-border p-3 div-waktu">
                                    <div class="mb-0" id="end">
                                        <h6>Waktu Tersisa</h6>
                                        <span class="f-waktu" id="hours"></span><br>
                                        <span class="f-waktu" id="mins"></span>
                                        <span class="f-waktu" id="secs"></span>
                                    </div>
                                </div>

                                <div class="mb-4 card-border p-3 br-10">
                                    <center class="mb-1" style="color: #fff;">Sudah Selesai?</center>
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#modalselesaiujian"
                                        class="btn-block btn btn-primary btn-sm _btn_selesai_ujian">
                                        <h6 class="mb-0">Selesaikan Ujian</h6>
                                    </button>
                                </div>

                                <div class="card-border p-3 br-10">
                                    <center class="mb-3">Nomor Soal</center>
                                    <ul class="_soal nav nav-pills mb-0" id="pills-tab" role="tablist">
                                        @foreach ($upaketsoalmst->u_paket_soal_dtl_r as $key)

                                            <li class="nav-item" role="presentation">
                                                <button id="btn_no_soal_{{ $key->id }}"
                                                    class="btn-sm {{ $key->jawaban_user ? '_ada_isi' : '' }} nav-link {{ $key->no_soal == 1 ? 'active' : '' }}"
                                                    data-bs-toggle="pill" data-bs-target="#pills-{{ $key->id }}" type="button"
                                                    role="tab" aria-selected="true">{{ $key->no_soal }}</button>
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

    <div class="modal fade" id="modalselesaiujian">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <!-- <div class="modal-header">
                <h4 class="modal-title">Selesaikan Ujian?</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div> -->

                <!-- Modal body -->
                <div class="modal-body pb-0">
                    <center style="font-size:18px"><i style="color:#106571" class="fa fa-check-square"></i> <span
                            style="color:#106571" class="modal-title"><b>Submit Jawaban Sekarang?</b></span></center>
                    <h5 class="mt-2">
                        <center>Jawaban yang telah disubmit tidak dapat diubah?</center>
                    </h5>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer" style="display:block;text-align: center;border-top:0px solid">
                    <button type="button" class="btn btn-primary" id="btn-selesai"
                        upaketsoalmst="{{Crypt::encrypt($upaketsoalmst->id)}}">Submit</button>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="modalkecermatan">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <!-- <div class="modal-header">
                <h4 class="modal-title">Selesaikan Ujian?</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div> -->

                <!-- Modal body -->
                <div class="modal-body pb-0">
                    <center style="font-size:18px"><i style="color:#106571" class="fa fa-check-square"></i> <span
                            style="color:#106571" class="modal-title"><b>Submit Jawaban Sekarang dan lanjut Ujian Kecermatan
                                ?</b></span></center>
                    <h5 class="mt-2">
                        <center>Jawaban yang telah disubmit tidak dapat diubah?</center>
                    </h5>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer" style="display:block;text-align: center;border-top:0px solid">
                    <button type="button" class="btn btn-primary" id="btn-lanjutsesi"
                        upaketsoalmst="{{Crypt::encrypt($upaketsoalmst->id)}}">Submit</button>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('footer')
<!-- jQuery -->
<!-- SweetAlert2 -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        // Disable right click and copy-paste
        $(document).bind("contextmenu", function (e) { return false; });
        $('body').on("cut copy paste", function (e) { e.preventDefault(); });

        // Toggle pembahasan
        $(document).on('click', '.btn-pembahasan-toggle', function () {
            $(this).closest('.tab-pane').find('.pembahasan-container').slideToggle();
        });

        // Navigasi soal
        $(document).on('click', '.btn-next-back', function () {
            const idsoal = $(this).attr('idsoal');
            $('.tab-pane').removeClass('show active');
            $('.nav-link').removeClass('active');
            $('#pills-' + idsoal).addClass('show active');
            $('#btn_no_soal_' + idsoal).addClass('active');

            $('html, body').animate({ scrollTop: 0 }, 'slow');
        });

        // Pilih jawaban
        $(document).on('change', '._radio', function () {
            const jawaban = $(this).val();
            const idpaketdl = $(this).attr('idpaketdtl');

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "{{ url('updatejawaban') }}",
                data: { jawaban, idpaketdl },
                beforeSend: function () {
                    $.LoadingOverlay("show", {
                        image: "{{ asset('/image/global/loading.gif') }}"
                    });
                },
                success: function(response) {
                    $.LoadingOverlay("hide");

                    if (response.status) {
                        $('#btn_no_soal_' + idpaketdl).addClass('_ada_isi');

                        // Jika ada evaluasi jawaban
                        const { data } = response;
                        if (data) {
                            const $tab = $('#pills-' + idpaketdl);
                            const isCorrect = data.isCorrect;
                            const jawabanBenar = (data.jawabanBenar || '').toUpperCase();
                            const htmlJawabanBenar = data.htmlJawabanBenar || '';
                            const pembahasan = data.pembahasan || '';

                            const $alert = $tab.find('.alert-jawaban');
                            const $benarContainer = $tab.find('.jawaban-benar-container');
                            const $pembahasanDiv = $tab.find('.pembahasan-container .isi-pembahasan');

                            if (isCorrect) {
                                $alert.removeClass('alert-danger').addClass('alert alert-success').html(
                                    `<i class="fas fa-check-circle"></i> <strong>Jawaban Anda Benar!</strong>`
                                );
                                $benarContainer.html('');
                            } else {
                                $alert.removeClass('alert-success').addClass('alert alert-danger').html(
                                    `<i class="fas fa-times-circle"></i> <strong>JAWABAN ANDA SALAH!</strong>`
                                );
                                $benarContainer.html(`
                                    <strong>Jawaban yang benar:</strong> ${jawabanBenar}
                                    <div>${htmlJawabanBenar}</div>
                                `);
                            }

                            $pembahasanDiv.html(`<h6><strong>PEMBAHASAN:</strong></h6><div>${pembahasan}</div>`);
                        }
                    } else {
                        Swal.fire({
                            html: response.message,
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                    }
                },
                error: function () {
                    alert('Error!!!');
                    $.LoadingOverlay("hide");
                }
            });
        });

        // Selesaikan ujian
        const submitUjian = () => {
            const idpaketmst = $('#btn-selesai').attr('upaketsoalmst');

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "{{ url('selesaiujian') }}",
                data: { idpaketmst },
                beforeSend: function () {
                    $.LoadingOverlay("show", {
                        image: "{{ asset('/image/global/loading.gif') }}"
                    });
                },
                success: function (response) {
                    if (response.status) {
                        $('.modal').modal('hide');
                        $('#end').html("UJIAN SELESAI!!");
                        reload_url(0, response.menu);
                    } else {
                        Swal.fire({
                            html: response.message,
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                    }
                },
                error: function () {
                    alert('Error!!!');
                },
                complete: function () {
                    // $.LoadingOverlay("hide");
                }
            });
        };

        $(document).on('click', '#btn-selesai', submitUjian);

        // Countdown timer
        // const countDownDate = new Date("{{ $upaketsoalmst->selesai }}").getTime();
        // const baseNow = new Date("{{ $now }}");
        // let i = 0;

        // const countdown = setInterval(() => {
        //     const now = new Date(baseNow.getTime() + (i * 1000));
        //     i++;

        //     const timeleft = countDownDate - now;
        //     const hours = Math.floor((timeleft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        //     const minutes = Math.floor((timeleft % (1000 * 60 * 60)) / (1000 * 60));
        //     const seconds = Math.floor((timeleft % (1000 * 60)) / 1000);

        //     $("#hours").html(`${hours} Jam`);
        //     $("#mins").html(`${minutes} Menit`);
        //     $("#secs").html(`${seconds} Detik`);

        //     if (timeleft < 0) {
        //         clearInterval(countdown);
        //         $("#end").html("UJIAN SELESAI!!");
        //         submitUjian();
        //     }
        // }, 1000);
    });
</script>
@endsection

