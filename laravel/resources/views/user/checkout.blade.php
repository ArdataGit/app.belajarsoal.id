@extends('layouts.Skydash')

@section('content')
    @if (env('DUITKU_SANDBOX_MODE'))
        <!-- <script src="https://app-sandbox.duitku.com/lib/js/duitku.js"></script> -->
    @else
        <!-- <script src="https://app-prod.duitku.com/lib/js/duitku.js"></script> -->
    @endif

    <style>
        .bg-harga-beli {
            background: #effff1;
            align-items: center;
            text-align: center;
            border-radius: 8px;
        }

        .custom-buttom:hover {
            cursor: pointer;
        }

        .bg-primary-custom {
            background: #3185fc;
        }

        .img-lock {
            width: 50px;
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
            padding: 12px;
        }

        .img-btn-beli {
            width: 100%;
        }

        .border-top {
            border: 1px solid #7f7f7f;
            border-top: 6px solid #3185fc !important;
        }

        .row-atas {
            margin-left: 0px;
        }

        @media (max-width: 768px) {
            .img-btn-beli {
                width: 100%;
            }

            .row-atas {
                margin-left: 0px;
                margin-right: 0px;
            }

            .col-bawah {
                padding-left: 0px;
                padding-right: 0px;
                margin-top: 15px;
            }
        }

        h6,
        h4,
        p,
        table,
        tr,
        td,
        label {
            color: white;
        }

        /* Efek hover */
        .hover-box:hover .card-body,
        .hover-box.selected .card-body {
            background-color: #4a4a4a !important;
            /* Abu-abu tua */
            color: white !important;
            /* Agar teks tetap terbaca */
        }

        .hover-box:hover .payment-name,
        .hover-box:hover .biaya,
        .hover-box.selected .payment-name,
        .hover-box.selected .biaya {
            color: white !important;
            /* Warna teks tetap kontras */
        }

        /* Tambahan efek untuk ikon ceklis jika dipilih */
        .hover-box .cek {
            display: none;
        }

        .hover-box.selected .cek {
            display: block;
        }
    </style>
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card card-border">
                    <div class="card-body">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('home') }}"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page"><a
                                        href="{{ url('belipaketktg') }}">Beli Paket</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><a
                                        href="{{ url('belipaketsubktg') }}/{{ Crypt::encrypt($paket->fk_paket_kategori) }}">{{ $paket->kategori_r->judul }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page"><a
                                        href="{{ url('belipaket') }}/{{ Crypt::encrypt($paket->fk_paket_subkategori) }}">{{ $paket->subkategori_r->judul }}</a>
                                </li>
                                <li class="breadcrumb-item active text-white" aria-current="page">Checkout & Pembayaran</li>
                            </ol>
                        </nav>
                        <p class="card-description">
                        <h3 class="font-weight-bold text-white"><b>Checkout & Pembayaran</b></h3>
                        <h6 style="color: red;"> Untuk menggunakan e-wallet, Silahkan update nomor HP dahulu di <a
                                href="{{ url('profileuser') }}"><b style="color: red;">halaman profile</b></a></h6>
                        </p>
                        <div class="row mt-4 row-atas">
                            <div class="col-md-7 pb-3" style="border:1px solid #7f7f7f;border-radius:20px">
                                <h4 class="mt-3"><b>Pilih Metode Pembayaran</b></h4>
                                <div class="row">
                                    @forelse($channel as $key)
                                        <div class="col-12 col-md-4 col-lg-4 d-flex align-items-stretch mt-3 hover-box"
                                            channel="{{ $key->kode }}" namachannel="{{ $key->nama }}">
                                            <div class="card w-100">
                                                <div class="card-body shadow"
                                                    style="min-height: 90px; padding: 1rem;border-radius: 5px; background-color:#ffffff">
                                                    <div class="d-flex mb-2">
                                                        {{-- <div class="mr-auto text-left text-primary pr-2 payment-name">
                                                            {{ $key->nama }}</div> --}}
                                                    </div>
                                                    <div class="text-center bg-white"><img src="{{ $key->img }}"
                                                            alt="" class="img-fluid" style="object-fit:contain">
                                                    </div>
                                                    {{-- <p class="biaya mt-3 mb-0">Biaya : {{ $key->biaya }}</p> --}}
                                                    <!-- <p class="biaya mt-1 mb-0 small text-info">* Min. Biaya : Rp 1.000</p>
                                                                                                        <div class="mt-2 quote">Pembayaran dengan cara dialihkan ke aplikasi e-wallet ShopeePay. Hanya dapat digunakan untuk pelanggan yang mengakses melalui perangkat mobile</div> -->
                                                </div>
                                            </div>
                                            <div class="cek">
                                                <i class="icon-check mx-0"></i>
                                            </div>
                                        </div>
                                    @empty
                                        <center><img class="mb-3 img-no" src="{{ asset('image/global/no-paket.png') }}"
                                                alt=""></center>
                                        <br>
                                        <center>Belum Ada Data</center>
                                    @endforelse
                                </div>

                            </div>
                            <div class="col-md-5 col-bawah">
                                {{-- <div class="card card-border border-top">
                                    <div class="card-body">
                                        <form method="post" id="_formData" class="form-horizontal">
                                            @csrf
                                            <center>
                                                <h4><b>Kode voucher promo<br>(apabila ada)</b></h4>
                                            </center>
                                            <hr>
                                            <div class="form-group mb-2">
                                                <input type="text" name="kode" id="kode" class="form-control"
                                                    placeholder="Masukkan Kode Voucher">
                                                <input type="hidden" name="idpaket" id="idpaket"
                                                    value="{{ Crypt::encrypt($paket->id) }}">
                                            </div>
                                            <button id="btn-cek-kode" type="submit"
                                                class="btn btn-md btn-block btn-primary">Gunakan</button>
                                        </form>
                                    </div>
                                </div> --}}
                                <div class="card card-border mt-3 border-top">
                                    <div class="card-body" style="text-align:left">
                                        <h4><b>Rincian pembelian</b></h4>
                                        <hr>
                                        <label for="">Nama Paket</label>
                                        <input type="text" class="form-control" placeholder="Nama Paket"
                                            style="color:#3185fc;border-color:#3185fc" value="{{ $paket->judul }}"
                                            readonly>
                                        <div class="table-responsive">
                                            <table class="table table-borderless">
                                                <tbody>
                                                    <tr>
                                                        <td>Harga</td>
                                                        <td style="text-align:right">
                                                            <span class="txt-merah" style="text-decoration: line-through;">
                                                                {{ formatCoret($paket->harga) }}
                                                            </span>
                                                            <br>
                                                            <span>
                                                                {{ formatRupiah($paket->harga) }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    {{-- <tr>
                                                        <td>Biaya Admin</td>
                                                        <td style="text-align:right">{{ formatRupiah(0) }}</td>
                                                    </tr> --}}
                                                    <tr style="border-bottom:1px solid #c0c0c0">
                                                        <td>Diskon Promo</td>
                                                        <td style="text-align:right" id="jumlahdiskon">
                                                            {{ formatRupiah(0) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Total Pembayaran</b></td>
                                                        <td style="text-align:right"><b
                                                                id="jumlahtotal">{{ formatRupiah($paket->harga) }}</b></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div>
                                            <input type="hidden" id="idpromo">
                                            <button id="btn-beli-duitku" type="button"
                                                class="btn btn-md btn-primary btn-block">Beli Paket</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (!$ceksudahbeli)
            <!-- The Modal -->
            <div class="modal fade" id="myModal">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <!-- <div class="modal-header">
                                                                                              <h3 class="modal-title">Detail Pesanan</h3>
                                                                                            </div> -->

                        <!-- Modal body -->
                        <div class="modal-body">

                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer" id="modal-footer-beli">
                            <!-- <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">Tidak</button> -->

                        </div>

                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('footer')
    <!-- jquery-validation -->
    <script src="{{ asset('layout/adminlte3/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('layout/adminlte3/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('.hover-box').forEach(item => {
            item.addEventListener('click', function() {
                // Hapus kelas 'selected' dari semua elemen sebelum menambahkan ke elemen yang diklik
                document.querySelectorAll('.hover-box').forEach(box => box.classList.remove('selected'));

                // Tambahkan kelas 'selected' ke elemen yang diklik
                this.classList.add('selected');
            });
        });
    </script>
    <script>
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
        $(document).ready(function() {

            // $(document).on('click', '.btn-beli-paket', function (e) {
            //   $("#myModal").modal('show');
            // });
            $(".hover-box").click(function() {
                x = $(this).hasClass('active');
                if (x) {
                    $(this).removeClass('active');
                } else {
                    $(".hover-box").removeClass('active');
                    $(this).addClass('active');
                }
            });

            // Fungsi Cek Kode
            $('#_formData').validate({
                rules: {
                    kode: {
                        required: true
                    }
                },
                messages: {
                    kode: {
                        required: "Kode voucher harus diisi"
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },

                submitHandler: function() {

                    var formData = new FormData($('#_formData')[0]);

                    var url = "{{ url('cekkode') }}";
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
                        beforeSend: function() {
                            $.LoadingOverlay("show");
                        },
                        success: function(response) {
                            if (response.status == true) {
                                Swal.fire({
                                    title: response.message,
                                    html: "Anda mendapat potongan " + formatRupiah(
                                        response.promo),
                                    icon: 'success',
                                    showConfirmButton: true
                                });
                                $("#jumlahdiskon").html(formatRupiah(response.promo));
                                $("#jumlahtotal").html(formatRupiah(response.total));
                                $("#idpromo").val(response.idpromo);
                            } else {
                                Swal.fire({
                                    html: response.message,
                                    icon: 'error',
                                    confirmButtonText: 'Ok'
                                });
                            }
                        },
                        error: function(xhr, status) {
                            alert('Error!!!');
                        },
                        complete: function() {
                            $.LoadingOverlay("hide");
                        }
                    });
                }
            });

            $("#btn-beli-duitku").click(function() {

                idpaket = "{{ Crypt::encrypt($paket->id) }}";
                idpromo = $("#idpromo").val();
                channel = $(".hover-box.active").attr('channel');
                namachannel = $(".hover-box.active").attr('namachannel');
                total = $("#jumlahtotal").html();

                if (!channel) {
                    Swal.fire({
                        html: "Harap pilih metode pembayaran terlebih dahulu",
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    });
                    return false;
                }

                Swal.fire({
                    title: 'Konfimasi Pembelian',
                    html: "Paket : <b>{{ $paket->judul }}</b><br>Total Pembayaran : <b>" + total +
                        "</b><br>Metode Pembayaran : <b>" + namachannel + "</b>",
                    // icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Beli Paket',
                    cancelButtonText: `Batal`,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            type: "POST",
                            data: {
                                idpaket: idpaket,
                                idpromo: idpromo,
                                channel: channel,
                                urlpaket: "{{ url()->full() }}"
                            },
                            url: '{{ url('createordertripay') }}',
                            dataType: "json",
                            cache: false,
                            beforeSend: function() {
                                $.LoadingOverlay("show", {
                                    image: "{{ asset('/image/global/loading.gif') }}"
                                });
                                // $('.modal').modal('hide');
                                // $("#modal-footer-beli").html("");
                                // $("#btn-ajukan-pesanan").removeAttr("data-bs-toggle");
                                // $("#btn-ajukan-pesanan").removeAttr("data-bs-toggle");
                                // $("#btn-ajukan-pesanan").html('<span class="spinner-border spinner-border-sm"></span>Loading..');
                            },

                            success: function(response) {
                                if (response.success == true) {
                                    Swal.fire({
                                        html: response.message,
                                        icon: 'success',
                                        showConfirmButton: false
                                    });
                                    reload_url(1500, response.url);
                                } else {
                                    Swal.fire({
                                        html: response.message,
                                        icon: 'error',
                                        confirmButtonText: 'Ok'
                                    });
                                }
                            },
                            error: function(xhr, status) {
                                alert('Error! Please Try Again');
                            },
                            complete: function() {
                                $.LoadingOverlay("hide");
                            }
                        });
                    }
                })
            });
        });
    </script>
    <!-- Loading Overlay -->
@endsection
