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

                                <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('paketsayaktg') }}">Paket Saya</a></li>

                                <li class="breadcrumb-item active" aria-current="page">
                                    <a href="{{ url('paketsayasubktg') }}/{{ Crypt::encrypt($subkategori->fk_paket_kategori) }}">{{ $subkategori->kategori_r->judul }}</a>
                                </li>

                                <li class="breadcrumb-item active" aria-current="page">
                                        <a href="{{ url('paketsayasubktg') }}/{{ Crypt::encrypt($subkategori->id) }}">{{ $subkategori->judul }}</a>
                                </li>

                                @if($parents)
                                    @foreach($parents as $i=>$p)
                                    <li class="breadcrumb-item active" aria-current="page">
                                        <a href="{{ url('paketsayakategori') }}/{{ Crypt::encrypt($subkategori->id) }}/{{$i}}">{{ $p['name'] }}</a>
                                    </li>
                                    @endforeach                                
                                @endif
                            </ol>

                        </nav>

                        <p class="card-description">

                        <h3 class="font-weight-bold"><b>Pilih Paket</b></h3>

                        </p>

                        @php
                         $gratis = (isset($gratis) && $gratis) ? '/gratis' : '';
                        @endphp

                        <div class="row mt-4">
                            @if($paket || $kategoris)

                                @foreach($paket as $key)

                                    <div class="col-md-4 grid-margin stretch-card">

                                        <a href="{{ url('paketsayadetail') }}/{{ Crypt::encrypt($key->id) }}{{$gratis}}" class="hrefpaket">

                                            <div class="card card-border">                                        

                                                <div class="card-body">

                                                    <div class="row align-items-center mb-3"

                                                        style="flex-wrap: nowrap !important;">

                                                        <div class="col-2">

                                                            <div class="icon-card bg-blue rounded-circle iconpaket">

                                                                <i class="p-2 ti-layers-alt"></i>

                                                            </div>

                                                        </div>

                                                        <div class="col-8">

                                                            <h4 class="fs-6 mb-0"><b>{{ $key->judul }}</b></h4>

                                                            

                                                        </div>

                                                    </div>

                                                    <div class="mt-3 mb-3">

                                                        @php

                                                            $cekdata = App\Models\Transaksi::where('fk_user_id', Auth::id())

                                                                ->where('status', 1)

                                                                ->where('aktif_sampai', '>=', Carbon\Carbon::now())

                                                                ->orderBy('aktif_sampai', 'desc')

                                                                ->first();

                                                        @endphp

                                                        <div class="text-xs fw-500" style="color:#555">Berlaku hingga:</div>

                                                        <div class="fw-600 text-sm">{{ tglIndo($cekdata->aktif_sampai) }}</div>

                                                    </div>

                                                    <button

                                                        class="hrefpaket btn btn-primary bg-green text-white rounded-pill d-flex align-items-center justify-content-center">Mulai

                                                        Belajar</button>

                                                </div>

                                            </div>

                                        </a>

                                    </div>
                                @endforeach

                                @foreach($kategoris as $kid=>$kat)

                                    <div class="col-md-4 grid-margin stretch-card">

                                        <a href="{{ url('paketsayakategori') }}/{{ Crypt::encrypt($subkategori->id) }}/{{$kid}}" class="hrefpaket">

                                            <div class="card card-border">                                        

                                                <div class="card-body">

                                                    <div class="row align-items-center mb-3"

                                                        style="flex-wrap: nowrap !important;">

                                                        <div class="col-2">

                                                            <div class="icon-card bg-blue rounded-circle iconpaket">

                                                                <i class="p-2 ti-layers-alt"></i>

                                                            </div>

                                                        </div>

                                                        <div class="col-8">

                                                            <h4 class="fs-6 mb-0"><b>{{ $kat['name'] }}</b></h4>

                                                            

                                                        </div>

                                                    </div>

                                                    <div class="mt-3 mb-3">

                                                    </div>

                                                    <button

                                                        class="hrefpaket btn btn-primary bg-green text-white rounded-pill d-flex align-items-center justify-content-center">Pilih Paket <i class="ti-arrow-right ms-2" style="font-size: 10pt;"></i></button>

                                                </div>

                                            </div>

                                        </a>

                                    </div>

                                @endforeach

                            @else

                                <center><img class="mb-3 img-no" src="{{ asset('image/global/no-paket.png') }}"

                                        alt=""></center>

                                <br>

                                <center>Belum Ada Data</center>

                            @endif

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



        });

    </script>

    <!-- Loading Overlay -->

@endsection

