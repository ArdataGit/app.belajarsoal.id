@extends('layouts.Adminlte3')

@section('header')
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('layout/adminlte3/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('layout/adminlte3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('layout/adminlte3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('layout/adminlte3/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('layout/adminlte3/dist/css/adminlte.min.css') }}">

@endsection

@section('contentheader')
    <h1 class="m-0">FAQ</h1>
@endsection

@section('contentheadermenu')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">List FAQ</li>
    </ol>
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- <div class="card-header">
                                                                                <h3 class="card-title">Foto Beranda</h3>
                                                                              </div> -->
                        <!-- /.card-header -->
                        <div class="card-body">
                            <span data-toggle="tooltip" data-placement="left" title="Tambah Data">
                                <button data-toggle="modal" data-target="#modal-tambah" type="button"
                                    class="btn btn-sm btn-primary btn-add-absolute">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                </button>
                            </span>
                            <!-- <button data-toggle="modal" data-target="#modal-tambah" type="button" class="btn btn-md btn-primary btn-absolute">Tambah</button> -->
                            <table id="tabledata" class="table  table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Pertanyaan</th>
                                        <th>Jawaban</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $key)
                                        <tr>
                                            <td width="1%">{{$loop->iteration}}</td>
                                            <td width="15%">{{$key->question}}</td>
                                            <td class="_align_center">{!! $key->answer !!}</td>
                                            <td width="1%" class="_align_center">
                                                <div class="btn-group">
                                                    <span data-toggle="tooltip" data-placement="left" title="Ubah Data">
                                                        <button data-toggle="modal" data-target="#modal-edit-{{$key->id}}"
                                                            type="button" class="btn btn-sm btn-outline-warning"><i
                                                                class="fas fa-edit"></i></button>
                                                    </span>
                                                    <span data-toggle="tooltip" data-placement="left" title="Hapus Data">
                                                        <button data-toggle="modal" data-target="#modal-hapus-{{$key->id}}"
                                                            type="button" class="btn btn-sm btn-outline-danger"><i
                                                                class="far fa-trash-alt"></i></button>
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    @foreach($data as $key)
        <!-- Modal Edit -->
        <div class="modal fade" id="modal-edit-{{$key->id}}">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Ubah Data</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" id="formData_{{$key->id}}" class="form-horizontal">
                        @csrf
                        <input type="hidden" value="{{$key->id}}" name="iddata[]">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="question_{{$key->id}}">Pertanyaan<span class="bintang">*</span></label>
                                <input type="text" class="form-control" id="question_{{$key->id}}" name="question[]"
                                    placeholder="Pertanyaan" value="{{$key->question}}">
                            </div>

                            <div class="form-group">
                                <label for="answer_{{$key->id}}">Jawaban<span class="bintang">*</span></label>
                                <textarea name="answer[]" id="answer_{{$key->id}}" rows="5" class="form-control content_"
                                    placeholder="Jawaban">{{$key->answer}}</textarea>
                            </div>

                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                            <label class="ket-bintang">Bertanda <span class="bintang">*</span> Wajib diisi</label>
                            <button type="submit" class="btn btn-danger btn-submit-data" idform="{{$key->id}}">Simpan</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal edit -->

        <!-- Modal Hapus -->
        <div class="modal fade" id="modal-hapus-{{$key->id}}">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Konfirmasi</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" id="formHapus_{{$key->id}}" class="form-horizontal">
                        @csrf
                        <input type="hidden" value="{{$key->id}}" name="iddata[]">
                        <div class="modal-body">
                            <h6> Apakah anda ingin menghapus faq {{$key->judul}}?</h6>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-danger btn-hapus" idform="{{$key->id}}">Hapus</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.Modal Hapus -->
    @endforeach

    <!-- Modal Tambah -->
    <div class="modal fade" id="modal-tambah">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="_formData" class="form-horizontal">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" value="1" name="jenis_add" id="jenis_add">
                        <div class="form-group">
                            <label for="question_add">Pertanyaan<span class="bintang">*</span></label>
                            <input type="text" class="form-control" id="question_add" name="question_add"
                                placeholder="Pertanyaan">
                        </div>

                        <div class="form-group">
                            <label for="answer_add">Jawaban<span class="bintang">*</span></label>
                            <textarea name="answer_add" id="answer_add" rows="5" class="form-control content_"
                                placeholder="Jawaban"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <label class="ket-bintang">Bertanda <span class="bintang">*</span> Wajib diisi</label>
                        <button type="submit" class="btn btn-danger">Simpan</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal edit -->

@endsection

@section('footer')
    <!-- Custom Input File -->
    <script src="{{ asset('layout/adminlte3/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <!-- jQuery -->
    <script src="{{ asset('layout/adminlte3/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('layout/adminlte3/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- jquery-validation -->
    <script src="{{ asset('layout/adminlte3/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('layout/adminlte3/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('layout/adminlte3/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('layout/adminlte3/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('layout/adminlte3/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('layout/adminlte3/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('layout/adminlte3/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('layout/adminlte3/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('layout/adminlte3/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('layout/adminlte3/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('layout/adminlte3/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('layout/adminlte3/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('layout/adminlte3/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('layout/adminlte3/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('layout/adminlte3/dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('layout/adminlte3/dist/js/demo.js') }}"></script>
    <!-- Page specific script -->
    <!-- DatePicker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.2.3/flatpickr.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.2.3/themes/dark.css">
    <!--  Flatpickr  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.2.3/flatpickr.js"></script>

    <!-- Tinymce -->

    <script src="{{ asset('plugins/ckeditor/ckeditor.js') }}" referrerpolicy="origin"></script>


    <script>
        $(document).ready(function () {


            $('.content_').each(
                function () {
                    CKEDITOR.replace($(this).attr('id'));
                }
            );

            bsCustomFileInput.init();

            $(document).on('change', '.input-foto', function (e) {
                var idphoto = $(this).attr('id');
                onlyPhoto(idphoto);
            });

            // $(".hide").hide();

            // $(document).on('change', '.tipe', function (e) {
            //     jenis = $(this).val();
            //     attrjns = $(this).attr('attrjns');
            //     $(".harga_"+attrjns).hide();
            //     $(".persen_"+attrjns).hide();
            //     if(jenis==1){
            //       $(".harga_"+attrjns).show();
            //     }else{
            //       $(".persen_"+attrjns).show();
            //     }
            // });

            // $(document).on('change', '.jenis', function (e) {
            //     jenis = $(this).val();
            //     attrjns = $(this).attr('attrjns');
            //     $(".user_"+attrjns).hide();
            //     if(jenis==2){
            //       $(".user_"+attrjns).show();
            //     }
            // });

            $(".int").on('input paste', function () {
                hanyaInteger(this);
            });

            $(".angkabesar").on('input paste', function () {
                hanyaAngkaAndBesar(this);
            });
            // bsCustomFileInput.init();
            tableinformasi("tabledata");

            //Initialize Select2 Elements

            // $('.mapel').select2({
            //   placeholder: "Pilih Mapel"
            // });

            $('.jenis').select2({
                placeholder: "Pilih Jenis"
            });
            $('.user').select2({
                placeholder: "Pilih User"
            })

            // $('#jenis_soal_add').on('select2:select', function (e) {
            //     var val = $(this).val();
            //     $.ajaxSetup({
            //         headers: {
            //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //         }
            //     });
            //     $.ajax({
            //         url: '{{url("getPaketSoal")}}',
            //         type: 'POST',
            //         dataType: "JSON",
            //         data: {
            //             "val":val
            //         },
            //         beforeSend: function () {
            //             $.LoadingOverlay("show", {
            //                 image       : "{{asset('/image/global/loading.gif')}}"
            //             });
            //         },
            //         success: function (response) {
            //             if (response.status == true) {

            //                 $("#fk_paket_soal_mst_add").html("");
            //                 var newOption = new Option('', '', false, false);
            //                 $("#fk_paket_soal_mst_add").append(newOption).trigger('change');
            //                 $("#fk_paket_soal_mst_add").attr("data-placeholder","Paket Soal");

            //                 $("#fk_paket_soal_mst_add").select2({
            //                     data: response.datapaket
            //                 });
            //             }else{
            //                 Swal.fire({
            //                     title: "Error!!!",
            //                     icon: 'error',
            //                     confirmButtonText: 'Ok'
            //                 });
            //             }
            //         },
            //         error: function (xhr, status) {
            //             alert('Error!!!');
            //         },
            //         complete: function () {
            //             $.LoadingOverlay("hide");
            //         }
            //     });
            // });

            // $(document).on('change', '.input-photo', function (e) {
            //     var idphoto = $(this).attr('id');
            //     onlyPhoto(idphoto);
            // });

            //Fungsi Hapus Data
            $(document).on('click', '.btn-hapus', function (e) {
                idform = $(this).attr('idform');
                var formData = new FormData($('#formHapus_' + idform)[0]);

                var url = "{{ url('/hapusfaq') }}";
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
                    beforeSend: function () {
                        $.LoadingOverlay("show");
                    },
                    success: function (response) {
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
                    error: function (xhr, status) {
                        alert('Error!!!');
                    },
                    complete: function () {
                        $.LoadingOverlay("hide");
                    }
                });
            });


            // Fungsi Ubah Data
            $(document).on('click', '.btn-submit-data', function (e) {
                idform = $(this).attr('idform');
                $('#formData_' + idform).validate({
                    ignore: ".ignore",
                    rules: {
                        'question[]': {
                            required: true
                        },
                        'answer[]': {
                            required: true
                        }
                    },
                    messages: {
                        'question[]': {
                            required: "Pertanyaan tidak boleh kosong"
                        },
                        'answer[]': {
                            required: "Jawaban tidak boleh kosong"
                        }
                    },
                    errorElement: 'span',
                    errorPlacement: function (error, element) {
                        error.addClass('invalid-feedback');
                        element.closest('.form-group').append(error);
                    },
                    highlight: function (element, errorClass, validClass) {
                        $(element).addClass('is-invalid');
                    },
                    unhighlight: function (element, errorClass, validClass) {
                        $(element).removeClass('is-invalid');
                    },

                    submitHandler: function () {

                        var formData = new FormData($('#formData_' + idform)[0]);

                        var url = "{{ url('/updatefaq') }}";
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
                            beforeSend: function () {
                                $.LoadingOverlay("show");
                            },
                            success: function (response) {
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

            // Fungsi Add Data
            $('#_formData').validate({
                ignore: ".ignore",
                rules: {
                    question_add: {
                        required: true
                    },
                    answer_add: {
                        required: true
                    },
                },
                messages: {
                    question_add: {
                        required: "Pertanyaan tidak boleh kosong"
                    },
                    answer_add: {
                        required: "Jawaban tidak boleh kosong"
                    }
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    if (element.hasClass('_select2')) {
                        element.parent().addClass('select2-error');
                        error.addClass('invalid-feedback');
                        element.closest('.form-group').append(error);
                    } else {
                        error.addClass('invalid-feedback');
                        element.closest('.form-group').append(error);
                    }
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                    if (element.tagName.toLowerCase() == 'select') {
                        var x = element.getAttribute('id');
                        y = $('#' + x).parent().addClass('select2-error');
                    }
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                    if (element.tagName.toLowerCase() == 'select') {
                        var x = element.getAttribute('id');
                        y = $('#' + x).parent().removeClass('select2-error');
                    }
                },

                submitHandler: function () {

                    var formData = new FormData($('#_formData')[0]);

                    var url = "{{ url('storefaq') }}";
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
                        beforeSend: function () {
                            $.LoadingOverlay("show");
                        },
                        success: function (response) {
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
    </script>

@endsection