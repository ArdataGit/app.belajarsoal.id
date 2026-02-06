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
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/3.1.2/es5/tex-mml-chtml.min.js"
        integrity="sha384-KyZXEAg3QhqLMpG8r+v\/ZzXt86G2nM+T\/yKLtE3mvMoi0A2VkuH5FoMIpZoCUWxrc" crossorigin="anonymous">
    </script>
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
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('layout/skydash/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('layout/skydash/js/select.dataTables.min.css') }}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset($template->logo_kecil) }}" />
    <link rel="stylesheet" href="{{ asset('layout/skydash/vendors/mdi/css/materialdesignicons.min.css') }}">
    <script src="https://kit.fontawesome.com/f121295e13.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background: #171A26;
        }

        .main-panel {
            margin-top: 80px;
            /* Memberi jarak antara navbar dan konten */
        }

        .navbar-toggler {
            border-color: white !important;
        }

        .navbar-toggler-icon {
            background-color: white;
            /* Bisa juga menggunakan warna lain */
            mask-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3E%3Cpath stroke='black' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
            -webkit-mask-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3E%3Cpath stroke='black' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
        }

        @media (max-width: 991px) {
            .navbar-collapse {
                background: #1d6c2b;
                /* Warna latar belakang ketika navbar terbuka */
                padding: 5px;
            }
        }


        .navbar {
            background: #285287;
            padding: 5px 0;
        }

        .navbar a,
        .navbar .nav-link {
            color: white !important;
        }

        .navbar-brand img {
            height: 70px !important;
            background: transparent !important;
        }
    </style>
    @section('header')
    @show
</head>

<body>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand bg-transparent p-0" href="/">
                <img src="{{ asset($template->logo_besar) }}" alt="Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/informasi-public') }}">Informasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/login') }}">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="main-panel">
        @section('content')
        @show
    </div>
    <!-- container-scroller -->
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- plugins:js -->
    <script src="{{ asset('layout/skydash/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{ asset('layout/skydash/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('layout/skydash/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('layout/skydash/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('layout/skydash/js/dataTables.select.min.js') }}"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('layout/skydash/js/Chart.roundedBarCharts.js') }}"></script>
    <script src="{{ asset('js/global.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.6/dist/loadingoverlay.min.js'>
    </script>
    <!-- jQuery -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $("._nav-link").on('click', function() {
                link = $(this).attr('_link');
                ceklink = $(this).attr('_ceklink');
                if (ceklink == "paketsayaktg") {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "POST",
                        dataType: "JSON",
                        url: "{{ url('cekujian') }}",
                        data: "id=0",
                        // contentType: false,
                        // processData: false,
                        beforeSend: function() {
                            $.LoadingOverlay("show", {
                                image: "{{ asset('/image/global/loading.gif') }}"
                            });
                        },
                        success: function(response) {
                            if (response.status === true) {
                                window.location.href = '{{ url('paketsayaktg') }}';
                                return false;
                            } else {
                                Swal.fire({
                                    icon: 'warning',
                                    html: response.message,
                                    showDenyButton: true,
                                    showCancelButton: true,
                                    confirmButtonText: 'Lanjutkan',
                                    cancelButtonText: 'Batal',
                                    denyButtonText: 'Selesaikan Ujian',
                                }).then((result) => {
                                    /* Read more about isConfirmed, isDenied below */
                                    if (result.isConfirmed) {
                                        window.location.href = '{{ url('ujian') }}/' +
                                            response.idpaket;
                                    } else if (result.isDenied) {
                                        // Selesaikan Ujian
                                        idpaketmst = response.idpaket;
                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $(
                                                        'meta[name="csrf-token"]'
                                                    )
                                                    .attr('content')
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
                                            beforeSend: function() {
                                                $.LoadingOverlay("show", {
                                                    image: "{{ asset('/image/global/loading.gif') }}"
                                                });
                                            },
                                            success: function(response) {
                                                if (response.status) {
                                                    $('.modal').modal(
                                                        'hide');
                                                    Swal.fire({
                                                        html: response
                                                            .message,
                                                        icon: 'success',
                                                        showConfirmButton: true
                                                    }).then((
                                                        result) => {
                                                        $.LoadingOverlay(
                                                            "show", {
                                                                image: "{{ asset('/image/global/loading.gif') }}"
                                                            });
                                                        reload_url(
                                                            1500,
                                                            '{{ url('paketsayaktg') }}'
                                                        );
                                                    })
                                                } else {
                                                    Swal.fire({
                                                        html: response
                                                            .message,
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
                                        // Akhir Selesaikan Ujian
                                    }
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
                } else {
                    window.location.href = link;
                    return false;
                }
            });
        });
    </script>
    <!-- End custom js for this page-->
    @section('footer')
    @show
</body>

</html>
