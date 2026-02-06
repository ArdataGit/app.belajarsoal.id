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
                                                                                                role="tabpanel" style="font-size: 1rem important;">
                                                                                                <!-- <h6><b>[{{ $key->nama_tingkat }}]</b></h6> -->
                                                                                                <div class="mb-3 p-3 card-border" style="border-radius: 10px; font-size:16px;">
                                                                                                    <h4 class="ktg-soal">{{ $judulsesi }}
                                                                                                        {{ $datakategori->judul }}
                                                                                                    </h4>
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
                                                                                                        @if ($loop->parent->first && $loop->first)
                                                                                                        @else
                                                                                                            <button idsoal="{{ $key->id - 1 }}" type="button"
                                                                                                                class="btn-next-back btn btn-sm btn-primary btn-rounded btn-fw ml-3">
                                                                                                                <i class="ti-back-left btn-icon-prepend"></i>
                                                                                                                Sebelumnya
                                                                                                            </button>
                                                                                                        @endif
                                                                                                    </span>

                                                                                                    <span style="float:right;padding-bottom:30px">
                                                                                                        @if ($loop->parent->last && $loop->last)
                                                                                                        @else
                                                                                                            <button idsoal="{{ $key->id + 1 }}" type="button"
                                                                                                                class="btn-next-back btn btn-sm btn-primary btn-rounded btn-fw mr-3">
                                                                                                                Selanjutnya
                                                                                                                <i class="ti-back-right btn-icon-prepend"></i>
                                                                                                            </button>
                                                                                                        @endif
                                                                                                    </span>
                                                                                                </div>
                                                                                            </div>
                                                                                            @php
                                                                                                $no++;
                                                                                            @endphp
                                                                @endforeach
                                                                <!-- <div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">2</div> -->
                                    @endforeach

                                </div>
                            </div>
                            <div class="col-xl-3 col-md-3 col-sm-3 col-xs-3">
                                <div class="card card-border w-100 mb-4">
                                    <div class="card-body" style="background-color:#1E2538">
                                        <div class="mb-4 card-border div-waktu">
                                            <div class="mb-0" id="end">
                                                <h6 class="fw-600 text-center mb-3 text-white">Waktu Tersisa</h6>
                                                <span class="f-waktu" id="hours"></span><br />
                                                <span class="f-waktu" id="mins"></span>
                                                <span class="f-waktu" id="secs"></span>
                                            </div>
                                        </div>

                                        <div class="mb-4 card-border br-10">
                                            <center class="mb-1 text-white">Sudah Selesai?</center>
                                            @if (count($upaketsoalmst->u_paket_soal_ktg_nonaktif_r) > 0)
                                                <button type="button" data-bs-toggle="modal" data-bs-target="#modallanjutsesi"
                                                    class="btn-block btn btn-primary btn-sm">
                                                    <h6 class="mb-0">Lanjut Sesi</h6>
                                                </button>
                                            @else
                                                <button type="button" data-bs-toggle="modal" data-bs-target="#modalselesaiujian"
                                                    class="btn-block btn btn-primary btn-sm">
                                                    <h6 class="mb-0">Selesaikan Ujian</h6>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="card-border p-3 br-10">
                                    <center class="mb-2 text-white">{{ $judulsesi }}</center>
                                    <div>
                                        @foreach ($upaketsoalmst->u_paket_soal_ktg_r as $keyktg)
                                            <h6
                                                class='{{ $keyktg->id == $idupaketsoalktg ? 'sesuai' : 'text-white' }} {{ $keyktg->is_mengerjakan == 2 ? 'selesai' : '' }}'>
                                                {{ $keyktg->judul }}
                                                @if ($keyktg->is_mengerjakan == 2)
                                                    <i class="fas fa-check"></i>
                                                @endif
                                            </h6>
                                        @endforeach
                                    </div>
                                    <br>
                                    <center class="mb-3 text-white">Nomor Soal</center>
                                    <ul class="_soal nav nav-pills mb-0" id="pills-tab" role="tablist">
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($dataloop as $datakategori)
                                                                        @foreach ($datakategori->u_paket_soal_dtl_r as $key)
                                                                                                        <!-- <li class="nav-item" role="presentation">
                                                                                                                                        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">1</button>
                                                                                                                                      </li> -->
                                                                                                        <li class="nav-item" role="presentation">
                                                                                                            <button id="btn_no_soal_{{ $key->id }}"
                                                                                                                class="btn-sm {{ $key->jawaban_user ? '_ada_isi' : '' }} nav-link {{ $no == 1 ? 'active' : '' }}"
                                                                                                                data-bs-toggle="pill" data-bs-target="#pills-{{ $key->id }}" type="button"
                                                                                                                role="tab" aria-selected="true">{{ $key->no_soal }}</button>
                                                                                                        </li>
                                                                                                        @php
                                                                                                            $no++;
                                                                                                        @endphp
                                                                        @endforeach
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

    @if (count($upaketsoalmst->u_paket_soal_ktg_nonaktif_r) > 0)
        <div class="modal fade" id="modallanjutsesi">
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
                                style="color:#106571" class="modal-title"><b>Selesaikan Sesi Ini?</b></span></center>
                        <h5 class="mt-2">
                            <center>Jawaban yang telah diselesaikan tidak dapat diubah lagi!</center>
                        </h5>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer" style="display:block;text-align: center;border-top:0px solid">
                        <button type="button" class="btn btn-primary" id="btn-lanjutsesi"
                            upaketsoalmst="{{ Crypt::encrypt($upaketsoalmst->id) }}"
                            upaketsoalktg="{{ Crypt::encrypt($idupaketsoalktg) }}">Lanjut Sesi</button>
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>

                </div>
            </div>
        </div>
    @else
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
                            <center>Jawaban yang telah disubmit tidak dapat diubah!</center>
                        </h5>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer" style="display:block;text-align: center;border-top:0px solid">
                        <button type="button" class="btn btn-primary" id="btn-selesai"
                            upaketsoalmst="{{ Crypt::encrypt($upaketsoalmst->id) }}">Submit</button>
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>

                </div>
            </div>
        </div>
    @endif
@endsection

@section('footer')
    <!-- jQuery -->
    <!-- SweetAlert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // window.onbeforeunload = function() {
        //     return "Yakin ingin keluar dari halaman ini!";
        // };
        $(document).ready(function () {

            $(document).bind("contextmenu", function (e) {
                return false;
            });

            $('body').on("cut copy paste", function (e) {
                e.preventDefault();
            });

            $(document).on('click', '.btn-next-back', function (e) {
                idsoal = $(this).attr('idsoal');
                $('.tab-pane').removeClass('show active');
                $('.nav-link').removeClass('active');

                $('#pills-' + idsoal).addClass('show active');
                $('#btn_no_soal_' + idsoal).addClass('active');

                $('html, body').animate({
                    scrollTop: 0
                }, 'slow');
            });

            $(document).on('change', '._radio', function (e) {
                jawaban = $(this).val();
                idpaketdl = $(this).attr('idpaketdtl');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: "{{ url('updatejawaban') }}",
                    // async: false,
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


            $(document).on('click', '#btn-selesai', function (e) {
                idpaketmst = $('#btn-selesai').attr('upaketsoalmst');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: "{{ url('selesaiujian') }}",
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

                            $('.modal').modal('hide');
                            document.getElementById("end").innerHTML = "UJIAN SELESAI!!";
                            reload_url(0, response.menu);

                            // Swal.fire({
                            //     html: response.message,
                            //     icon: 'success',
                            //     showConfirmButton: true
                            // }).then((result) => {
                            //     $.LoadingOverlay("show", {
                            //       image       : "{{ asset('/image/global/loading.gif') }}"
                            //     });
                            // })

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
                        // $.LoadingOverlay("hide");
                    }
                });
            });

            // Lanjut Sesi
            $(document).on('click', '#btn-lanjutsesi', function (e) {
                document.getElementById("end").innerHTML = "SESI SELESAI!!";

                idpaketmst = $('#btn-lanjutsesi').attr('upaketsoalmst');
                idupaketsoalktg = $('#btn-lanjutsesi').attr('upaketsoalktg');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: "{{ url('lanjutsesi') }}",
                    // async: false,
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
                            Swal.fire({
                                title: "Sesi Selesai!",
                                html: "Halaman akan diarahakan kesesi selanjutnya...",
                                icon: 'success',
                                showConfirmButton: false
                            })
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
            });

            // COUNDOWN
            // The data/time we want to countdown to
            var countDownDate = new Date("{{ $selesai }}").getTime();


            // Run myfunc every second
            i = 0;
            var myfunc = setInterval(function () {

                const now = new Date('{{ $now }}');
                now.setSeconds(now.getSeconds() + i);
                i++;
                // console.log(date.setSeconds(date.getSeconds() + 5));

                // var now = new Date().getTime();
                var timeleft = countDownDate - now;

                // Calculating the days, hours, minutes and seconds left
                // var days = Math.floor(timeleft / (1000 * 60 * 60 * 24));
                var hours = Math.floor((timeleft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((timeleft % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((timeleft % (1000 * 60)) / 1000);

                // Result is output to the specific element
                // document.getElementById("days").innerHTML = days + ""
                document.getElementById("hours").innerHTML = hours + " Jam "
                document.getElementById("mins").innerHTML = minutes + " Menit "
                document.getElementById("secs").innerHTML = seconds + " Detik"

                // Display the message when countdown is over
                if (timeleft <= 0) {
                    clearInterval(myfunc);
                    // document.getElementById("days").innerHTML = ""
                    // document.getElementById("hours").innerHTML = ""
                    // document.getElementById("mins").innerHTML = ""
                    // document.getElementById("secs").innerHTML = ""
                    if ("{{ count($upaketsoalmst->u_paket_soal_ktg_nonaktif_r) }}" > 0) {

                        document.getElementById("end").innerHTML = "SESI SELESAI!!";

                        idpaketmst = $('#btn-lanjutsesi').attr('upaketsoalmst');
                        idupaketsoalktg = $('#btn-lanjutsesi').attr('upaketsoalktg');
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            type: "POST",
                            dataType: "JSON",
                            url: "{{ url('lanjutsesi') }}",
                            // async: false,
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

                        idpaketmst = $('#btn-selesai').attr('upaketsoalmst');
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            type: "POST",
                            dataType: "JSON",
                            url: "{{ url('selesaiujian') }}",
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
                                    $('.modal').modal('hide');
                                    Swal.fire({
                                        html: response.message,
                                        icon: 'success',
                                        showConfirmButton: true
                                    }).then((result) => {
                                        $.LoadingOverlay("show", {
                                            image: "{{ asset('/image/global/loading.gif') }}"
                                        });
                                        reload_url(1500, response.menu);
                                    })

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
                }
            }, 1000);
            // END COUNDOWN
        });
    </script>
    <!-- Loading Overlay -->
@endsection