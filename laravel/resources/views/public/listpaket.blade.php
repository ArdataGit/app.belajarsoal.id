@extends('layouts.SkydashPublic')

@section('content')
    @php
        if (app('request')->input('tab')) {
            $tab = app('request')->input('tab');
        } else {
            // Tentukan tab default berdasarkan ketersediaan data
            if (count($paketdtl) > 0) {
                $tab = 'latihan';
            } else {
                $tab = 'pembelajaran'; // Atau tab lain yang sesuai
            }
        }
    @endphp
    <style>
        /* Global */
        body {
            background-color: #121212;
            color: #e0e0e0;
            font-family: 'Roboto', sans-serif;
        }

        .content-wrapper {
            padding: 2rem;
        }

        /* Card & Container */
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
            min-width: 320px;
        }

        .grid-margin {
            margin: 0;
        }

        .stretch-card {
            width: 100%;
        }

        /* Typography */
        h3 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: #f0f0f0;
        }

        h4 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #f0f0f0;
        }

        h6 {
            font-size: 1rem;
            font-weight: 400;
            margin-bottom: 0.5rem;
            color: #d0d0d0;
        }

        /* Button Styles */
        .btn {
            border-radius: 30px;
            padding: 0.5rem;
            font-weight: 500;
            text-transform: uppercase;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background-color: #2a802d;
            border: none;
        }

        .btn-info {
            background-color: #2a802d;
            border: none;
            color: white;
        }

        .btn-outline-secondary {
            border: 1px solid #bbb;
            color: #bbb;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .btn-block {
            width: 100%;
        }

        .btn-icon-text i {
            margin-right: 1rem;
        }

        /* Gap between stacked buttons in a column */
        .col-12>button+button {
            margin-top: 0.75rem;
        }

        /* Icon */
        .icon-card {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #2854bc;
            border-radius: 50%;
            font-size: 1.5rem;
            margin-right: 1rem;
        }

        /* List Kategori */
        ul.mainkat,
        ul.detailkats {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        /* Grid layout for detailkats */
        ul.detailkats {
            display: grid;
            gap: 1rem;
            /* jarak antar item */
            list-style: none;
            padding: 0;
            margin: 0;
        }

        @media (min-width: 1200px) {
            ul.detailkats {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        @media (min-width: 768px) and (max-width: 1199.98px) {
            ul.detailkats {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 767.98px) {
            ul.detailkats {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* Nested detailkats */
        ul.detailkats,
        ul.detailkats ul {
            display: grid;
            gap: 1rem;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        ul.detailkats li {
            display: block;
            margin-bottom: 1rem;
            /* width: 100%; */
        }

        /* Fullwidth when expanded */
        ul.detailkats li.fullwidth {
            grid-column: 1 / -1 !important;
        }

        /* For all breakpoints in nested detailkats */
        @media (min-width: 1200px) {

            ul.detailkats,
            ul.detailkats ul {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        @media (min-width: 768px) and (max-width: 1199.98px) {

            ul.detailkats,
            ul.detailkats ul {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 767.98px) {

            ul.detailkats,
            ul.detailkats ul {
                grid-template-columns: repeat(1, 1fr);
            }
        }

        #detailkatback {
            background-color: #2196f3;
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Modal Styling */
        .modal-content {
            background-color: #434353;
            border: none;
            border-radius: 10px;
        }

        .modal-header,
        .modal-footer {
            border: none;
        }

        .modal-body {
            padding: 1.5rem;
            font-size: 1rem;
            line-height: 1.4;
        }

        .modal-body .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #f0f0f0;
        }

        .modal-body ul {
            padding-left: 1.2rem;
            margin-bottom: 0;
        }

        .modal-body ul li {
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .table.table-primary {
            background-color: #27293d;
            color: black;
            border-radius: 5px;
        }

        .table.table-primary td,
        .table.table-primary th {
            border: none;
            padding: 0.75rem;
        }

        /* Utilitas Spacing & Text */
        .w-100 {
            width: 100%;
        }

        .mb-3 {
            margin-bottom: 1rem !important;
        }

        .mt-2 {
            margin-top: 0.5rem !important;
        }

        .mt-4 {
            margin-top: 1.5rem !important;
        }

        .mb-4 {
            margin-bottom: 1.5rem !important;
        }

        .ps-4 {
            padding-left: 1.5rem !important;
        }

        .d-flex {
            display: flex !important;
        }

        .justify-content-center {
            justify-content: center !important;
        }

        .text-white {
            color: #fff !important;
        }

        .text-sm {
            font-size: 0.875rem;
        }

        .fs-6 {
            font-size: 1rem;
        }

        .ml-2 {
            margin-left: 0.5rem;
        }

        .ml-3 {
            margin-left: 1rem;
        }

        .p-3 {
            padding: 1rem;
        }

        .p-1 {
            padding: 0.25rem;
        }

        .rounded-pill {
            border-radius: 50rem !important;
        }

        .rounded-circle {
            border-radius: 50% !important;
        }

        /* Default: horizontal layout for large screens */
        .mainkat.detailkats {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        @media (max-width: 768px) {
            .mainkat.detailkats {
                flex-direction: column;
                align-items: center;
            }
        }

        @media (max-width: 768px) {
            #detailkatback {
                display: block;
            }
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

        .row li {
            list-style: none;
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
                                            "keterangan": "' .
                            ($kategori['keterangan'] ?? '') .
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
                <div class="w-100">
                    <div>
                        <p class="card-description">
                        <h3 class="font-weight-bold text-white">
                            <b>{{ optional($data)->judul }}</b>
                        </h3>
                        <h6 class="text-white">
                            {!! optional($data)->ket !!}
                        </h6>
                        </p>
                        <hr>
                        <div class="row">
                            <div class="col-lg-12 grid-margin stretch-card">
                                <ul class="pb-0 nav nav-pills btn-menu-paket" role="tablist" style="border-bottom:unset">
                                    @if (count($paketvideo) > 0 || count($paketpdf) > 0)
                                        <li class="nav-item">
                                            <a class="btn btn-sm btn-primary nav-link btn-tab-hasil {{ $tab == 'pembelajaran' ? 'active' : '' }}"
                                                data-toggle="pill" href="#pembelajaran">Pembelajaran</a>
                                        </li>
                                    @endif

                                    @if (count($paketdtl) > 0)
                                        <li class="nav-item">
                                            <a class="btn btn-sm btn-primary nav-link btn-tab-hasil {{ $tab == 'latihan' ? 'active' : '' }}"
                                                data-toggle="pill" href="#latihan">Tryout</a>
                                        </li>
                                    @endif
                                    {{--
                                    <li class="nav-item">
                                        <a class="btn btn-sm btn-primary nav-link btn-tab-hasil"
                                            href="{{url('userclass/'.Crypt::encrypt($data->id))}}">Class</a>
                                    </li>
                                    --}}
                                </ul>
                                <div class="tab-content tab-hasil-ujian">
                                    <!-- Button trigger modal -->
                                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                                    {{-- TAB LATIHAN --}}
                                    <div id="latihan" class="tab-pane {{ $tab == 'latihan' ? 'active' : '' }}">
                                        <hr>
                                        @if (count($paketdtl) > 0)
                                            @php
                                                function detailkats(&$kategoris, $matkats, $isroot)
                                                {
                                                    global $idpaketdtl;
                                                    foreach ($matkats as $id => $kat) {
                                                        if ($id && isset($kategoris[$id])) {
                                                            echo '
                                                                                                                                                <li class="col-lg-4 col-sm-6" id="kat-' .
                                                                $id .
                                                                '" katid="' .
                                                                $id .
                                                                '">
                                                                                                                                                    <div class="stretch-card w-100">
                                                                                                                                                        <div class="card card-border mb-3 h-100 bg-transparent">
                                                                                                                                                            <div class="card-body bg-transparent">
                                                                                                                                                                <div class="mb-2" style="border: 1px solid #106571;border-radius:8px;overflow: hidden;">
                                                                                                                                                                <div class="row align-items-center">
                                                                                                                                                                    <div class="col-3 bg-primary-custom" style="justify-content: center;padding-right:0px;display: flex;align-items: center;">
                                                                                                                                                                        <img class="img-lock" src="https://apps.belajarsoal.id/image/global/lock-white.png" alt="">
                                                                                                                                                                    </div>
                                                                                                                                                                    <div class="col-9">
                                                                                                                                                                        <h4 class="fs-6 mb-0 ml-2 text-white ml-3"><b>' .
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
                                                                                                                                                    <ul class="row d-none">';
                                                            detailkats($kategoris, $kat, false);
                                                            echo '
                                                                                                                                                    </ul>
                                                                                                                                                </li>';
                                                        }
                                                    }
                                                    foreach ($matkats as $id => $kat) {
                                                        if (!$id || !isset($kategoris[$id])) {
                                                            foreach ($kat as $m) {
                                                                if ($m->jenis == 1) {
                                                                    echo '
                                                                                                                                                        <li class="col-lg-4 col-sm-6">
                                                                                                                                                            <div class="stretch-card w-100">
                                                                                                                                                                <div class="card card-border h-100 bg-transparent">
                                                                                                                                                                    <div class="card-body p-3 bg-transparent">
                                                                                                                                                                        <div class="mb-2" style="border: 1px solid #106571;border-radius:8px;overflow: hidden;">
                                                                                                                                                                        <div class="row align-items-center" style="flex-wrap: nowrap !important;">
                                                                                                                                                                            <div class="col-3 bg-primary-custom" style="justify-content: center;padding-right:0px;display: flex;align-items: center;">
                                                                                                                                                                                <img class="img-lock" src="https://apps.belajarsoal.id/image/global/lock-white.png" alt="">
                                                                                                                                                                            </div>
                                                                                                                                                                            <div class="col-9">
                                                                                                                                                                            <h4 class="fs-6 mb-0 text-white ml-2"><b>' .
                                                                        $m->paket_mst_r->judul .
                                                                        '</b></h4>
                                                                                                                                                                                <p class="mb-0 text-white ml-2">' .
                                                                        $m->paket_mst_r->total_soal .
                                                                        ' Soal</p>
                                                                                                                                                                            </div>
                                                                                                                                                                        </div>
                                                                                                                                                                        </div>
                                                                                                                                                                        <div class="row">
                                                                                                                                                                            <div class="col-12">
                                                                                                                                                                                <button data-bs-toggle="modal" data-bs-target="#myModal_' .
                                                                        $m->id .
                                                                        '" type="button" class="rounded-pill btn btn-md btn-primary btn-block btn-icon-text">
                                                                                                                                                                                    <i class="fa fa-edit btn-icon-prepend"></i> KERJAKAN SEKARANG
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
                                                                                                                                                            <!-- Modal Mode Tryout -->
                                                                                                                                                            <div class="modal fade" id="myModal_' .
                                                                        $m->id .
                                                                        '">
                                                                                                                                                                <div class="modal-dialog">
                                                                                                                                                                    <div class="modal-content">
                                                                                                                                                                        <div class="modal-body">
                                                                                                                                                                            <center class="mb-3">
                                                                                                                                                                                <i style="color:#D97706; font-size:1.5rem" class="fa fa-warning"></i>
                                                                                                                                                                                <div class="modal-title"><b>Perhatian Sebelum Mengerjakan</b></div>
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
                                                                                                                                                                                        </tr>
                                                                                                                                                                                        <tr>
                                                                                                                                                                                            <td>Waktu Mengerjakan</td>
                                                                                                                                                                                            <td>' .
                                                                        $m->paket_mst_r->waktu .
                                                                        ' Menit</td>
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
                                                                                                                                                                            <form method="post" id="formKerjakan_' .
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
                                                                                                                                                                                <button type="button" class="btn btn-primary btn-kerjakan" idform="' .
                                                                        $m->id .
                                                                        '">Kerjakan Sekarang</button>
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
                                                                                                                                                                    <div class="modal-content">
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
                                                                    echo '</li>';
                                                                } else {
                                                                    echo '
                                                                                                                                                        <li class="col-lg-4 col-sm-6">
                                                                                                                                                            <div class="stretch-card w-100">
                                                                                                                                                                <div class="card card-border h-100">
                                                                                                                                                                    <div class="card-body p-3">
                                                                                                                                                                        <div class="mb-2" style="border: 1px solid #106571;border-radius:8px;overflow: hidden;">
                                                                                                                                                                        <div class="row align-items-center" style="flex-wrap: nowrap !important;">
                                                                                                                                                                            <div class="col-3 bg-primary-custom" style="justify-content: center;padding-right:0px;display: flex;align-items: center;">

                                                                                                                                                                                <img class="img-lock" src="https://apps.belajarsoal.id/image/global/lock-white.png" alt="">
                                                                                                                                                                            </div>
                                                                                                                                                                            <div class="col-9">
                                                                                                                                                                                <h6 class="text-sm text-white">Latihan</h6>
                                                                                                                                                                                <h4 class="fs-6 mb-0 text-white ml-2"><b>' .
                                                                        $m->paket_soal_mst_kecermatan_r->judul .
                                                                        '</b></h4>
                                                                                                                                                                            </div>
                                                                                                                                                                        </div>
                                                                                                                                                                        </div>
                                                                                                                                                                        <div class="row">
                                                                                                                                                                            <div class="col-12">
                                                                                                                                                                                <button data-bs-toggle="modal" data-bs-target="#myModalKecermatan_' .
                                                                        $m->id .
                                                                        '" type="button" class="rounded-pill btn btn-md btn-primary btn-block btn-icon-text">
                                                                                                                                                                                    <i class="fa fa-edit btn-icon-prepend"></i> KERJAKAN SEKARANG
                                                                                                                                                                                </button>
                                                                                                                                                                            </div>
                                                                                                                                                                        </div>
                                                                                                                                                                    </div>
                                                                                                                                                                </div>
                                                                                                                                                            </div>
                                                                                                                                                            <!-- Modal Kecermatan -->
                                                                                                                                                            <div class="modal fade" id="myModalKecermatan_' .
                                                                        $m->id .
                                                                        '">
                                                                                                                                                                <div class="modal-dialog">
                                                                                                                                                                    <div class="modal-content">
                                                                                                                                                                        <div class="modal-body">
                                                                                                                                                                            <center class="mb-3">
                                                                                                                                                                                <i style="color:#D97706; font-size:1.5rem" class="fa fa-warning"></i>
                                                                                                                                                                                <div class="modal-title"><b>Perhatian Sebelum Mengerjakan</b></div>
                                                                                                                                                                            </center>
                                                                                                                                                                            <div class="table-responsive mt-3">
                                                                                                                                                                                <table class="table table-primary">
                                                                                                                                                                                    <tbody>
                                                                                                                                                                                        <tr>
                                                                                                                                                                                            <td>Paket Latihan</td>
                                                                                                                                                                                            <td>' .
                                                                        $m->paket_soal_mst_kecermatan_r->judul .
                                                                        '</td>
                                                                                                                                                                                        </tr>
                                                                                                                                                                                        <tr>
                                                                                                                                                                                            <td>Jumlah Soal</td>
                                                                                                                                                                                            <td>' .
                                                                        $m->paket_soal_mst_kecermatan_r->total_soal .
                                                                        ' Soal</td>
                                                                                                                                                                                        </tr>';
                                                                    if ($m->paket_soal_mst_kecermatan_r->ket) {
                                                                        echo '
                                                                                                                                                                                        <tr>
                                                                                                                                                                                            <td colspan="2">' .
                                                                            $m->paket_soal_mst_kecermatan_r->ket .
                                                                            '</td>
                                                                                                                                                                                        </tr>';
                                                                    }
                                                                    echo '
                                                                                                                                                                                    </tbody>
                                                                                                                                                                                </table>
                                                                                                                                                                            </div>
                                                                                                                                                                            <ul class="mt-3">
                                                                                                                                                                                <li>Waktu akan berjalan ketika Anda klik tombol <b>Kerjakan Sekarang</b>.</li>
                                                                                                                                                                                <li>Jika waktu habis, halaman akan otomatis keluar dan soal tidak dapat dikerjakan lagi.</li>
                                                                                                                                                                                <li>Klik tombol <b>Kerjakan Sekarang</b> untuk memulai ujian.</li>
                                                                                                                                                                                <li>Pastikan koneksi internet Anda stabil.</li>
                                                                                                                                                                                <li>Jangan lupa berdoa sebelum mengerjakan ujian.</li>
                                                                                                                                                                            </ul>
                                                                                                                                                                        </div>
                                                                                                                                                                        <div class="modal-footer d-flex justify-content-center">
                                                                                                                                                                            <form method="post" id="formKerjakanKecermatan_' .
                                                                        $m->id .
                                                                        '" class="form-horizontal">
                                                                                                                                                                                <input type="hidden" name="_token" value="' .
                                                                        csrf_token() .
                                                                        '">
                                                                                                                                                                                <input type="hidden" name="idpaketdtl[]" value="' .
                                                                        Crypt::encrypt($idpaketdtl) .
                                                                        '">
                                                                                                                                                                                <input type="hidden" name="id_paket_soal_mst[]" value="' .
                                                                        Crypt::encrypt(
                                                                            $m->paket_soal_mst_kecermatan_r->id,
                                                                        ) .
                                                                        '">
                                                                                                                                                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                                                                                                                                                                <button type="button" class="btn btn-primary btn-kerjakan-kecermatan" idform="' .
                                                                        $m->id .
                                                                        '">Kerjakan Sekarang</button>
                                                                                                                                                                            </form>
                                                                                                                                                                        </div>
                                                                                                                                                                    </div>
                                                                                                                                                                </div>
                                                                                                                                                            </div>
                                                                                                                                                        ';
                                                                    echo '</li>';
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                                echo '
                                                                                                                                    
                                                    <button  class=" btn btn-sm btn-info btn-icon-text d-none" id="detailkatback" onclick="detailkatback()">
                                                                                                                                            <i class="ti ti-arrow-left"></i>
                                                                                                                                        </button>                                                                                <ul class="mainkat detailkats row" style="gap: 0">
                                                                                                                                        
                                                                                                                                    ';
                                                detailkats($kategoris, $detail_kats, true);
                                                echo '
                                                                                                                                    </ul>
                                                                                                                                    ';
                                            @endphp
                                        @else
                                            <center class="text-white">Belum Ada Data</center>
                                        @endif
                                    </div>

                                    {{-- TAB PEMBELAJARAN --}}
                                    <div id="pembelajaran" class="tab-pane {{ $tab == 'pembelajaran' ? 'active' : '' }}">
                                        <hr>
                                        @if (count($paketvideo) > 0 || count($paketpdf) > 0)
                                            @php
                                                // --- Style-Adjusted matkats Function ---
                                                function matkats(&$kategoris, $matkats, $isroot)
                                                {
                                                    foreach ($matkats as $id => $kat) {
                                                        if ($id && isset($kategoris[$id])) {
                                                            // Kategori Card
                                                            echo '
                                                                                                                                                <li class="col-lg-4 col-sm-6" id="kat-' .
                                                                $id .
                                                                '" katid="' .
                                                                $id .
                                                                '">
                                                                                                                                                    <div class="stretch-card w-100">
                                                                                                                                                        <div class="card card-border h-100 bg-transparent">
                                                                                                                                                            <div class="card-body bg-transparent">
                                                                                                                                                                <div class="mb-2" style="border: 1px solid #106571;border-radius:8px;overflow: hidden;">
                                                                                                                                                                <div class="row align-items-center">
                                                                                                                                                                    <div class="col-3 bg-primary-custom" style="justify-content: center;padding-right:0px;display: flex;align-items: center;">
                                                                                                                                                                        <img class="img-lock" src="https://apps.belajarsoal.id/image/global/lock-white.png" alt="">
                                                                                                                                                                    </div>
                                                                                                                                                                    <div class="col-9">
                                                                                                                                                                        <h4 class="fs-6 mb-0 text-white ml-2"><b>' .
                                                                $kategoris[$id]['name'] .
                                                                '</b></h4>
                                                                                                                                                                        <h6>' .
                                                                ($kategoris[$id]['keterangan'] ?? '') .
                                                                '</h6>
                                                                                                                                                                    </div>
                                                                                                                                                                </div>
                                                                                                                                                                </div>
                                                                                                                                                                <button class="mt-2 btn btn-md btn-info btn-block btn-icon-text" onclick="matkatclick(' .
                                                                $id .
                                                                ');">
                                                                                                                                                                    Pilih
                                                                                                                                                                </button>
                                                                                                                                                            </div>
                                                                                                                                                        </div>
                                                                                                                                                    </div>
                                                                                                                                                    <ul class=" d-none p-0 row" style="margin: 0 -2rem">
                                                                                                                                                ';
                                                            matkats($kategoris, $kat, false);
                                                            echo '
                                                                                                                                                    </ul>
                                                                                                                                                </li>
                                                                                                                                                ';
                                                        }
                                                    }

                                                    // Materi Items (Video/PDF)
                                                    foreach ($matkats as $id => $kat) {
                                                        if (!$id || !isset($kategoris[$id])) {
                                                            foreach ($kat as $m) {
                                                                echo '
                                                                                                                                                    <li class="col-lg-4 col-sm-6">
                                                                                                                                                        <div class="stretch-card w-100">
                                                                                                                                                            <div class="card card-border h-100 bg-transparent">
                                                                                                                                                                <div class="card-body p-3 bg-transparent">
                                                                                                                                                                    <div class="mb-2" style="border: 1px solid #106571;border-radius:8px;overflow: hidden;">
                                                                                                                                                                    <div class="row align-items-center" style="flex-wrap: nowrap !important;">
                                                                                                                                                                        <div class="col-3 bg-primary-custom" style="justify-content: center;padding-right:0px;display: flex;align-items: center;">
                                                                                                                                                    ';
                                                                // Jika jenis = 1 -> Video
                                                                if ($m->jenis == 1) {
                                                                    echo '
                                                                                                                                                                            <img class="img-lock" src="https://apps.belajarsoal.id/image/global/lock-white.png" alt="">
                                                                                                                                                                        </div>
                                                                                                                                                                        <div class="col-9">
                                                                                                                                                                            <h6 class="text-sm text-white">Video</h6>
                                                                                                                                                                            <h4 class="fs-6 mb-0 text-white"><b>' .
                                                                        $m->judul .
                                                                        '</b></h4>
                                                                                                                                                                        </div>
                                                                                                                                                                    </div>
                                                                                                                                                                    </div>

                                                                                                                                                                    <div class="row">
                                                                                                                                                                        <div class="col-12">
                                                                                                                                                                            <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal' .
                                                                        $m->id .
                                                                        '" class="mt-2 btn btn-md btn-primary btn-block btn-icon-text">
                                                                                                                                                                                <i class="ti-control-play btn-icon-prepend"></i> Tonton
                                                                                                                                                                            </button>
                                                                                                                                                                            <!-- Modal Video -->
                                                                                                                                                                            <div class="modal fade" id="exampleModal' .
                                                                        $m->id .
                                                                        '" tabindex="-1" aria-labelledby="exampleModal' .
                                                                        $m->id .
                                                                        'Label" aria-hidden="true">
                                                                                                                                                                                <div class="modal-dialog modal-lg">
                                                                                                                                                                                    <div class="modal-content">
                                                                                                                                                                                        <div class="modal-header">
                                                                                                                                                                                            <h5 class="modal-title" id="exampleModalLabel">' .
                                                                        $m->judul .
                                                                        '</h5>
                                                                                                                                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                                                                                                                        </div>
                                                                                                                                                                                        <div class="modal-body">
                                                                                                                                                                                            <iframe width="100%" height="315" src="https://youtube.com/embed/' .
                                                                        $m->link .
                                                                        '" frameborder="0" allowfullscreen>
                                                                                                                                                                                            </iframe>
                                                                                                                                                                                        </div>
                                                                                                                                                                                    </div>
                                                                                                                                                                                </div>
                                                                                                                                                                            </div>
                                                                                                                                                                            <script>
                                                                                                                                                                                $(document).ready(function() {
                                                                                                                                                                                    $("#exampleModal' . $m -> id .
                                                                                                                                                                                        '").on("hidden.bs.modal", function() {
                                                                                                                                                                                        var iframe = $(this).find("iframe")[0];
                                                                                                                                                                                        var videoSrc = iframe.src; iframe.src = videoSrc;
                                                                                                                                                                                    });
                                                                                                                                                                                });
                                                                                                                                                                            </script>
                                                                                                                                                                        </div>
                                                                                                                                                                    </div>
                                                                                                                                                                ';
                                                                } else {
                                                                    // Jika jenis != 1 -> PDF / Materi
                                                                    echo '
                                                                                                                                                                            <img class="img-lock" src="https://apps.belajarsoal.id/image/global/lock-white.png" alt="">
                                                                                                                                                                        </div>
                                                                                                                                                                        <div class="col-9">
                                                                                                                                                                            <h6 class="text-sm text-white">Materi</h6>
                                                                                                                                                                            <h4 class="fs-6 mb-0 text-white"><b>' .
                                                                        $m->judul .
                                                                        '</b></h4>
                                                                                                                                                                        </div>
                                                                                                                                                                    </div>
                                                                                                                                                                    </div>
                                                                                                                                                                    <div class="row">
                                                                                                                                                                        <div class="col-12">
                                                                                                                                                                            <a target="_blank" href="' .
                                                                        asset($m->link) .
                                                                        '">
                                                                                                                                                                                <button type="button" class="btn btn-md btn-primary btn-block btn-icon-text">
                                                                                                                                                                                    <i class="ti-eye btn-icon-prepend"></i> Lihat Materi
                                                                                                                                                                                </button>
                                                                                                                                                                            </a>
                                                                                                                                                                        </div>
                                                                                                                                                                    </div>
                                                                                                                                                                ';
                                                                }
                                                                echo '
                                                                                                                                                                </div>
                                                                                                                                                            </div>
                                                                                                                                                        </div>
                                                                                                                                                    </li>
                                                                                                                                                    ';
                                                            }
                                                        }
                                                    }
                                                }

                                                echo '
                                                                                                                                    <div class="row d-block">
                                                                                                                                        <button style="width:50px;" class="mt-4 mb-4 btn btn-sm btn-info btn-icon-text d-none" id="matkatback" onclick="matkatback()">
                                                                                                                                            <i class="ti ti-arrow-left"></i>
                                                                                                                                        </button>
                                                                                                                                    </div>
                                                                                                                                    <ul class="mainkat row">
                                                                                                                                    ';
                                                matkats($kategoris, $materi_kats, true);
                                                echo '
                                                                                                                                    </ul>
                                                                                                                                    ';
                                            @endphp
                                        @else
                                            <center>
                                                <img class="mb-3 img-no" src="{{ asset('image/global/no-paket.png') }}"
                                                    alt="">
                                            </center>
                                            <br>
                                            <center class="text-white">Belum Ada Data</center>
                                        @endif
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
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        $(document).ready(function() {
            console.log("Document list paket ready");

            // Fungsi Mode Tryout
            $(document).on('click', '.btn-kerjakan', function(e) {
                var idform = $(this).attr('idform');
                var formData = new FormData($('#formKerjakan_' + idform)[0]);
                var url = "{{ url('/mulaiujianpublic') }}/" + idform;
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
                                    reload_url(0, '{{ url('ujianpublic') }}/' + response
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
                                            '{{ url('ujianpublic') }}/' + response
                                            .idpaket;
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
                                            url: "{{ url('selesaiujian') }}",
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

            // Fungsi Mode Belajar
            $(document).on('click', '.btn-kerjakan-belajar', function(e) {
                var idform = $(this).attr('idform');
                var formData = new FormData($('#formKerjakanBelajar_' + idform)[0]);
                var url = "{{ url('/mulaibelajarpublic') }}/" + idform;
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
                                    reload_url(0, '{{ url('belajarpublic') }}/' +
                                        response.id);
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
                                            '{{ url('belajarpublic') }}/' + response
                                            .idpaket;
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

        function latihan() {
            $('[href="#latihan"]').tab('show');
        }
    </script>
@endsection
