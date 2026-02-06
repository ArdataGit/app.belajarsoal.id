<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
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
    <link rel="stylesheet" href="{{ asset('css/skydash.css') }}?v=<?php echo rand(); ?>">
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper m-0">
            <div class="content-wrapper d-flex align-items-center auth px-0 bg-[#171a26] py-0">
                <div class="row w-100 mx-0 h-100 align-items-center">
                    <div class="col-lg-6 mx-auto px-5">
                        <div class="row">
                            <div class="col-lg-10 mx-auto px-md-5 col-12 px-0">
                                <div class="brand-logo mb-4 mt-4 pt-2 mt-md-0 pt-md-0 pb-3">
                                    <a href="{{ url('/') }}"><img src="{{ asset($template->logo_besar) }}?v=111"
                                            alt="logo"></a>
                                </div>
                                <div class="text-center mb-3">
                                    <h4 class="fw-600 text-blue fs-4">Masuk</h4>
                                    <div class="text-sm text-white"> Masukkan alamat email dan password yang terdaftar
                                    </div>
                                </div>
                                <div class="text-left py-0 px-0 px-sm-2">
                                    @if ($errors->any())
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            {{ $errors->first() }}
                                        </div>
                                    @endif
                                    <form class="pt-3" method="post" id="formLogin">
                                        @csrf
                                        <div class="form-group mb-3">
                                            <label class="fw-600 mb-1 text-white">Email</label>
                                            <input type="email"
                                                class="form-control form-control-sm rounded-2 bg-white" id="username"
                                                name="username" placeholder="Masukkan Email">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="fw-bold mb-1 text-white">Password</label>
                                            <input type="password"
                                                class="form-control form-control-sm rounded-2 bg-white" id="password"
                                                name="password" placeholder="Masukkan Password">
                                        </div>
                                        <div class="my-2 d-flex justify-content-between align-items-center">
                                            <div class="form-check my-2 my-md-0">
                                                <label class="form-check-label text-white ms-3 ps-2">
                                                    <input type="checkbox" class="form-check-input">
                                                    Ingat Saya
                                                </label>
                                            </div>
                                            <a href="{{ url('lupapassword') }}" class="auth-link text-blue fw-600">Lupa
                                                Kata Sandi?</a>
                                        </div>
                                        <div class="mt-3">
                                            <button type="submit"
                                                class="btn rounded-2 btn-block btn-primary font-weight-medium auth-form-btn bg-blue">Masuk</button>
                                            <!-- <a href="{{ url('auth/google') }}" class="btn btn-block btn-primary btn-sm font-weight-medium auth-form-btn">LOOGIN GOOGLE</a> -->
                                            <!--<a href="{{ url('auth/google') }}" type="button"
                                                class="btn rounded-2 btn-block btn-google auth-form-btn text-white">
                                                <i class="ti-google mr-2"></i>Masuk dengan Google
                                            </a>-->
                                        </div>
                                        <!-- <div class="mb-2">
                  <button type="button" class="btn btn-block btn-facebook auth-form-btn">
                  <i class="ti-facebook mr-2"></i>Connect using facebook
                  </button>
                </div> -->
                                        <div class="text-center mt-3 mb-3 font-weight-light">
                                            Belum punya akun?
                                        </div>
                                        <a href="{{ url('buatakun') }}?redirect={{ request()->redirect }}"
                                            class="btn rounded-2 btn-block btn-primary font-weight-medium auth-form-btn text-blue register-btn w-100 fw-600">Daftar</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mx-auto bg-login h-100 d-none d-sm-block"></div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
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
    <!-- AdminLTE App -->
    <!-- <script src="{{ asset('layout/adminlte3/dist/js/adminlte.min.js') }}"></script> -->

    <!-- Loading Overlay -->
    <script src='https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.6/dist/loadingoverlay.min.js'>
    </script>
    <!-- SweetAlert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/themes@5.0.11/minimal/minimal.css"> -->
    <!-- Global -->
    <script src="{{ asset('js/global.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#formLogin').validate({
                rules: {
                    username: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true
                    },
                },
                messages: {
                    username: {
                        required: "Email tidak boleh kosong",
                        email: "Masukkan email yang benar!"
                    },
                    password: {
                        required: "Password tidak boleh kosong"
                    },

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
                    var formData = new FormData($('#formLogin')[0]);

                    var url = "{{ url('userauth') }}";
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
                            // $.LoadingOverlay("show");
                            $.LoadingOverlay("show", {
                                image: "{{ asset('/image/global/loading.gif') }}"
                            });
                        },
                        success: function(response) {
                            if (response.status === true) {
                                Swal.fire({
                                    title: response.message,
                                    icon: 'success',
                                    showConfirmButton: false
                                });
                                var redirectUrl = "{{ request()->has('redirect') ? request()->get('redirect') : url('/home') }}";
                                reload_url(1000, redirectUrl);
                            } else {
                                Swal.fire({
                                    title: response.message,
                                    icon: 'error',
                                    confirmButtonText: 'Ok',
                                    showCloseButton: true,
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
