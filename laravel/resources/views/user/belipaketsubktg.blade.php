@extends('layouts.Skydash')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="cardx card-border w-100">
                    <div class="card-bodyx">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('home') }}"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page"><a
                                        href="{{ url('belipaketktg') }}">Beli Paket</a></li>
                            </ol>
                        </nav>
                        <div class="row" style="align-items:center">
                            <div class="col-md-3 col-lg-3">
                                <div class="mb-3 mt-3 mb-md-0 mt-md-0">
                                    <input type="text" class="form-control" id="cari" placeholder="Cari"
                                        name="cari">
                                </div>
                            </div>
                        </div>
                        <div id="dataarea" class="row mt-4">
                            @forelse($subkategori as $key)
                                <div class="col-md-4 mb-4 stretch-card">
                                    <div class="card">
                                        <div class="card-body py-3 px-3">
                                            <div class="row mb-3 align-items-center" style="flex-wrap: nowrap !important;">
                                                <div class="col-2">
                                                    <div class="icon-card bg-blue rounded-circle iconpaket">
                                                        <i class="p-2 ti-layers-alt"></i>
                                                    </div>
                                                </div>
                                                <div class="col-8">
                                                    <h4 class="fs-6 mb-0 text-white"><b>{{ $key->judul }}</b></h4>
                                                    <div class="text-sm mt-2">{{ $key->ket }}</div>
                                                </div>
                                                <div class="col-auto ps-0 align-self-start">
                                                    <div class="rounded-1 px-1 py-1 bg-lightgreen text-balck text-xs"
                                                        style="font-size: 9pt;">Tersedia</div>
                                                </div>
                                            </div>

                                            <a href="{{ url('belipaket') }}/{{ Crypt::encrypt($key->id) }}"
                                                class="hrefpaket btn btn-primary bg-green text-white rounded-pill d-flex align-items-center justify-content-center">Pilih
                                                Paket <i class="ti-arrow-right ms-2" style="font-size: 10pt;"></i></a>
                                        </div>
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
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <!-- SweetAlert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
        $(document).ready(function() {
            $("#cari").on('input paste', function() {
                datacari = $(this).val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: "{{ url('caripaketsubktg') }}",
                    // async: false,
                    data: {
                        datacari: datacari,
                    },
                    beforeSend: function() {
                        // $.LoadingOverlay("show", {
                        //     image       : "{{ asset('/image/global/loading.gif') }}"
                        // });
                        $("#dataarea").LoadingOverlay("show", {
                            image: "{{ asset('/image/global/loading.gif') }}"
                        });
                    },
                    success: function(response) {
                        if (response.status) {
                            $("#dataarea").html(response.data);
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
                        $("#dataarea").LoadingOverlay("hide");
                    }
                });
            });
        });
    </script>
    <!-- Loading Overlay -->
@endsection
