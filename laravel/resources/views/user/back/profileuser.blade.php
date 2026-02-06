@extends('layouts.Skydash')
<!-- partial -->
@section('content')
    <style>
        .select2-container--default .select2-selection--single {
            border: 1px solid #CED4DA !important;
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            padding-left: 0px !important;
        }

        .custom-file-label {
            padding: 0.375rem 20px;
        }

        .akun-saya .nav-item {
            width: 100%;
            margin-right: 0px;
        }

        .akun-saya .nav-item .btn {
            text-align: left;
            border-radius: 0px;
            border: 0px;
            padding: 1rem 1.75rem;
        }

        .akun-saya .nav-pills {
            border-bottom: unset;
        }

        .akun-saya .nav-link.active {
            background: #e2f8f7 !important;
            color: #49c1bf !important;
            font-weight: bold;
        }

        .akun-saya .nav-link:hover {
            background: #e2f8f7 !important;
            color: #49c1bf !important;

        }

        .akun-saya .nav-link:focus {
            box-shadow: unset !important;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- DatePicker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.2.3/flatpickr.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.2.3/themes/dark.css">

    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="cardx card-border w-100">
                    <div class="card-bodyx">
                        <!--<nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ url('home') }}"><i class="fas fa-home"></i></a></li>
                  <li class="breadcrumb-item active" aria-current="page">Akun Saya</li>
                </ol>
              </nav>-->
                        <p class="card-description">
                            <!--<h3 class="font-weight-bold mb-3"><b>Akun Saya</b></h3>-->
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <div class="card card-border profile-cover">
                                    <div class="card-body">
                                        <div class="d-flex align-items-end" style="">
                                            <a target="_blank"
                                                href="{{ Auth::user()->photo ? asset(Auth::user()->photo) : asset('image/global/unknown_user.png') }}"><img
                                                    class="img-sm rounded-circle"
                                                    src="{{ Auth::user()->photo ? asset(Auth::user()->photo) : asset('image/global/unknown_user.png') }}"
                                                    alt="profile"></a>
                                            <div class="ms-4 pb-4">
                                                <h6 class="mb-1 fs-3 fw-bold text-white">{{ Auth::user()->name }}</h6>
                                                <div class=" mb-0 text-sm text-white">{{ Auth::user()->username }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3 mb-sm-0">
                                <div class="card card-border">
                                    <div class="card-body" style="padding: 0px;">

                                        <div class="akun-saya">
                                            <ul class="nav nav-pills py-3" role="tablist">
                                                <li class="nav-item">
                                                    <a class="btn btn-sm btn-light nav-link active" data-toggle="pill"
                                                        href="#akuntab"><i class="fa fa-address-book-o me-2"></i> Akun</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="btn btn-sm btn-light nav-link" data-toggle="pill"
                                                        href="#profiltab"><i class="fa fa-user-o me-2"></i> Profil</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="btn btn-sm btn-light nav-link" data-toggle="pill"
                                                        href="#passwordtab"><i class="ti-key me-2"></i> Ubah Password</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="btn btn-sm btn-light nav-link" data-toggle="pill"
                                                        href="#vouchertab"><i class="ti-credit-card me-2"></i> Voucher</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9 grid-margin transparent">
                                <div class="tab-content tab-hasil-ujian">
                                    <div id="akuntab" class="tab-pane active">
                                        <div class="card card-border w-100">
                                            <div class="card-header bg-white fw-bold py-3 fs-5">Detail Akun</div>
                                            <div class="card-body">
                                                <form id="formAkun" class="form-horizontal" method="post">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="name" class=""><b>Nama</b></label>
                                                        <input name="name" type="text" class="form-control"
                                                            id="name" placeholder="Nama"
                                                            value="{{ Auth::user()->name }}">
                                                    </div>
                                                    <div class="form-group"`>
                                                        <label for="username" class=""><b>Username/Email</b></label>
                                                        <input readonly type="text" name="username" class="form-control"
                                                            id="username" placeholder="Username"
                                                            value="{{ Auth::user()->username }}">
                                                    </div>
                                                    <button type="submit" class="btn btn-primary bg-blue text-white">Simpan
                                                        Perubahan</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="profiltab" class="tab-pane">
                                        <div class="card card-border w-100">
                                            <div class="card-header bg-white fw-bold py-3 fs-5">Detail Profil</div>
                                            <div class="card-body">
                                                <form id="formProfil" class="form-horizontal" method="post">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="no_wa"
                                                                    class=""><b>Telepon</b></label>
                                                                <input name="no_wa" type="text"
                                                                    class="form-control int" id="no_wa"
                                                                    placeholder="Telepon"
                                                                    value="{{ Auth::user()->no_wa }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="jurusan"
                                                                    class=""><b>Jurusan</b></label>
                                                                <input name="jurusan" type="text" class="form-control"
                                                                    id="jurusan" placeholder="Jurusan"
                                                                    value="{{ Auth::user()->jurusan }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="no_wa" class=""><b>Tanggal Lahir</b></label>
                                                        <input type="text" class="form-control" name="ttl"
                                                            id="ttl" placeholder="Tanggal Lahir"
                                                            value="{{ tglEdit(Auth::user()->ttl) }}">
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="no_wa"
                                                                    class=""><b>Provinsi</b></label><br>
                                                                <select class="form-control form-control-lg _select2"
                                                                    id="provinsi" name="provinsi" style="width:100%">
                                                                    <option value=""></option>
                                                                    @foreach ($provinsi as $data)
                                                                        <option value="{{ $data->id_prov }}"
                                                                            {{ Auth::user()->provinsi == $data->id_prov ? 'selected' : '' }}>
                                                                            {{ $data->nama }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="no_wa"
                                                                    class=""><b>Kabupaten</b></label><br>
                                                                <select class="form-control form-control-lg _select2"
                                                                    id="kabupaten" name="kabupaten" style="width:100%">
                                                                    @php
                                                                        $kab = App\Models\MasterKabupaten::where(
                                                                            'id_prov',
                                                                            Auth::user()->provinsi,
                                                                        )->get();
                                                                    @endphp
                                                                    <option value=""></option>
                                                                    @foreach ($kab as $data)
                                                                        <option value="{{ $data->id_kab }}"
                                                                            {{ Auth::user()->kabupaten == $data->id_kab ? 'selected' : '' }}>
                                                                            {{ ucwords(strtolower($data->nama)) }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="no_wa"
                                                                    class=""><b>Kecamatan</b></label><br>
                                                                <select class="form-control form-control-lg _select2"
                                                                    id="kecamatan" name="kecamatan" style="width:100%">
                                                                    @php
                                                                        $kec = App\Models\MasterKecamatan::where(
                                                                            'id_kab',
                                                                            Auth::user()->kabupaten,
                                                                        )->get();
                                                                    @endphp
                                                                    <option value=""></option>
                                                                    @foreach ($kec as $data)
                                                                        <option value="{{ $data->id_kec }}"
                                                                            {{ Auth::user()->kecamatan == $data->id_kec ? 'selected' : '' }}>
                                                                            {{ $data->nama }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="jenis_kelamin" class="">Jenis
                                                                    Kelamin</label>
                                                                <select class="form-control" id="jenis_kelamin"
                                                                    name="jenis_kelamin" style="width:100%">
                                                                    <option value="">-- Pilih Jenis Kelamin --
                                                                    </option>
                                                                    <option
                                                                        {{ Auth::user()->jenis_kelamin == 'l' ? 'selected' : '' }}
                                                                        value="l">Laki-laki</option>
                                                                    <option
                                                                        {{ Auth::user()->jenis_kelamin == 'p' ? 'selected' : '' }}
                                                                        value="p">Perempuan</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="">Photo <span
                                                                class="input-keterangan">(jpg/jpeg/png)</span></label>
                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                                <input type="file" class="input-foto" id="photo"
                                                                    name="photo" idlabel="label-photo">
                                                                <label id="label-photo" class="custom-file-label"
                                                                    style="border-radius: .25rem;" for="photo">Choose
                                                                    file</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="pendidikan" class=""><b>Pendidikan</b></label>
                                                        <textarea name="pendidikan" class="form-control" cols="30" rows="10" placeholder="Pendidikan">{{ Auth::user()->pendidikan }}</textarea>
                                                    </div>

                                                    <button type="submit"
                                                        class="btn btn-primary bg-blue text-white">Simpan
                                                        Perubahan</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="passwordtab" class="tab-pane">
                                        <div class="card card-border w-100">
                                            <div class="card-header bg-white fw-bold py-3 fs-5">Ubah Password</div>
                                            <div class="card-body">
                                                <form method="post" id="formPassword" class="form-horizontal">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="password" class=""><b>Password
                                                                Sekarang</b></label>
                                                        <div class="input-group">
                                                            <input type="password" class="form-control" id="password"
                                                                name="password" placeholder="Password Sekarang"
                                                                style="border-top-right-radius:0px !important;border-bottom-right-radius:0px !important">
                                                            <div class="input-group-append showpassword"
                                                                idpassword="password">
                                                                <span class="input-group-text"><i id="iconpassword"
                                                                        class="icon-circle-minus"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="passwordbaru" class=""><b>Password
                                                                Baru</b></label>
                                                        <div class="input-group">
                                                            <input type="password" class="form-control" id="passwordbaru"
                                                                name="passwordbaru" placeholder="Password Baru"
                                                                style="border-top-right-radius:0px !important;border-bottom-right-radius:0px !important">
                                                            <div class="input-group-append showpassword"
                                                                idpassword="passwordbaru">
                                                                <span class="input-group-text"><i id="iconpasswordbaru"
                                                                        class="icon-circle-minus"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="ulangipassword" class=""><b>Ulangi Password
                                                                Baru</b></label>
                                                        <div class="input-group">
                                                            <input type="password" class="form-control"
                                                                name="ulangipassword" id="ulangipassword"
                                                                placeholder="Ulangi Password Baru"
                                                                style="border-top-right-radius:0px !important;border-bottom-right-radius:0px !important">
                                                            <div class="input-group-append showpassword"
                                                                idpassword="ulangipassword">
                                                                <span class="input-group-text"><i id="iconulangipassword"
                                                                        class="icon-circle-minus"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="submit"
                                                        class="btn btn-primary bg-blue text-white">Simpan
                                                        Perubahan</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="vouchertab" class="tab-pane">
                                        <div class="card card-border w-100">
                                            <div class="card-header bg-white fw-bold py-3 fs-5">Voucher</div>
                                            <div class="card-body">
                                                <div class="accordion accordion-multi-colored" id="accordion"
                                                    role="tablist">
                                                    @forelse($voucher as $key)
                                                        <div class="card">
                                                            <div class="card-header p-3 bg-green" role="tab"
                                                                id="heading-{{ $key->id }}">
                                                                <h6 class="mb-0">
                                                                    <a class="collapsed text-white"
                                                                        data-bs-toggle="collapse"
                                                                        href="#collapse-{{ $key->id }}"
                                                                        aria-expanded="false"
                                                                        aria-controls="collapse-{{ $key->id }}">
                                                                        <b
                                                                            style="font-size:30px;font-weight:bold">{{ $key->kode }}</b>
                                                                        (Voucher promo
                                                                        {{ $key->tipe == 1 ? formatRupiah($key->jumlah) : $key->jumlah . '%' }})
                                                                    </a>
                                                                </h6>
                                                            </div>
                                                            <div id="collapse-{{ $key->id }}"
                                                                class="collapse bg-green text-white" role="tabpanel"
                                                                aria-labelledby="heading-{{ $key->id }}"
                                                                data-parent="#accordion" style="">
                                                                <div class="card-body">
                                                                    {{ $key->ket }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @empty
                                                        <center><img class="mb-3 img-no"
                                                                src="{{ asset('image/global/no-voucher.png') }}"
                                                                alt=""></center>
                                                        <br>
                                                        <center>Tidak ada voucher promo yang tersedia</center>
                                                    @endforelse
                                                </div>
                                            </div>
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
@endsection

@section('footer')
    <!-- jQuery -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jquery-validation -->
    <script src="{{ asset('layout/adminlte3/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('layout/adminlte3/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <!-- Custom Input File -->
    <script src="{{ asset('layout/adminlte3/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!--  Flatpickr  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.2.3/flatpickr.js"></script>

    <script>
        $(document).ready(function() {

            bsCustomFileInput.init();

            $("#ttl").flatpickr({
                dateFormat: "d-m-Y",
                disableMobile: "true"
            });

            $('#jenis_kelamin').select2({
                placeholder: "Jenis Kelamin"
            });

            getKabupaten('provinsi', 'kabupaten', 'kecamatan', '{{ url('/getKabupaten') }}',
                '{{ asset('/image/global/loading.gif') }}');
            getKecamatan('kabupaten', 'kecamatan', '{{ url('/getKecamatan') }}',
                '{{ asset('/image/global/loading.gif') }}');

            $(".int").on('input paste', function() {
                hanyaAngka(this);
            });

            $(".showpassword").click(function() {
                var idpassword = $(this).attr('idpassword');
                var typepassword = $("#" + idpassword).attr('type');
                if (typepassword == "password") {
                    $("#" + idpassword).attr('type', 'text');
                    $("#icon" + idpassword).attr('class', 'icon-eye');
                } else {
                    $("#" + idpassword).attr('type', 'password');
                    $("#icon" + idpassword).attr('class', 'icon-circle-minus');
                }
            });

            $(document).on('change', '.input-foto', function(e) {
                var idphoto = $(this).attr('id');
                onlyPhoto(idphoto);
            });

            $('#formAkun').validate({
                rules: {
                    name: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: "Nama tidak boleh kosong"
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

                    var formData = new FormData($('#formAkun')[0]);

                    var url = "{{ url('/updateUserAkun') }}";
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
                        },
                        success: function(response) {
                            if (response.status == true) {
                                Swal.fire({
                                    html: response.message,
                                    icon: 'success',
                                    showConfirmButton: false
                                });
                                reload(1000);
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
                            // $.LoadingOverlay("hide");
                        }
                    });

                }

            });

            $('#formProfil').validate({
                rules: {
                    name: {
                        required: true
                    },
                    // no_wa :{
                    //   required:true
                    // },
                    // provinsi :{
                    //   required:true
                    // },
                    // kabupaten :{
                    //   required:true
                    // },
                    // kecamatan :{
                    //   required:true
                    // },
                    jenis_kelamin: {
                        required: true
                    },
                    photo: {
                        extension: "jpeg|jpg|png"
                    },
                },
                messages: {
                    jenis_kelamin: {
                        required: "Jenis Kelamin tidak boleh kosong"
                    },
                    name: {
                        required: "Nama tidak boleh kosong"
                    },
                    // no_wa : {
                    //   required: "Telepon tidak boleh kosong"
                    // },
                    // provinsi : {
                    //   required: "Provinsi tidak boleh kosong"
                    // },
                    // kabupaten : {
                    //   required: "Kabupaten tidak boleh kosong"
                    // },
                    // kecamatan : {
                    //   required: "Kecamatan tidak boleh kosong"
                    // },
                    photo: {
                        extension: "Masukkan format file yang sesuai"
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

                    var formData = new FormData($('#formProfil')[0]);

                    var url = "{{ url('/updateUserProfil') }}";
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
                        },
                        success: function(response) {
                            if (response.status == true) {
                                Swal.fire({
                                    html: response.message,
                                    icon: 'success',
                                    showConfirmButton: false
                                });
                                reload(1000);
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
                            // $.LoadingOverlay("hide");
                        }
                    });

                }

            });


            $('#formPassword').validate({
                rules: {
                    password: {
                        // required: true
                    },
                    passwordbaru: {
                        required: true,
                        minlength: 4,
                    },
                    ulangipassword: {
                        required: true,
                        equalTo: "#passwordbaru"
                    },
                },
                messages: {
                    password: {
                        required: "Password sekarang tidak boleh kosong"
                    },
                    passwordbaru: {
                        required: "Password baru tidak boleh kosong",
                        minlength: "Minimal 4 character"
                    },
                    ulangipassword: {
                        required: "Ulangi password baru tidak boleh kosong",
                        equalTo: "Harus sama dengan password baru"
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

                    var formData = new FormData($('#formPassword')[0]);

                    var url = "{{ url('/updateUserPassword') }}";
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
                        },
                        success: function(response) {
                            if (response.status == true) {
                                Swal.fire({
                                    html: response.message,
                                    icon: 'success',
                                    showConfirmButton: false
                                });
                                reload(1000);
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
                            // $.LoadingOverlay("hide");
                        }
                    });
                }
            });

        });

        $(document).ready(function() {
            var hash = window.location.hash;
            if (hash && $(hash).length) { // Memastikan elemen dengan ID hash ada
                $('a[data-toggle="tab"]').removeClass('active');
                $('.tab-pane').removeClass('active show');
                $('a[href="' + hash + '"]').tab('show');
                $(hash).addClass('active show'); // Mengaktifkan tab pane
            }
        });
    </script>
    <!-- Loading Overlay -->
@endsection
