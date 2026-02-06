@extends('layouts.Skydash')

@section('content')

    @php
        if (app('request')->input('tab')) {
            $tab = app('request')->input('tab');
        } else {
            // Tentukan tab default berdasarkan ketersediaan data
            if (count($paketvideo) > 0 || count($paketpdf) > 0) {
                $tab = 'pembelajaran';
            } elseif (count($paketzoom) > 0) {
                $tab = 'zoom';
            } elseif (count($paketdtl) > 0) {
                $tab = 'latihan';
            } else {
                $tab = 'pembelajaran'; // Atau tab lain yang sesuai
            }
        }
    @endphp

    <style>
        a:hover {
            text-decoration: none;
        }

        .sidebar-offcanvas {
            z-index: 10 !important;
        }

        .fullwidth {
            width: 100% !important;
        }

        .mainkat {
            margin: 0 -1.5rem !important;
            padding: 0 !important;
        }

        .mainkat li>ul {
            margin: 0 !important;
            padding: 0 !important;
        }

        .md-4 {
            width: 100%;
            /*margin: 0 !important;*/
            /*padding: 0 !important;*/
        }

        .md-4>div {
            width: 100%;
            margin: 0 !important;
        }

        @media (min-width: 768px) {
            .md-4 {
                width: 50%;
            }
        }

        @media (min-width: 1200px) {
            .md-4 {
                width: 30%;
            }
        }

        .btn-info {
            background-color: #1D6C2B;
        }

        .card {
            background-color: #1e1e2f;
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.25);
            margin-bottom: 1.5rem;
        }

        /* Card yang lebih kecil */
        .card.card-border {
            max-width: 350px;
            margin: auto;
        }

        .card-body {
            background-color: #1e1e2f;
            border: none;
            padding: 1.25rem;
        }

        body {
            background-color: #121212;
            color: #e0e0e0;
            font-family: 'Roboto', sans-serif;
        }

        .tab-hasil-ujian li {
            list-style: none;
        }

        .img-lock {
            width: 50px;
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
            padding: 12px;
        }

        .bg-primary-custom {
            background: #2b46bd;
        }
    </style>

    <script>
        kategoris = [];
        @php
            if ($kategoris) {
                echo '
                      katroot = [' .
                    implode(',', $kategoris[0]) .
                    '];
                      matkatbackid = 0;
                      zoomkatbackid = 0;
                      detailkatbackid = 0;
                      cermatkatbackid = 0;
                      ';

                foreach ($kategoris as $id => $kategori) {
                    if ($id) {
                        $parents = $kategori['parents'] ? implode(',', $kategori['parents']) : '';
                        $items = $kategori['items'] ? implode(',', $kategori['items']) : '';
                        echo '
                      kategoris[' .
                            $id .
                            '] = {
                      "root_id": ' .
                            $kategori['root_id'] .
                            ',
                      "parent_id": ' .
                            $kategori['parent_id'] .
                            ',
                      "name": "' .
                            $kategori['name'] .
                            '",
                      "parents": [' .
                            $parents .
                            '],
                      "items": [' .
                            $items .
                            ']
                      };';
                    }
                }
            }
        @endphp
    </script>


    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="cardx card-border w-100">
                    <div class="card-bodyx">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item text-white"><a href="{{ url('home') }}"><i
                                            class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item active text-white" aria-current="page"><a
                                        href="{{ url('paketsayaktg') }}">Paket Saya</a></li>

                            </ol>
                        </nav>
                        <p class="card-description">
                        <h3 class="font-weight-bold text-white">
                            <b>{{ optional($data)->judul }}</b>
                        </h3>
                        <h6 class="text-white">
                            {!! optional($data)->ket !!}
                        </h6>
                        </p>
                        <hr>
                        <div class="row mt-4">
                            <div class="col-lg-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <ul class="pb-0 nav nav-pills btn-menu-paket" role="tablist"
                                            style="border-bottom:unset">
                                            @if (count($paketvideo) > 0 || count($paketpdf) > 0)
                                                <li class="nav-item">
                                                    <a class="btn btn-sm btn-primary nav-link btn-tab-hasil {{ $tab == 'pembelajaran' ? 'active' : '' }}"
                                                        data-toggle="pill" href="#pembelajaran">Pembelajaran</a>
                                                </li>
                                            @endif

                                            @if (count($paketzoom) > 0)
                                                <li class="nav-item">
                                                    <a class="btn btn-sm btn-primary nav-link btn-tab-hasil {{ $tab == 'zoom' ? 'active' : '' }}"
                                                        data-toggle="pill" href="#zoom">Zoom</a>
                                                </li>
                                            @endif
                                            @if (count($paketdtl) > 0)
                                                <li class="nav-item">
                                                    <a class="btn btn-sm btn-primary nav-link btn-tab-hasil {{ $tab == 'latihan' ? 'active' : '' }}"
                                                        data-toggle="pill" href="#latihan">Tryout</a>
                                                </li>
                                            @endif
                                            @if (count($hasilujian) > 0)
                                                <li class="nav-item">
                                                    <a class="btn btn-sm btn-primary nav-link btn-tab-hasil {{ $tab == 'hasillatihan' ? 'active' : '' }}"
                                                        data-toggle="pill" href="#hasillatihan">Hasil Tryout</a>
                                                </li>
                                            @endif
                                            {{--
                                                                <li class="nav-item">
                                                                    <a class="btn btn-sm btn-primary nav-link btn-tab-hasil" href="{{url('userclass/'.Crypt::encrypt($data->id))}}">Class</a>
                                                                </li>
                                                                --}}
                                        </ul>
                                        <div class="tab-content tab-hasil-ujian">
                                            <!-- Button trigger modal -->
                                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                                            <div id="pembelajaran"
                                                class="tab-pane {{ $tab == 'pembelajaran' ? 'active' : '' }}">
                                                <hr>
                                                @if (count($paketvideo) > 0 || count($paketpdf) > 0)
                                                    @php
                                                        function matkats(&$kategoris, $matkats, $isroot)
                                                        {
                                                            foreach ($matkats as $id => $kat) {
                                                                if ($id && isset($kategoris[$id])) {
                                                                    $hide = $isroot ? '' : ' d-none';
                                                                    echo '
                                                                                        <li class="col-lg-4 col-sm-6" id="kat-' .
                                                                        $id .
                                                                        '" katid="' .
                                                                        $id .
                                                                        '">
                                                                                        <div class="stretch-card" style="width:100%;">
                                                                                            <div class="card card-border text-left" style="height: 100%; width:100%;">
                                                                                                <div class="card-body">

                                            <div class="mb-2" style="border: 1px solid #106571;border-radius:8px;overflow: hidden;">
                                            <div class="row align-items-center">
                                                                                                    <div class="col-3 bg-primary-custom" style="justify-content: center;padding-right:0px;display: flex;align-items: center;">

                                                                <img class="img-lock" src="https://apps.belajarsoal.id/image/global/lock-white.png" alt="">
                                                            </div>
                                                                                                    <div class="col-9">
                                                                                                        <h4 class="fs-6 mb-0 text-white"><b>' .
                                                                        $kategoris[$id]['name'] .
                                                                        '</b></h4>
                                                                                                        <h6>' .
                                                                        $kategoris[$id]['keterangan'] .
                                                                        '</h6>
                                                                                                    </div>
                                                                                                </div>
                                                                                                </div>
                                                                                                <button class="mt-2 btn btn-md btn-info btn-block btn-icon-text" onclick="matkatclick(' .
                                                                        $id .
                                                                        ');">Pilih</button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <ul class="row d-none" style="margin-left: -15px !important; margin-right: -15px !important">
                                                                                        ';

                                                                    matkats($kategoris, $kat, false);

                                                                    echo '
                                                                                        </ul>
                                                                                        </li>
                                                                                        ';
                                                                }
                                                            }
                                                            echo '<li class="d-block"></li>';
                                                            foreach ($matkats as $id => $kat) {
                                                                if (!$id || !isset($kategoris[$id])) {
                                                                    foreach ($kat as $m) {
                                                                        echo '
                                                                                            <li class="col-lg-4 col-sm-6">
                                                                                        ';
                                                                        if ($m->jenis == 1) {
                                                                            echo '
                                                                                            <div class="stretch-card" style="width:100%;">
                                                                                        <div class="card card-border text-left" style="height: 100%; width:100%;">
                                                                                            <div class="card-body">
                                                                                                <div class="row">
                                                                                                    <div class="col-1">
                                                                                                    </div>
                                                                                                    <div class="col-10">
                                                                                                        <div class="row"
                                                                                                            style="align-items: center">
                                                                                                            <div class="col-3"
                                                                                                                style="padding:0px">
                                                                                                                <img width="100%"
                                                                                                                    src="' .
                                                                                asset('image/global/img-video.png') .
                                                                                '"
                                                                                                                    alt="">
                                                                                                            </div>
                                                                                                            <div class="col-9">
                                                                                                                <h6 class="text-white">Video</h6>
                                                                                                                <h4 style="margin-bottom:0px">
                                                                                                                    <b class="text-white">' .
                                                                                $m->judul .
                                                                                '</b>
                                                                                                                </h4>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-1">
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="row">
                                                                                                    <div class="col-12">

                                                                                                        <button type="button"
                                                                                                            data-bs-toggle="modal"
                                                                                                            data-bs-target="#exampleModal' .
                                                                                $m->id .
                                                                                '"
                                                                                                            class="mt-2 btn btn-md btn-primary btn-block btn-icon-text">
                                                                                                            <i
                                                                                                                class="ti-control-play btn-icon-prepend"></i>
                                                                                                            Tonton
                                                                                                        </button>

                                                                                                        <!-- Modal -->
                                                                                                        <div class="modal fade"
                                                                                                            id="exampleModal' .
                                                                                $m->id .
                                                                                '"
                                                                                                            tabindex="-1"
                                                                                                            aria-labelledby="exampleModal' .
                                                                                $m->id .
                                                                                'Label"
                                                                                                            aria-hidden="true">
                                                                                                            <div class="modal-dialog modal-lg">
                                                                                                                <div class="modal-content">
                                                                                                                    <div class="modal-header">
                                                                                                                        <h5 class="modal-title"
                                                                                                                            id="exampleModalLabel">
                                                                                                                            ' .
                                                                                $m->judul .
                                                                                '
                                                                                                                        </h5>
                                                                                                                        <button type="button"
                                                                                                                            class="btn-close"
                                                                                                                            data-bs-dismiss="modal"
                                                                                                                            aria-label="Close"></button>
                                                                                                                    </div>
                                                                                                                    <div class="modal-body">
                                                                                                                        <iframe width="100%"
                                                                                                                            height="315"
                                                                                                                            src="https://youtube.com/embed/' .
                                                                                $m->link .
                                                                                '"
                                                                                                                            title="YouTube video player"
                                                                                                                            frameborder="0"
                                                                                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                                                                                            allowfullscreen></iframe>
                                                                                                                    </div>

                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>

                                                                                                        <script>
                                                                                                            $(document).ready(function() {
                                                                                                                $("#exampleModal' . $m->id . '").on("hidden.bs.modal", function() {
                                                                                                                    var iframe = $(this).find("iframe")[0];
                                                                                                                    var videoSrc = iframe.src;
                                                                                                                    iframe.src = videoSrc;
                                                                                                                });
                                                                                                            });
                                                                                                        </script>


                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                            ';
                                                                        } else {
                                                                            echo '

                                                                                                <div class="grid-margin stretch-card" style="width:100%;">
                                                                                        <div class="card card-border text-left" style="height: 100%; width:100%;">
                                                                                            <div class="card-body p-3">

                                                        <div class="mb-2" style="border: 1px solid #106571;border-radius:8px;overflow: hidden;">                                        <div class="row align-items-center"
                                                                                                    style="flex-wrap: nowrap !important;">
                                                                                                    <div class="col-3 bg-primary-custom" style="justify-content: center;padding-right:0px;display: flex;align-items: center;">

                                                                <img class="img-lock" src="https://apps.belajarsoal.id/image/global/lock-white.png" alt="">
                                                            </div>
                                                                                                    <div class="col-9">
                                                                                                        <h6 class="text-sm text-white">Materi
                                                                                                        </h6>
                                                                                                        <h4 class="fs-6 mb-0 text-white text-white">
                                                                                                            <b>' .
                                                                                $m->judul .
                                                                                '</b>
                                                                                                        </h4>
                                                                                                    </div>
                                                                                                </div>
                                                                                                </div>
                                                                                                <div class="row">
                                                                                                    <div class="col-12">
                                                                                                        <a target="_blank"
                                                                                                            href="' .
                                                                                asset($m->link) .
                                                                                '">
                                                                                                            <button type="button"
                                                                                                                class="rounded-pill btn btn-md btn-primary btn-block btn-icon-text">
                                                                                                                <i
                                                                                                                    class="fa fa-eye btn-icon-prepend"></i>
                                                                                                                Lihat Materi
                                                                                                            </button>
                                                                                                        </a>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                    ';
                                                                        }
                                                                        echo '
                                                                                        </li>
                                                                                        ';
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        echo '
                                                                            <ul class="mainkat row">
                                                                            <li class="px-4">
                                                                            <button style="width:50px;" class="mt-4 mb-4 btn btn-sm btn-info btn-icon-text d-none" id="matkatback" onclick="matkatback()"> <i class="ti ti-arrow-left"></i> </button>
                                                                            </li>
                                                                            ';
                                                        matkats($kategoris, $materi_kats, true);
                                                        echo '
                                                                            </ul>
                                                                            ';
                                                    @endphp
                                                @else
                                                    <center><img class="mb-3 img-no"
                                                            src="{{ asset('image/global/no-paket.png') }}" alt="">
                                                    </center>
                                                    <br>
                                                    <center class="text-white"">Belum Ada Data</center>
                                                @endif
                                            </div>

                                            <div id="latihan" class="tab-pane {{ $tab == 'latihan' ? 'active' : '' }}">
                                                <hr>
                                                @if (count($paketdtl) > 0)
                                                    @php
                                                        function detailkats(&$kategoris, $matkats, $isroot)
                                                        {
                                                            global $idpaketdtl;
                                                            foreach ($matkats as $id => $kat) {
                                                                if ($id && isset($kategoris[$id])) {
                                                                    $hide = $isroot ? '' : ' d-none';
                                                                    echo '
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <li class="col-lg-4 col-sm-6' .
                                                                        $hide .
                                                                        '" id="kat-' .
                                                                        $id .
                                                                        '" katid="' .
                                                                        $id .
                                                                        '">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <div class="stretch-card" style="width:100%">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <div class="card card-border text-left" style="height: 100%; width:100%;">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <div class="card-body">

                                    <div class="mb-2" style="border: 1px solid #106571;border-radius:8px;overflow: hidden;">                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <div class="row align-items-center">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <div class="col-3 bg-primary-custom" style="justify-content: center;padding-right:0px;display: flex;align-items: center;">

                                                                <img class="img-lock" src="https://apps.belajarsoal.id/image/global/lock-white.png" alt="">
                                                            </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <div class="col-9">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <h4 class="fs-6 mb-0 text-white ml-3"><b>' .
                                                                        $kategoris[$id]['name'] .
                                                                        '</b></h4>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <h6>' .
                                                                        $kategoris[$id]['keterangan'] .
                                                                        '</h6>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <button class="mt-2 btn btn-md btn-info btn-block btn-icon-text" onclick="detailkatclick(' .
                                                                        $id .
                                                                        ');">Pilih</button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <ul class="row d-none" style="margin-left: -15px !important; margin-right: -15px !important">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                ';

                                                                    detailkats($kategoris, $kat, false);

                                                                    echo '
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </ul>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                ';
                                                                }
                                                            }
                                                            echo '<li class="d-block"></li>';
                                                            foreach ($matkats as $id => $kat) {
                                                                if (!$id || !isset($kategoris[$id])) {
                                                                    foreach ($kat as $m) {
                                                                        if ($m->jenis == 1) {
                                                                            echo '
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <li class="col-lg-4 col-sm-6">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                ';

                                                                            echo '

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <div class="stretch-card" style="width:100%;">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <div class="card card-border text-left" style="height: 100%; width:100%;">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <div class="card-body p-3">

                                            <div class="mb-2" style="border: 1px solid #106571;border-radius:8px;overflow: hidden;">
                                            <div class="row align-items-center"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        style="flex-wrap: nowrap !important;">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <div class="col-3 bg-primary-custom" style="justify-content: center;padding-right:0px;display: flex;align-items: center;">

                                                                <img class="img-lock" src="https://apps.belajarsoal.id/image/global/lock-white.png" alt="">
                                                            </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <div class="col-9">

                                                                                                                                                               <h4 class="fs-6 mb-0 text-white">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <b>' .
                                                                                $m->paket_mst_r->judul .
                                                                                '</b>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </h4>                                                                                                                                                                                                                                                                                                                                             <p class="fs-6 mb-0 text-white">' .
                                                                                $m->paket_mst_r->total_soal .
                                                                                ' Soal</p>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <div class="row">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <div class="col-12">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <button data-bs-toggle="modal"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                data-bs-target="#myModal_' .
                                                                                $m->id .
                                                                                '"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                type="button"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                class="rounded-pill btn btn-md btn-primary btn-block btn-icon-text">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <i
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    class="fa fa-edit btn-icon-prepend"></i>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                Kerjakan Soal
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <button data-bs-toggle="modal" data-bs-target="#myModalBelajar_' .
                                                                                $m->id .
                                                                                '" type="button" class="rounded-pill btn btn-md btn-primary btn-block btn-icon-text">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <i class="fa fa-edit btn-icon-prepend"></i> Mode Belajar
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <!-- The Modal -->
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <div class="modal fade" id="myModal_' .
                                                                                $m->id .
                                                                                '">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <div class="modal-dialog">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <div class="modal-content"
                                                    style="background-color: #1e1e2f;border-radius: 10px;">

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <!-- Modal Header -->
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <!-- <div class="modal-header">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div> -->

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <!-- Modal body -->
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <div class="modal-body">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <center style="font-size:18px"><i
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                style="color:#D97706"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                class="fa fa-warning"></i> <span
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                style="color:#D97706"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                class="modal-title"><b>Perhatian
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    Sebelum Mengerjakan</b></span>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </center>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <!-- <h5>Peraturan</h5> -->
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <div class="table-responsive mt-3">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <table class="table table-primary">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <tbody>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td>Paket Latihan</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td>' .
                                                                                $m->paket_mst_r->judul .
                                                                                '
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td>Jumlah Soal</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td>' .
                                                                                $m->paket_mst_r->total_soal .
                                                                                '
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            Soal</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td>Waktu Mengerjakan</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td>' .
                                                                                $m->paket_mst_r->waktu .
                                                                                '
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            Menit</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </tr>';
                                                                            if ($m->paket_mst_r->ket) {
                                                                                echo '
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <td colspan="2">' .
                                                                                    $m->paket_mst_r->ket .
                                                                                    '
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ';
                                                                            }
                                                                            echo '
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </tbody>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </table>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </div>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <!-- Modal footer -->
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <div class="modal-footer"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        style="justify-content:center">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <form method="post"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            id="formKerjakan_' .
                                                                                $m->id .
                                                                                '"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            class="form-horizontal">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <input type="hidden" name="_token" value="' .
                                                                                csrf_token() .
                                                                                '">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <input type="hidden" name="idpaketdtl[]"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                value="' .
                                                                                Crypt::encrypt($idpaketdtl) .
                                                                                '">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <input type="hidden"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                name="id_paket_soal_mst[]"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                value="' .
                                                                                Crypt::encrypt($m->paket_mst_r->id) .
                                                                                '">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <button type="button"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                class="btn btn-outline-secondary"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                data-bs-dismiss="modal">Batal</button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <button type="button"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                class="btn btn-primary btn-kerjakan"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                idform="' .
                                                                                $m->id .
                                                                                '">Kerjakan
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                Sekarang</button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </form>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </div>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <!-- Modal Mode Belajar -->
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <div class="modal fade" id="myModalBelajar_' .
                                                                                $m->id .
                                                                                '">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <div class="modal-dialog">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <div class="modal-content"
                                                    style="background-color: #1e1e2f;border-radius: 10px;">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <div class="modal-body">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <center class="mb-3">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <i style="color:#D97706; font-size:1.5rem" class="fa fa-success"></i>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <div class="modal-title"><b>Mode Belajar</b></div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </center>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <div class="table-responsive mt-3">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <table class="table table-primary">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <tbody>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <td>Paket Latihan</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <td>' .
                                                                                $m->paket_mst_r->judul .
                                                                                '</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <td>Jumlah Soal</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <td>' .
                                                                                $m->paket_mst_r->total_soal .
                                                                                ' Soal</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </tr>';
                                                                            if ($m->paket_mst_r->ket) {
                                                                                echo '
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <td colspan="2">' .
                                                                                    $m->paket_mst_r->ket .
                                                                                    '</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </tr>';
                                                                            }
                                                                            echo '
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </tbody>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </table>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <div class="modal-footer d-flex justify-content-center">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <form method="post" id="formKerjakanBelajar_' .
                                                                                $m->id .
                                                                                '" class="form-horizontal">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <input type="hidden" name="_token" value="' .
                                                                                csrf_token() .
                                                                                '">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <input type="hidden" name="idpaketdtl[]" value="' .
                                                                                Crypt::encrypt($idpaketdtl) .
                                                                                '">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <input type="hidden" name="id_paket_soal_mst[]" value="' .
                                                                                Crypt::encrypt($m->paket_mst_r->id) .
                                                                                '">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <button type="button" class="btn btn-primary btn-kerjakan-belajar" idform="' .
                                                                                $m->id .
                                                                                '">Kerjakan Sekarang</button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </form>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </div>


                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ';

                                                                            echo '
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                ';
                                                                        } else {
                                                                            echo '
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <li class="col-lg-4 col-sm-6">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                ';

                                                                            echo '

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <div class="stretch-card" style="width:100%;">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <div class="card card-border text-left" style="height: 100%; width:100%;">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <div class="card-body p-3">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <div class="row align-items-center mb-3"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        style="flex-wrap: nowrap !important;">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <div class="col-3">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <div
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                class="icon-card bg-blue rounded-circle iconpaket">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <i class="p-1 icon-paper position-relative"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    style="top:-2px"></i>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <div class="col-9">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <h6 class="text-sm text-white">Latihan</h6>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <h4 class="fs-6 mb-0 text-white">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <b class="text-white">' .
                                                                                $m->paket_soal_mst_kecermatan_r->judul .
                                                                                '</b>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </h4>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <div class="row">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <div class="col-12">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <button data-bs-toggle="modal"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                data-bs-target="#myModalKecermatan_' .
                                                                                $m->id .
                                                                                '"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                type="button"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                class="rounded-pill btn btn-md btn-primary btn-block btn-icon-text bg-green">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <i
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    class="fa fa-edit btn-icon-prepend"></i>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                Kerjakan Soal
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <!-- The Modal -->
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <div class="modal fade" id="myModalKecermatan_' .
                                                                                $m->id .
                                                                                '">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <div class="modal-dialog">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <div class="modal-content">

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <!-- Modal Header -->
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <!-- <div class="modal-header">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div> -->

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <!-- Modal body -->
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <div class="modal-body">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <center style="font-size:18px"><i
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                style="color:#D97706"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                class="fa fa-warning"></i> <span
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                style="color:#D97706"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                class="modal-title"><b>Perhatian
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    Sebelum Mengerjakan</b></span>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </center>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <!-- <h5>Peraturan</h5> -->
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <div class="table-responsive mt-3">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <table class="table table-primary">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <tbody>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td>Paket Latihan</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td>' .
                                                                                $m->paket_soal_mst_kecermatan_r->judul .
                                                                                '
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td>Jumlah Soal</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td>' .
                                                                                $m->paket_soal_mst_kecermatan_r
                                                                                    ->total_soal .
                                                                                '
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            Soal</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ';
                                                                            if ($m->paket_soal_mst_kecermatan_r->ket) {
                                                                                echo '
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <td>Keterangan</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <td>' .
                                                                                    $m->paket_soal_mst_kecermatan_r
                                                                                        ->ket .
                                                                                    '
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ';
                                                                            }
                                                                            echo '
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </tbody>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </table>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <ul class="mt-3">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                Waktu akan berjalan ketika anda klik
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                tombol <b>Kerjakan Sekarang</b>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <!-- <li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              Jawaban anda akan tersimpan secara otomatis
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </li> -->
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                Jika waktu habis maka halaman akan
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                otomatis keluar dan anda tidak bisa lagi
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                mengerjakan soal
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <!-- <li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                Jika waktu masi tersisa dan soal sudah
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                selesai dikerjakan, silahkan klik tombol
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                selesai ujian maka nilai akan keluar
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                otomatis
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </li> -->
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                Silahkan klik tombol <b>Kerjakan
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    Sekarang</b> di bawah ini untuk
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                memulai ujian.
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                Pastikan koneksi internet stabil saat
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                mengerjakan soal.
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                Jangan lupa berdoa sebelum mengerjakan
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                ujian.
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </ul>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </div>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <!-- Modal footer -->
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <div class="modal-footer"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        style="justify-content:center">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <form method="post"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            id="formKerjakanKecermatan_' .
                                                                                $m->id .
                                                                                '"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            class="form-horizontal">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <input type="hidden" name="_token" value="' .
                                                                                csrf_token() .
                                                                                '">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <input type="hidden" name="idpaketdtl[]"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                value="' .
                                                                                Crypt::encrypt($idpaketdtl) .
                                                                                '">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <input type="hidden"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                name="id_paket_soal_mst[]"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                value="' .
                                                                                Crypt::encrypt(
                                                                                    $m->paket_soal_mst_kecermatan_r->id,
                                                                                ) .
                                                                                '">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <button type="button"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                class="btn btn-outline-secondary"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                data-bs-dismiss="modal">Batal</button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <button type="button"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                class="btn btn-primary btn-kerjakan-kecermatan"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                idform="' .
                                                                                $m->id .
                                                                                '">Kerjakan
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                Sekarang</button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </form>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </div>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>


                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ';

                                                                            echo '
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                ';
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        echo '
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <ul class="mainkat detailkats row">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <li class="px-4">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <button style="width:50px;" class="mt-4 mb-4 btn btn-sm btn-info btn-icon-text d-none" id="detailkatback" onclick="detailkatback()"> <i class="ti ti-arrow-left"></i> </button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ';

                                                        detailkats($kategoris, $detail_kats, true);
                                                        echo '
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </ul>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ';
                                                    @endphp
                                                @else
                                                    <center><img class="mb-3 img-no"
                                                            src="{{ asset('image/global/no-paket.png') }}" alt="">
                                                    </center>
                                                    <br>
                                                    <center class="text-white">Belum Ada Data</center>
                                                @endif
                                            </div>

                                            <div id="zoom" class="tab-pane {{ $tab == 'zoom' ? 'active' : '' }}">
                                                <hr>
                                                @if (count($paketzoom) > 0)
                                                    @php
                                                        function zoomkats(&$kategoris, $matkats, $isroot)
                                                        {
                                                            foreach ($matkats as $id => $kat) {
                                                                if ($id && isset($kategoris[$id])) {
                                                                    $hide = $isroot ? '' : ' d-none';
                                                                    echo '
                                                                                        <li class="col-lg-4 col-sm-6' .
                                                                        $hide .
                                                                        '" id="kat-' .
                                                                        $id .
                                                                        '" katid="' .
                                                                        $id .
                                                                        '">
                                                                                        <div class="stretch-card" style="width:100%">
                                                                                            <div class="card card-border text-left" style="height: 100%; width:100%;">
                                                                                                <div class="card-body">
                                                                                                <div class="row align-items-center mb-3">
                                                                                                    <div class="col-3">
                                                                                                        <div class="icon-card bg-blue rounded-circle iconpaket">
                                                                                                            <i class="p-2 ti-layers-alt"></i>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-9">
                                                                                                        <h4 class="fs-6 mb-0 text-white"><b>' .
                                                                        $kategoris[$id]['name'] .
                                                                        '</b></h4>
                                                                                                        <h6>' .
                                                                        $kategoris[$id]['keterangan'] .
                                                                        '</h6>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <button class="mt-2 btn btn-md btn-info btn-block btn-icon-text" onclick="zoomkatclick(' .
                                                                        $id .
                                                                        ');">Pilih</button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <ul class="row d-none" style="margin-left: -15px !important; margin-right: -15px !important">
                                                                                        ';

                                                                    zoomkats($kategoris, $kat, false);

                                                                    echo '
                                                                                        </ul>
                                                                                        </li>
                                                                                        ';
                                                                }
                                                            }

                                                            echo '<li class="d-block"></li>';
                                                            foreach ($matkats as $id => $kat) {
                                                                if (!$id || !isset($kategoris[$id])) {
                                                                    foreach ($kat as $m) {
                                                                        echo '
                                                                                            <li class="col-lg-4 col-sm-6">
                                                                                        ';

                                                                        echo '

                                                                                            <div class="stretch-card" style="width:100%;">
                                                                                    <div class="card card-border text-left" style="height: 100%; width:100%;">
                                                                                        <div class="card-body">
                                                                                            <div class="row align-items-center mb-3"
                                                                                                style="flex-wrap: nowrap !important;">
                                                                                                <div class="col-3">
                                                                                                    <div
                                                                                                        class="icon-card bg-blue rounded-circle iconpaket">
                                                                                                        <i class="p-1 icon-video position-relative"
                                                                                                            style="top:-2px"></i>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col-9">
                                                                                                    <h6 class="text-sm text-white">Zoom</h6>
                                                                                                    <h4 class="fs-6 mb-0 text-white">
                                                                                                        <b>' .
                                                                            $m->judul .
                                                                            '</b>
                                                                                                    </h4>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="row">
                                                                                                <div class="col-12">
                                                                                                    <a target="_blank"
                                                                                                        href="' .
                                                                            asset($m->link) .
                                                                            '">
                                                                                                        <button type="button"
                                                                                                            class="rounded-pill btn btn-md btn-primary btn-block btn-icon-text">
                                                                                                            <!-- <i class="fa fa-eye btn-icon-prepend"></i>   -->
                                                                                                            <i
                                                                                                                class="fas fa-chalkboard-teacher btn-icon-prepend"></i>
                                                                                                            Ikuti Zoom
                                                                                                        </button>
                                                                                                    </a>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                ';

                                                                        echo '
                                                                                        </li>
                                                                                        ';
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        echo '
                                                                            <ul class="mainkat row">
                                                                            <li class="px-4">
                                                                            <button style="width:50px;" class="mt-4 mb-4 btn btn-sm btn-info btn-icon-text d-none" id="zoomkatback" onclick="zoomkatback()"> <i class="ti ti-arrow-left"></i> </button>
                                                                            </li>
                                                                            ';
                                                        zoomkats($kategoris, $zoom_kats, true);
                                                        echo '
                                                                            </ul>
                                                                            ';
                                                    @endphp
                                                @else
                                                    <center><img class="mb-3 img-no"
                                                            src="{{ asset('image/global/no-paket.png') }}" alt="">
                                                    </center>
                                                    <br>
                                                    <center style="color: white;">Belum Ada Data</center>
                                                @endif
                                            </div>
                                            <div id="hasillatihan"
                                                class="tab-pane {{ $tab == 'hasillatihan' ? 'active' : '' }}">
                                                <hr>
                                                <br>
                                                <!-- @if (count($hasilujian) > 0)
    -->
                                                <div class="table-responsive">
                                                    <table class="table table-hover" style="color: white;">
                                                        <thead class="text-white">
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Judul</th>
                                                                <th>SKOR AKHIR</th>
                                                                <th>TANGGAL</th>
                                                                <th>OPSI</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="text-white">
                                                            @foreach ($hasilujian as $key)
                                                                <tr data-href="{{ url('detailhasil') }}/{{ Crypt::encrypt($key->id) }}"
                                                                    style="cursor: pointer;">
                                                                    <td width="1%">{{ $loop->iteration }}</td>
                                                                    <td width="10%" style="">
                                                                        {{ $key->judul }}
                                                                    </td>
                                                                    <td width="10%" style="">
                                                                        {{ $key->point }}
                                                                    </td>
                                                                    <td width="10%">
                                                                        {{ Carbon\Carbon::parse($key->mulai)->format('d/m/Y') }}
                                                                    </td>

                                                                    <td width="10%">
                                                                        <a target="_blank"
                                                                            href="{{ url('detailhasil') }}/{{ Crypt::encrypt($key->id) }}">
                                                                            <button class="btn btn-new btn-sm">
                                                                                <i class="fas fa-external-link-alt"></i>
                                                                                Pembahasan
                                                                            </button>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>

                                                    </table>
                                                </div>
                                                <!--
@else
    <center><img class="mb-3 img-no"
                                                                                                                                                            src="{{ asset('image/global/no-paket.png') }}"
                                                                                                                                                            alt=""></center>
                                                                                                                                                    <br>
                                                                                                                                                    <center class="text-white">Belum Ada Data</center>
    @endif -->
                                            </div>

                                        </div>
                                    </div>
                                </div>
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
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll("tbody tr").forEach(row => {
                row.addEventListener("click", function() {
                    let url = this.getAttribute("data-href");
                    if (url) {
                        window.open(url, "_blank");
                    }
                });
            });
        });
        $(document).ready(function() {
            //Fungsi Kerjakan Soal
            $(document).on('click', '.btn-kerjakan', function(e) {

                idform = $(this).attr('idform');
                var formData = new FormData($('#formKerjakan_' + idform)[0]);

                var url = "{{ url('/mulaiujian') }}/" + idform;
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
                    success: function(response) {
                        if (response.status == true) {
                            $('.modal').modal('hide');
                            // Swal.fire({
                            //   html: response.message,
                            //   icon: 'success',
                            //   showConfirmButton: false
                            // });
                            let timerInterval
                            Swal.fire({
                                title: response.message,
                                html: 'Mohon Tunggu... <b></b>',
                                timer: 2000,
                                timerProgressBar: true,
                                didOpen: () => {
                                    Swal.showLoading()
                                    const b = Swal.getHtmlContainer().querySelector(
                                        'b')
                                    timerInterval = setInterval(() => {
                                        b.textContent = Swal.getTimerLeft()
                                    }, 100)
                                },
                                willClose: () => {
                                    clearInterval(timerInterval)
                                }
                            }).then((result) => {
                                /* Read more about handling dismissals below */
                                if (result.dismiss === Swal.DismissReason.timer) {
                                    reload_url(0, '{{ url('ujian') }}/' + response
                                        .id);
                                }
                            })

                        } else {
                            if (response.cek) {
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
                                                ).attr('content')
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
                            } else {
                                Swal.fire({
                                    html: response.message,
                                    icon: 'error',
                                    confirmButtonText: 'Ok'
                                });
                            }
                        }
                    },
                    error: function(xhr, status) {
                        alert('Error!!!');
                    },
                    complete: function() {
                        $.LoadingOverlay("hide");
                    }
                });
            });

            //Fungsi Kerjakan Soal Kecermatan
            $(document).on('click', '.btn-kerjakan-kecermatan', function(e) {
                idform = $(this).attr('idform');
                var formData = new FormData($('#formKerjakanKecermatan_' + idform)[0]);

                var url = "{{ url('/mulaiujiankecermatan') }}/" + idform;
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
                    success: function(response) {
                        if (response.status == true) {
                            $('.modal').modal('hide');
                            Swal.fire({
                                html: response.message,
                                icon: 'success',
                                showConfirmButton: false
                            });
                            reload_url(0, '{{ url('ujiankecermatan') }}/' + response.id);
                        } else {
                            if (response.id) {
                                Swal.fire({
                                    icon: 'warning',
                                    html: response.message,
                                    showDenyButton: false,
                                    showCancelButton: false,
                                    confirmButtonText: 'Lanjutkan',
                                    cancelButtonText: 'Batal',
                                    denyButtonText: 'Selesaikan Ujian',
                                }).then((result) => {
                                    /* Read more about isConfirmed, isDenied below */
                                    if (result.isConfirmed) {
                                        window.location.href =
                                            '{{ url('ujiankecermatan') }}/' +
                                            response.id;
                                    } else if (result.isDenied) {

                                        // idpaketmst = response.idpaket;
                                        // $.ajaxSetup({
                                        //     headers: {
                                        //         'X-CSRF-TOKEN': $(
                                        //             'meta[name="csrf-token"]'
                                        //         ).attr('content')
                                        //     }
                                        // });
                                        // $.ajax({
                                        //     type: "POST",
                                        //     dataType: "JSON",
                                        //     url: "{{ url('selesaiujian') }}",

                                        //     data: {
                                        //         idpaketmst: idpaketmst
                                        //     },
                                        //     beforeSend: function() {
                                        //         $.LoadingOverlay("show", {
                                        //             image: "{{ asset('/image/global/loading.gif') }}"
                                        //         });
                                        //     },
                                        //     success: function(response) {

                                        //         if (response.status) {
                                        //             $('.modal').modal(
                                        //                 'hide');
                                        //             Swal.fire({
                                        //                 html: response
                                        //                     .message,
                                        //                 icon: 'success',
                                        //                 showConfirmButton: true
                                        //             }).then((
                                        //                 result) => {
                                        //                 $.LoadingOverlay(
                                        //                     "show", {
                                        //                         image: "{{ asset('/image/global/loading.gif') }}"
                                        //                     });
                                        //                 reload_url(
                                        //                     1500,
                                        //                     '{{ url('paketsayaktg') }}'
                                        //                 );
                                        //             })
                                        //         } else {
                                        //             Swal.fire({
                                        //                 html: response
                                        //                     .message,
                                        //                 icon: 'error',
                                        //                 confirmButtonText: 'Ok'
                                        //             });
                                        //         }
                                        //     },
                                        //     error: function(xhr, status) {
                                        //         alert('Error!!!');
                                        //     },
                                        //     complete: function() {
                                        //         $.LoadingOverlay("hide");
                                        //     }
                                        // });
                                        // Akhir Selesaikan Ujian
                                    }
                                });
                            } else {
                                Swal.fire({
                                    html: response.message,
                                    icon: 'error',
                                    confirmButtonText: 'Ok'
                                });
                            }

                        }
                    },
                    error: function(xhr, status) {
                        alert('Error!!!');
                    },
                    complete: function() {
                        $.LoadingOverlay("hide");
                    }
                });
            });

            // Fungsi Mode Belajar
            $(document).on('click', '.btn-kerjakan-belajar', function(e) {
                var idform = $(this).attr('idform');
                var formData = new FormData($('#formKerjakanBelajar_' + idform)[0]);
                var url = "{{ url('/mulaibelajar') }}/" + idform;
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
                    success: function(response) {
                        if (response.status == true) {
                            $('.modal').modal('hide');
                            let timerInterval;
                            Swal.fire({
                                title: response.message,
                                html: 'Mohon Tunggu... <b></b>',
                                timer: 2000,
                                timerProgressBar: true,
                                didOpen: () => {
                                    Swal.showLoading();
                                    const b = Swal.getHtmlContainer().querySelector(
                                        'b');
                                    timerInterval = setInterval(() => {
                                        b.textContent = Swal.getTimerLeft();
                                    }, 100);
                                },
                                willClose: () => {
                                    clearInterval(timerInterval);
                                }
                            }).then((result) => {
                                if (result.dismiss === Swal.DismissReason.timer) {
                                    reload_url(0, '{{ url('belajar') }}/' + response
                                        .id);
                                }
                            });
                        } else {
                            if (response.cek) {
                                Swal.fire({
                                    icon: 'warning',
                                    html: response.message,
                                    showDenyButton: true,
                                    showCancelButton: true,
                                    confirmButtonText: 'Lanjutkan',
                                    cancelButtonText: 'Batal',
                                    denyButtonText: 'Selesaikan Ujian',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href =
                                            '{{ url('belajar') }}/' + response.idpaket;
                                    } else if (result.isDenied) {
                                        var idpaketmst = response.idpaket;
                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $(
                                                    'meta[name="csrf-token"]'
                                                ).attr('content')
                                            }
                                        });
                                        $.ajax({
                                            type: "POST",
                                            dataType: "JSON",
                                            url: "{{ url('selesaiujianpublic') }}",
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
                                                    });
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
                                    }
                                });
                            } else {
                                Swal.fire({
                                    html: response.message,
                                    icon: 'error',
                                    confirmButtonText: 'Ok'
                                });
                            }
                        }
                    },
                    error: function(xhr, status) {
                        alert('Error!!!');
                    },
                    complete: function() {
                        $.LoadingOverlay("hide");
                    }
                });
            });

        });


        function matkatclick(id) {
            if (!id) return;
            matkatbackid = id;
            $('#matkatback').removeClass('d-none');
            $('#kat-' + id).addClass('fullwidth');
            $('#kat-' + id).css('max-width', '100%');
            $('#kat-' + id).css('flex', '0 0 100%');
            $('#kat-' + id + ' > div').addClass('d-none');
            $('#kat-' + id + ' > ul').removeClass('d-none');
            $('#kat-' + id).siblings('li').find('div').addClass('d-none');
            $('#kat-' + id).siblings('li').find('ul').addClass('d-none');
        }

        function matkatback(id) {
            var id = matkatbackid;
            if (!id) return;

            var elm = document.getElementById('kat-' + id);
            var parent = elm.parentElement.parentElement;

            if (parent.tagName === 'LI') {
                matkatbackid = parent.getAttribute('katid');
            } else {
                matkatbackid = 0;
                $('#matkatback').addClass('d-none');
            }

            $('#kat-' + id).removeClass('fullwidth');
            $('#kat-' + id).css('max-width', '');
            $('#kat-' + id).css('flex', '');
            $('#kat-' + id + ' > div').removeClass('d-none');
            $('#kat-' + id + ' > ul').addClass('d-none');

            $('#kat-' + id).siblings('li').removeClass('fullwidth');
            $('#kat-' + id).siblings('li').find('div').removeClass('d-none');
            $('#kat-' + id).siblings('li').find('ul').addClass('d-none');
        }

        function zoomkatclick(id) {
            if (!id) return;
            zoomkatbackid = id;
            $('#zoomkatback').removeClass('d-none');
            $('#kat-' + id).addClass('fullwidth');
            $('#kat-' + id).css('max-width', '100%');
            $('#kat-' + id).css('flex', '0 0 100%');
            $('#kat-' + id + ' > div').addClass('d-none');
            $('#kat-' + id + ' > ul').removeClass('d-none');
            $('#kat-' + id).siblings('li').find('div').addClass('d-none');
            $('#kat-' + id).siblings('li').find('ul').addClass('d-none');
        }

        function zoomkatback(id) {
            var id = zoomkatbackid;
            if (!id) return;

            var elm = document.getElementById('kat-' + id);
            var parent = elm.parentElement.parentElement;

            if (parent.tagName === 'LI') {
                zoomkatbackid = parent.getAttribute('katid');
            } else {
                zoomkatbackid = 0;
                $('#zoomkatback').addClass('d-none');
            }

            $('#kat-' + id).removeClass('fullwidth');
            $('#kat-' + id).css('max-width', '');
            $('#kat-' + id).css('flex', '');
            $('#kat-' + id + ' > div').removeClass('d-none');
            $('#kat-' + id + ' > ul').addClass('d-none');

            $('#kat-' + id).siblings('li').removeClass('fullwidth');
            $('#kat-' + id).siblings('li').find('div').removeClass('d-none');
            $('#kat-' + id).siblings('li').find('ul').addClass('d-none');
        }

        function detailkatclick(id) {
            if (!id) return;
            detailkatbackid = id;
            $('#detailkatback').removeClass('d-none');
            $('.detailkats #kat-' + id).addClass('fullwidth');
            $('.detailkats #kat-' + id).css('max-width', '100%');
            $('.detailkats #kat-' + id).css('flex', '0 0 100%');
            $('.detailkats #kat-' + id + ' > div').addClass('d-none');
            $('.detailkats #kat-' + id + ' > ul').removeClass('d-none');
            $('.detailkats #kat-' + id).siblings('li').find('div').addClass('d-none');
            // $('.detailkats #kat-' + id).siblings('li').css('margin-top', '-20px');
            $('.detailkats #kat-' + id).siblings('li').find('ul').addClass('d-none');
        }

        function detailkatback(id) {
            var id = detailkatbackid;
            if (!id) return;

            //            var elm = document.getElementById('kat-'+ id);
            var elm = document.querySelector('.detailkats #kat-' + id);
            var parent = elm.parentElement.parentElement;

            if (parent.tagName === 'LI') {
                detailkatbackid = parent.getAttribute('katid');
            } else {
                detailkatbackid = 0;
                $('#detailkatback').addClass('d-none');
            }

            $('.detailkats #kat-' + id).removeClass('fullwidth');
            $('.detailkats #kat-' + id).css('max-width', '');
            $('.detailkats #kat-' + id).css('flex', '');
            $('.detailkats #kat-' + id + ' > div').removeClass('d-none');
            $('.detailkats #kat-' + id + ' > ul').addClass('d-none');

            $('.detailkats #kat-' + id).siblings('li').removeClass('fullwidth');
            $('.detailkats #kat-' + id).siblings('li').find('div').removeClass('d-none');
            // $('.detailkats #kat-' + id).siblings('li').css('margin-top', '0px');
            $('.detailkats #kat-' + id).siblings('li').find('ul').addClass('d-none');
        }

        function cermatkatclick(id) {
            if (!id) return;
            cermatkatbackid = id;
            $('#cermatkatback').removeClass('d-none');
            $('.cermatkats #kat-' + id).addClass('fullwidth');
            $('.cermatkats #kat-' + id + ' > div').addClass('d-none');
            $('.cermatkats #kat-' + id + ' > ul').removeClass('d-none');
            $('.cermatkats #kat-' + id).siblings('li').find('div').addClass('d-none');
            $('.cermatkats #kat-' + id).siblings('li').find('ul').addClass('d-none');
        }

        function cermatkatback(id) {
            var id = cermatkatbackid;
            if (!id) return;

            //var elm = document.getElementById('kat-'+ id);
            var elm = document.querySelector('.cermatkats #kat-' + id);

            var parent = elm.parentElement.parentElement;

            if (parent.tagName === 'LI') {
                cermatkatbackid = parent.getAttribute('katid');
            } else {
                cermatkatbackid = 0;
                $('#cermatkatback').addClass('d-none');
            }

            $('.cermatkats #kat-' + id).removeClass('fullwidth');
            $('.cermatkats #kat-' + id + ' > div').removeClass('d-none');
            $('.cermatkats #kat-' + id + ' > ul').addClass('d-none');

            $('.cermatkats #kat-' + id).siblings('li').removeClass('fullwidth');
            $('.cermatkats #kat-' + id).siblings('li').find('div').removeClass('d-none');
            $('.cermatkats #kat-' + id).siblings('li').find('ul').addClass('d-none');
        }

        function latihan() {
            $('[href="#latihan"]').tab('show');
        }
    </script>
@endsection
