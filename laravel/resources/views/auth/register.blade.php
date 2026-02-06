<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @php
        $template = App\Models\Template::where('id', '<>', '~')->first();
    @endphp
    <title>{{ $template->nama }}</title>
    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('layout/skydash/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('layout/skydash/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('layout/skydash/vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('layout/skydash/css/vertical-layout-light/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset($template->logo_kecil) }}" />
    <script src="{{ asset('js/global.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/skydash.css') }}?v=11">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.css"
        integrity="sha512-uHuCigcmv3ByTqBQQEwngXWk7E/NaPYP+CFglpkXPnRQbSubJmEENgh+itRDYbWV0fUZmUz7fD/+JDdeQFD5+A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .input-foto-error .custom-file-label {
            border: 1px solid red;
        }

        .full-page-wrapper {
            position: relative;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url('https://apps.generasipenerus.com/css/images/bg-login.jpg') no-repeat center center/cover;
        }

        .content-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            width: 100%;
            background: #171A26;
            opacity: 0.5;
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1;
            background-color: #171A26;
        }

        .auth-form-container {
            max-width: 1000px;
            width: 100%;
            background: #171A26;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 2;
            position: relative;
            overflow-y: auto;
            max-height: 90vh;
            background-color: #171A26;
            border-color: white;
            /* Adjust as needed */
        }

        .auth-form-container .btn:hover {
            background-color: #0056b3 !important;
        }

        .brand-logo img {
            max-width: 70px;
        }

        .register-btn {
            color: black !important;
        }

        label {
            color: white;
        }
    </style>
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper m-0">
            <div class="content-wrapper"></div>
            <div class="auth-form-container">
                <div class="brand-logo mb-3 mt-3 text-center">
                    <a href="{{ url('/') }}"><img src="{{ asset($template->logo_besar) }}" alt="logo"></a>
                </div>
                <div class="text-center mb-3">
                    <h4 class="fw-600 text-blue fs-4">Daftar Akun</h4>
                </div>
                <div class="text-left py-0 px-0 px-sm-0 mt-2">
                    <form class="pt-3" method="post" id="formRegister">
                        @csrf
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group mb-2">
                                    <label class="fw-600 mb-0" for="name">Nama</label>
                                    <input type="text" class="form-control form-control-sm rounded-2" id="name"
                                        name="name" placeholder="Masukkan Nama">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group mb-2">
                                    <label class="fw-600 mb-0" for="no_wa">Nomor Telepon/Whatsapp</label>
                                    <input type="text" class="form-control form-control-sm angka rounded-2"
                                        id="no_wa" name="no_wa" placeholder="08123xxxxxx"
                                        aria-label="08123xxxxxx">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group mb-2">
                                    <label class="fw-600 mb-0" for="email">Email</label>
                                    <input type="email" class="form-control form-control-sm rounded-2" id="email"
                                        name="email" placeholder="Masukkan Email">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            {{-- <div class="col-lg-4">
                                <div class="form-group mb-2">
                                    <label class="fw-600 mb-0" for="ulangi_email">Ulangi Email</label>
                                    <input type="email" class="form-control form-control-sm rounded-2"
                                        id="ulangi_email" name="ulangi_email" placeholder="Ulangi Email">
                                </div>
                            </div> --}}
                            <div class="col-lg-4">
                                <div class="form-group mb-2">
                                    <label class="fw-600 mb-0" for="password">Masukkan Password</label>
                                    <input type="password" class="form-control form-control-sm rounded-2" id="password"
                                        name="password" placeholder="Masukkan Password">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group mb-2">
                                    <label class="fw-600 mb-0" for="ulangi_password">Ulangi Password</label>
                                    <input type="password" class="form-control form-control-sm rounded-2"
                                        id="ulangi_password" name="ulangi_password" placeholder="Ulangi Password">
                                </div>
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group mb-2">
                                    <label class="fw-600 mb-0" for="provinsi">Provinsi</label>
                                    <select class="form-control form-control-sm _select2 rounded-2" id="provinsi"
                                        name="provinsi">
                                        <option value=""></option>
                                        @foreach ($provinsi as $data)
                                            <option value="{{ $data->id_prov }}">{{ $data->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group mb-2">
                                    <label class="fw-600 mb-0" for="kabupaten">Kota/Kabupaten</label>
                                    <select class="form-control form-control-sm _select2 rounded-2" id="kabupaten"
                                        name="kabupaten">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group mb-2">
                                    <label class="fw-600 mb-0" for="referrer">Darimana tahu Belajarsoal.id?</label>
                                    <select class="form-control form-control-sm rounded-2" id="referrer"
                                        name="referrer">
                                        <option value=""></option>
                                        @foreach (referrer() as $refer)
                                            <option value="{{ $refer[0] }}">{{ $refer[1] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div> --}}

                        <div class="pt-2">
                            <button type="submit"
                                class="btn btn-block btn-primary rounded-2 bg-blue btn-lg font-weight-medium auth-form-btn">Daftar</button>
                        </div>
                    </form>
                    <div class="text-center mt-2 mb-2 font-weight-light">
                        Sudah punya akun?
                    </div>
                    <a href="{{ url('login') }}?redirect={{ request()->redirect }}"
                        class="btn rounded-2 btn-block btn-primary font-weight-medium auth-form-btn text-blue register-btn w-100 fw-600">Masuk
                        Sekarang</a>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{ asset('layout/skydash/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('layout/skydash/js/off-canvas.js') }}"></script>
    <script src="{{ asset('layout/skydash/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('layout/skydash/js/template.js') }}"></script>
    <script src="{{ asset('layout/skydash/js/settings.js') }}"></script>
    <script src="{{ asset('layout/skydash/js/todolist.js') }}"></script>
    <!-- endinject -->

    <!-- jQuery -->
    <script src="{{ asset('layout/adminlte3/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('layout/adminlte3/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- jquery-validation -->
    <script src="{{ asset('layout/adminlte3/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('layout/adminlte3/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <!-- Loading Overlay -->
    <script src='https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.6/dist/loadingoverlay.min.js'>
    </script>
    <!-- SweetAlert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"
        integrity="sha512-NqYds8su6jivy1/WLoW8x1tZMRD7/1ZfhWG/jcRQLOzV1k1rIODCpMgoBnar5QXshKJGV7vi0LXLNXPoFsM5Zg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.js"
        integrity="sha512-GkPcugMfi6qlxrYTRUH4EwK4aFTB35tnKLhUXGLBc3x4jcch2bcS7NHb9IxyM0HYykF6rJpGaIJh8yifTe1Ctw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/themes@5.0.11/minimal/minimal.css"> -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Global -->
    <script src="{{ asset('js/global.js') }}"></script>
    <!-- Custom Input File -->
    <script src="{{ asset('layout/adminlte3/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#referrer').select2({
                placeholder: "Pilih Referrer"
            });

            getSemuaKota('provinsi', 'kabupaten', '{{ url('/getKabupaten') }}',
                '{{ asset('/image/global/loading.gif') }}');

            $(".angka").on('input paste', function() {
                hanyaAngka(this);
            });

            $('#formRegister').validate({
                rules: {
                    name: {
                        required: true
                    },
                    no_wa: {
                        required: true,
                        minlength: 10,
                        maxlength: 15
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    ulangi_email: {
                        email: true,
                        required: true,
                        equalTo: "#email"
                    },
                    password: {
                        required: true,
                        minlength: 4
                    },
                    ulangi_password: {
                        required: true,
                        equalTo: "#password"
                    },
                    provinsi: {
                        required: true
                    },
                    kabupaten: {
                        required: true
                    },
                    referrer: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: "Nama tidak boleh kosong"
                    },
                    no_wa: {
                        required: "Nomor telepon/whatsapp tidak boleh kosong",
                        minlength: "Masukkan nomor yang benar",
                        maxlength: "Masukkan nomor yang benar"
                    },
                    email: {
                        required: "Email tidak boleh kosong",
                        email: "Masukkan email yang benar"
                    },
                    ulangi_email: {
                        equalTo: "Ulangi email harus sama",
                        required: "Ulangi email tidak boleh kosong",
                        email: "Masukkan email yang benar"
                    },
                    password: {
                        required: "Password tidak boleh kosong",
                        minlength: "Masukkan minimal 4 karakter"
                    },
                    ulangi_password: {
                        required: "Ulangi password tidak boleh kosong",
                        equalTo: "Ulangi password harus sama"
                    },
                    provinsi: {
                        required: "Provinsi tidak boleh kosong"
                    },
                    kabupaten: {
                        required: "Kota/Kabupaten tidak boleh kosong"
                    },
                    referrer: {
                        required: "Referrer tidak boleh kosong"
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    if (element.hasClass('select')) {
                        element.parent().addClass('select2-error');
                        error.addClass('invalid-feedback');
                        element.closest('.form-group').append(error);
                    } else if (element.hasClass('input-foto')) {
                        element.parent().addClass('input-foto-error');
                        error.addClass('invalid-feedback');
                        element.closest('.form-group').append(error);
                    } else {
                        error.addClass('invalid-feedback');
                        element.closest('.form-group').append(error);
                    }
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                    if (element.tagName.toLowerCase() == 'select') {
                        var x = element.getAttribute('id');
                        $('#' + x).parent().addClass('select2-error');
                    } else if (element.tagName.toLowerCase() == 'input') {
                        var x = element.getAttribute('class');
                        var z = element.getAttribute('id');
                        if (x == "input-foto is-invalid") {
                            $('#' + z).parent().addClass('input-foto-error');
                        }
                    }
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                    if (element.tagName.toLowerCase() == 'select') {
                        var x = element.getAttribute('id');
                        $('#' + x).parent().removeClass('select2-error');
                    } else if (element.tagName.toLowerCase() == 'input') {
                        var x = element.getAttribute('class');
                        var z = element.getAttribute('id');
                        if (x == "input-foto") {
                            $('#' + z).parent().removeClass('input-foto-error');
                        }
                    }
                },

                submitHandler: function() {
                    var formData = new FormData($('#formRegister')[0]);

                    var url = "{{ url('/storeregister') }}";
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
                            $.LoadingOverlay("show", {
                                image: "{{ asset('/image/global/loading.gif') }}"
                            });
                        },
                        success: function (response) {
    if (response.status === true) {
        Swal.fire({
            icon: 'success',
            title: 'Pendaftaran Berhasil',
            html: 'Kami telah mengirimkan konfirmasi data pendaftaran ke alamat email Anda.<br>' +
                  'Harap periksa email Anda di folder <strong>Inbox</strong> atau <strong>Spam</strong>.<br>' +
                  'Mohon tandai pesan kami sebagai <em>bukan spam</em> agar notifikasi berikutnya tidak terlewat.<br><br>' +
                  'Terima kasih.',
            confirmButtonText: 'OK'
        }).then(() => {
            // alihkan setelah pengguna menekan OK
            const redirectUrl = "{{ request()->has('redirect') ? request()->get('redirect') : url('/home') }}";
            window.location.href = redirectUrl;
        });
    } else {
        Swal.fire({
            icon: 'error',
            title: response.message,
            confirmButtonText: 'OK',
            showCloseButton: true
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
            });
        });
    </script>
</body>

</html>
