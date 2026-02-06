@extends('layouts.Skydash')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card card-border">
                    <div class="card-body">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item text-white"><a href="{{ url('home') }}"><i
                                            class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item active text-white" aria-current="page">Paket Saya</li>
                            </ol>
                        </nav>
                        <p class="card-description">
                        <h3 class="font-weight-bold text-white"><b>Pilih Kategori Paket Belajar</b></h3>
                        </p>
                        @php
                            $gratis = isset($gratis) && $gratis ? '/gratis' : '';
                        @endphp

                        <div class="row mt-4">
                            @foreach ($kategori as $key)
                                <div class="col-md-6 grid-margin stretch-card">
                                    <a href="{{ url('paketsayadetail') }}/{{ Crypt::encrypt($key->id) }}{{ $gratis }}"
                                        class="hrefpaket">
                                        <div class="card card-border" style="height: 100%; border: 1px solid #114e83;">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <i class="p-2 ti-layers-alt iconpaket"></i>
                                                    </div>
                                                    <div class="col-6 text-right">
                                                        <i class="ti-arrow-top-right"></i>
                                                    </div>
                                                </div>
                                                <div class="mt-4">
                                                    <h4 class="text-white"><b>{{ $key->judul }}</b></h4>
                                                    <h6 class="text-white">{!! $key->ket !!}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                            <div class="col-md-6 grid-margin stretch-card">
                                <a href="{{ url('paketgratis') }}" class="hrefpaket">
                                    <div class="card card-border" style="height: 100%; border: 1px solid #114e83;">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-6">
                                                    <i class="p-2 ti-layers-alt iconpaket"></i>
                                                </div>
                                                <div class="col-6 text-right">
                                                    <i class="ti-arrow-top-right"></i>
                                                </div>
                                            </div>
                                            <div class="mt-4">
                                                <h4 class="text-white"><b>Paket Gratis</b></h4>
                                                <h6></h6>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
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
            $(document).on('click', '.btn-kerjakan', function(e) {

            });
        });
    </script>
    <!-- Loading Overlay -->
@endsection
