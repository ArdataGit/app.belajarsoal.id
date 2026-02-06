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
    </style>

<script>
  kategoris = [];
  @php
    if($kategoris){
      echo '
  katroot = ['.implode(",", $kategoris[0]).'];
  matkatbackid = 0;
  zoomkatbackid = 0;
  detailkatbackid = 0;
  cermatkatbackid = 0;
  ';

      foreach($kategoris as $id=>$kategori){
        if($id){
          $parents = $kategori['parents'] ? implode(',', $kategori['parents']) : '';
          $items = $kategori['items'] ? implode(',', $kategori['items']) : '';
          echo '
  kategoris['.$id.'] = {
  "root_id": '.$kategori['root_id'].',
  "parent_id": '.$kategori['parent_id'].',
  "name": "'.$kategori['name'].'",
  "parents": ['.$parents.'],
  "items": ['.$items.']
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
                                <li class="breadcrumb-item"><a href="{{ url('home') }}"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page"><a
                                        href="{{ url('paketsayaktg') }}">Paket Saya</a></li>

                            </ol>
                        </nav>
                        <p class="card-description">
                        <h3 class="font-weight-bold"><b>{{ $data->judul }}</b></h3>
                        <h6 class="txt-abu">{!! $data->ket !!}</h6>
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
                                                    data-toggle="pill" href="#latihan">Tryout Pilihan Ganda</a>
                                            </li>
                                         
                                            @endif
                                            @if (count($paketdtlkecermatan) > 0)
                                            <li class="nav-item">
                                                <a class="btn btn-sm btn-primary nav-link btn-tab-hasil {{ $tab == 'latihankecermatan' ? 'active' : '' }}"
                                                    data-toggle="pill" href="#latihankecermatan">Tryout Kecermatan</a>
                                            </li>
                                            @endif
                                            <li class="nav-item">
                                                <a class="btn btn-sm btn-primary nav-link btn-tab-hasil {{ $tab == 'hasillatihan' ? 'active' : '' }}"
                                                    data-toggle="pill" href="#hasillatihan">Hasil Tryout</a>
                                            </li>
											<li class="nav-item">
                                                <a class="btn btn-sm btn-primary nav-link btn-tab-hasil" href="{{url('userclass/'.Crypt::encrypt($data->id))}}">Class</a>
                                            </li>											
                                        </ul>
                                        <div class="tab-content tab-hasil-ujian">
                                            <!-- Button trigger modal -->
                                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                                            <div id="pembelajaran"
                                                class="tab-pane {{ $tab == 'pembelajaran' ? 'active' : '' }}">
                                                @if (count($paketvideo) > 0 || count($paketpdf) > 0)
                                        
                                                    @php                                                                                                                
                                                        function matkats(&$kategoris, $matkats, $isroot){ 
                                                            foreach($matkats as $id=>$kat){
                                                                if($id && isset($kategoris[$id])){
                                                                    $hide = $isroot ? '' : ' d-none';
                                                                    echo '
                                                                    <li class="row d-block'.$hide.'" id="kat-'.$id.'" katid="'.$id.'">
                                                                    <div class="col-md-4 grid-margin stretch-card">
                                                                        <div class="card card-border" style="height: 100%;">
                                                                            <div class="card-body">
                                                                            <div class="row align-items-center mb-3">
                                                                                <div class="col-2">
                                                                                    <div class="icon-card bg-blue rounded-circle iconpaket">
                                                                                        <i class="p-2 ti-layers-alt"></i>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-8">
                                                                                    <h4 class="fs-6 mb-0 ml-2"><b>'.$kategoris[$id]['name'].'</b></h4>
                                                                                    <h6>'.$kategoris[$id]['keterangan'].'</h6>
                                                                                </div>
                                                                            </div>
                                                                            <button class="mt-2 btn btn-md btn-info btn-block btn-icon-text" onclick="matkatclick('.$id.');">Pilih</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <ul class="d-none">
                                                                    ';

                                                                    matkats($kategoris, $kat, false);

                                                                    echo '
                                                                    </ul>
                                                                    </li>
                                                                    ';
                                                                }
                                                            }
                                                            
                                                            foreach($matkats as $id=>$kat){
                                                                if(!$id || !isset($kategoris[$id])){
                                                                    echo '
                                                                    <li class="row d-block">
                                                                    ';
                                                                    foreach($kat as $m){  
                                                                        if($m->jenis==1){
                                                                        echo '
                                                                        <div class="col-md-4 grid-margin stretch-card">
                                                                    <div class="card card-border" style="height: 100%;">
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
                                                                                                src="'.asset('image/global/img-video.png').'"
                                                                                                alt="">
                                                                                        </div>
                                                                                        <div class="col-9">
                                                                                            <h6>Video</h6>
                                                                                            <h4 style="margin-bottom:0px">
                                                                                                <b>'.$m->judul.'</b>
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
                                                                                        data-bs-target="#exampleModal'.$m->id.'"
                                                                                        class="mt-2 btn btn-md btn-primary btn-block btn-icon-text">
                                                                                        <i
                                                                                            class="ti-control-play btn-icon-prepend"></i>
                                                                                        Tonton
                                                                                    </button>

                                                                                    <!-- Modal -->
                                                                                    <div class="modal fade"
                                                                                        id="exampleModal'.$m->id.'"
                                                                                        tabindex="-1"
                                                                                        aria-labelledby="exampleModal'.$m->id.'Label"
                                                                                        aria-hidden="true">
                                                                                        <div class="modal-dialog modal-lg">
                                                                                            <div class="modal-content">
                                                                                                <div class="modal-header">
                                                                                                    <h5 class="modal-title"
                                                                                                        id="exampleModalLabel">
                                                                                                        '.$m->judul.'
                                                                                                    </h5>
                                                                                                    <button type="button"
                                                                                                        class="btn-close"
                                                                                                        data-bs-dismiss="modal"
                                                                                                        aria-label="Close"></button>
                                                                                                </div>
                                                                                                <div class="modal-body">
                                                                                                    <iframe width="100%"
                                                                                                        height="315"
                                                                                                        src="https://youtube.com/embed/{{ $m->link }}"
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
                                                                                            $("#exampleModal'.$m->id.'").on("hidden.bs.modal", function() {
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
                                                                        }else{
                                                                            echo '

                                                                            <div class="col-md-4 grid-margin stretch-card">
                                                                    <div class="card card-border" style="height: 100%;">
                                                                        <div class="card-body p-3">
                                                                            <div class="row align-items-center mb-3"
                                                                                style="flex-wrap: nowrap !important;">
                                                                                <div class="col-2">
                                                                                    <div
                                                                                        class="icon-card bg-blue rounded-circle iconpaket">
                                                                                        <i class="p-1 icon-paper position-relative"
                                                                                            style="top:-2px"></i>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-8 ps-4">
                                                                                    <h6 class="text-sm text-grey">Materi
                                                                                    </h6>
                                                                                    <h4 class="fs-6 mb-0 text-start ml-2">
                                                                                        <b>'.$m->judul.'</b>
                                                                                    </h4>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-12">
                                                                                    <a target="_blank"
                                                                                        href="'.asset($m->link).'">
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
                                                                    }
                                                                    echo '
                                                                    </li>
                                                                    ';
                                                                }
                                                            }

                                                        }
                                                        echo '
                                                        <ul class="mainkat">
                                                        <li class="row d-inline-block">
                                                        <button class="mt-4 mb-4 btn btn-sm btn-info btn-icon-text d-none" id="matkatback" onclick="matkatback()"> <i class="ti ti-arrow-left"></i> </button>    
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
                                                <center>Belum Ada Data</center>
                                                @endif
                                            </div>

                                            <div id="latihan" class="tab-pane {{ $tab == 'latihan' ? 'active' : '' }}">
                                                <hr>
                                                <br>
                                                @if (count($paketdtl) > 0)

                                                @php                                                                                                                
                                                        function detailkats(&$kategoris, $matkats, $isroot){
                                                            global $idpaketdtl; 
                                                            foreach($matkats as $id=>$kat){
                                                                if($id && isset($kategoris[$id])){
                                                                    $hide = $isroot ? '' : ' d-none';
                                                                    echo '
                                                                    <li class="row d-block'.$hide.'" id="kat-'.$id.'" katid="'.$id.'">
                                                                    <div class="col-md-4 grid-margin stretch-card">
                                                                        <div class="card card-border" style="height: 100%;">
                                                                            <div class="card-body">
                                                                            <div class="row align-items-center mb-3">
                                                                                <div class="col-2">
                                                                                    <div class="icon-card bg-blue rounded-circle iconpaket">
                                                                                        <i class="p-2 ti-layers-alt"></i>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-8">
                                                                                    <h4 class="fs-6 mb-0 ml-2"><b>'.$kategoris[$id]['name'].'</b></h4>
                                                                                    <h6>'.$kategoris[$id]['keterangan'].'</h6>
                                                                                </div>
                                                                            </div>
                                                                            <button class="mt-2 btn btn-md btn-info btn-block btn-icon-text" onclick="detailkatclick('.$id.');">Pilih</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <ul class="d-none">
                                                                    ';

                                                                    detailkats($kategoris, $kat, false);

                                                                    echo '
                                                                    </ul>
                                                                    </li>
                                                                    ';
                                                                }
                                                            }
                                                            
                                                            foreach($matkats as $id=>$kat){
                                                                if(!$id || !isset($kategoris[$id])){
                                                                    echo '
                                                                    <li class="row d-block">
                                                                    ';
                                                                    foreach($kat as $m){  

                                                                        echo '

                                                                        <div class="col-md-4 grid-margin stretch-card">
                                                                <div class="card card-border" style="height: 100%;">
                                                                    <div class="card-body p-3">
                                                                        <div class="row align-items-center mb-3"
                                                                            style="flex-wrap: nowrap !important;">
                                                                            <div class="col-2">
                                                                                <div
                                                                                    class="icon-card bg-blue rounded-circle iconpaket">
                                                                                    <i class="p-1 icon-paper position-relative"
                                                                                        style="top:-2px"></i>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-8 ps-4">
                                                                                <h6 class="text-sm text-grey">Latihan</h6>
                                                                                <h4 class="fs-6 mb-0 text-start ml-2">
                                                                                    <b>'.$m->paket_mst_r->judul.'</b>
                                                                                </h4>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <button data-bs-toggle="modal"
                                                                                    data-bs-target="#myModal_'.$m->id.'"
                                                                                    type="button"
                                                                                    class="rounded-pill btn btn-md btn-primary btn-block btn-icon-text bg-green">
                                                                                    <i
                                                                                        class="fa fa-edit btn-icon-prepend"></i>
                                                                                    Kerjakan Soal
                                                                                </button>
                                                                                <a href="'.url('rankingpaket').'/'. Crypt::encrypt($m->paket_mst_r->id).'"
                                                                                    type="button"
                                                                                    class="mt-2 rounded-pill btn btn-md btn-new btn-block btn-icon-text bg-blue text-white">
                                                                                    <i
                                                                                        class="fas fa-trophy btn-icon-prepend"></i>
                                                                                    Peringkat
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- The Modal -->
                                                            <div class="modal fade" id="myModal_'.$m->id.'">
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
                                                                                            <td>'.$m->paket_mst_r->judul.'
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>Jumlah Soal</td>
                                                                                            <td>'.$m->paket_mst_r->total_soal.'
                                                                                                Soal</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>Waktu Mengerjakan</td>
                                                                                            <td>'.$m->paket_mst_r->waktu.'
                                                                                                Menit</td>
                                                                                        </tr>';
                                                                                        if ($m->paket_mst_r->ket){
                                                                                            echo '
                                                                                            <tr>
                                                                                                <td>Keterangan</td>
                                                                                                <td>'.$m->paket_mst_r->ket.'
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
                                                                                <li>
                                                                                    Jika waktu masi tersisa dan soal sudah
                                                                                    selesai dikerjakan, silahkan klik tombol
                                                                                    selesai ujian maka nilai akan keluar
                                                                                    otomatis
                                                                                </li>
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
                                                                                id="formKerjakan_'.$m->id.'"
                                                                                class="form-horizontal">
                                                                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                                                                <input type="hidden" name="idpaketdtl[]"
                                                                                    value="'.Crypt::encrypt($idpaketdtl).'">
                                                                                <input type="hidden"
                                                                                    name="id_paket_soal_mst[]"
                                                                                    value="'.Crypt::encrypt($m->paket_mst_r->id).'">
                                                                                <button type="button"
                                                                                    class="btn btn-outline-secondary"
                                                                                    data-bs-dismiss="modal">Batal</button>
                                                                                <button type="button"
                                                                                    class="btn btn-primary btn-kerjakan"
                                                                                    idform="'.$m->id.'">Kerjakan
                                                                                    Sekarang</button>
                                                                            </form>
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
                                                        echo '
                                                        <ul class="mainkat detailkats">
                                                        <li class="row d-inline-block">
                                                        <button class="mt-4 mb-4 btn btn-sm btn-info btn-icon-text d-none" id="detailkatback" onclick="detailkatback()"> <i class="ti ti-arrow-left"></i> </button>    
                                                        </li>
                                                        ';

                                                        detailkats($kategoris, $detail_kats, true);
                                                        echo '
                                                        </ul>
                                                        ';
                                                    @endphp
                                                
                                                @else
                                                    <center><img class="mb-3 img-no"
                                                            src="{{ asset('image/global/no-paket.png') }}"
                                                            alt=""></center>
                                                    <br>
                                                    <center>Belum Ada Data</center>
                                                @endif
                                            </div>

                                            <div id="latihankecermatan" class="tab-pane {{ $tab == 'latihankecermatan' ? 'active' : '' }}">
                                                <hr>
                                                <br>
                                                @if (count($paketdtlkecermatan) > 0)

                                                @php                                                                                                                
                                                        function cermatkats(&$kategoris, $matkats, $isroot){
                                                            global $idpaketdtl; 
                                                            foreach($matkats as $id=>$kat){
                                                                if($id && isset($kategoris[$id])){
                                                                    $hide = $isroot ? '' : ' d-none';
                                                                    echo '
                                                                    <li class="row d-block'.$hide.'" id="kat-'.$id.'" katid="'.$id.'">
                                                                    <div class="col-md-4 grid-margin stretch-card">
                                                                        <div class="card card-border" style="height: 100%;">
                                                                            <div class="card-body">
                                                                            <div class="row align-items-center mb-3">
                                                                                <div class="col-2">
                                                                                    <div class="icon-card bg-blue rounded-circle iconpaket">
                                                                                        <i class="p-2 ti-layers-alt"></i>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-8">
                                                                                    <h4 class="fs-6 mb-0 ml-2"><b>'.$kategoris[$id]['name'].'</b></h4>
                                                                                    <h6>'.$kategoris[$id]['keterangan'].'</h6>
                                                                                </div>
                                                                            </div>
                                                                            <button class="mt-2 btn btn-md btn-info btn-block btn-icon-text" onclick="cermatkatclick('.$id.');">Pilih</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <ul class="d-none">
                                                                    ';

                                                                    cermatkats($kategoris, $kat, false);

                                                                    echo '
                                                                    </ul>
                                                                    </li>
                                                                    ';
                                                                }
                                                            }
                                                            
                                                            foreach($matkats as $id=>$kat){
                                                                if(!$id || !isset($kategoris[$id])){
                                                                    echo '
                                                                    <li class="row d-block">
                                                                    ';
                                                                    foreach($kat as $m){  

                                                                        echo '

                                                                        <div class="col-md-4 grid-margin stretch-card">
                                                                <div class="card card-border" style="height: 100%;">
                                                                    <div class="card-body p-3">
                                                                        <div class="row align-items-center mb-3"
                                                                            style="flex-wrap: nowrap !important;">
                                                                            <div class="col-2">
                                                                                <div
                                                                                    class="icon-card bg-blue rounded-circle iconpaket">
                                                                                    <i class="p-1 icon-paper position-relative"
                                                                                        style="top:-2px"></i>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-8 ps-4">
                                                                                <h6 class="text-sm text-grey">Latihan</h6>
                                                                                <h4 class="fs-6 mb-0 text-start ml-2">
                                                                                    <b>'.$m->paket_soal_mst_kecermatan_r->judul.'</b>
                                                                                </h4>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <button data-bs-toggle="modal"
                                                                                    data-bs-target="#myModalKecermatan_'.$m->id.'"
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
                                                            <div class="modal fade" id="myModalKecermatan_'.$m->id.'">
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
                                                                                            <td>'.$m->paket_soal_mst_kecermatan_r->judul.'
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>Jumlah Soal</td>
                                                                                            <td>'.$m->paket_soal_mst_kecermatan_r->total_soal.'
                                                                                                Soal</td>
                                                                                        </tr>
                                                                                        ';
                                                                                        if ($m->paket_soal_mst_kecermatan_r->ket){
                                                                                            echo '
                                                                                            <tr>
                                                                                                <td>Keterangan</td>
                                                                                                <td>'.$m->paket_soal_mst_kecermatan_r->ket.'
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
                                                                                id="formKerjakanKecermatan_'.$m->id.'"
                                                                                class="form-horizontal">
                                                                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                                                                <input type="hidden" name="idpaketdtl[]"
                                                                                    value="'.Crypt::encrypt($idpaketdtl).'">
                                                                                <input type="hidden"
                                                                                    name="id_paket_soal_mst[]"
                                                                                    value="'.Crypt::encrypt($m->paket_soal_mst_kecermatan_r->id).'">
                                                                                <button type="button"
                                                                                    class="btn btn-outline-secondary"
                                                                                    data-bs-dismiss="modal">Batal</button>
                                                                                <button type="button"
                                                                                    class="btn btn-primary btn-kerjakan-kecermatan"
                                                                                    idform="'.$m->id.'">Kerjakan
                                                                                    Sekarang</button>
                                                                            </form>
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
                                                        echo '
                                                        <ul class="mainkat cermatkats">
                                                        <li class="row d-inline-block">
                                                        <button class="mt-4 mb-4 btn btn-sm btn-info btn-icon-text d-none" id="cermatkatback" onclick="cermatkatback()"> <i class="ti ti-arrow-left"></i> </button>    
                                                        </li>
                                                        ';
                                                        cermatkats($kategoris, $cermat_kats, true);
                                                        echo '
                                                        </ul>
                                                        ';
                                                    @endphp

                                                @else
                                                    <center><img class="mb-3 img-no"
                                                            src="{{ asset('image/global/no-paket.png') }}"
                                                            alt=""></center>
                                                    <br>
                                                    <center>Belum Ada Data</center>
                                                @endif
                                            </div>
                                            <div id="zoom" class="tab-pane {{ $tab == 'zoom' ? 'active' : '' }}">
                                                @if (count($paketzoom) > 0)

                                                    @php                                                                                                                
                                                        function zoomkats(&$kategoris, $matkats, $isroot){ 
                                                            foreach($matkats as $id=>$kat){
                                                                if($id && isset($kategoris[$id])){
                                                                    $hide = $isroot ? '' : ' d-none';
                                                                    echo '
                                                                    <li class="row d-block'.$hide.'" id="kat-'.$id.'" katid="'.$id.'">
                                                                    <div class="col-md-4 grid-margin stretch-card">
                                                                        <div class="card card-border" style="height: 100%;">
                                                                            <div class="card-body">
                                                                            <div class="row align-items-center mb-3">
                                                                                <div class="col-2">
                                                                                    <div class="icon-card bg-blue rounded-circle iconpaket">
                                                                                        <i class="p-2 ti-layers-alt"></i>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-8">
                                                                                    <h4 class="fs-6 mb-0 ml-2"><b>'.$kategoris[$id]['name'].'</b></h4>
                                                                                    <h6>'.$kategoris[$id]['keterangan'].'</h6>
                                                                                </div>
                                                                            </div>
                                                                            <button class="mt-2 btn btn-md btn-info btn-block btn-icon-text" onclick="zoomkatclick('.$id.');">Pilih</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <ul class="d-none">
                                                                    ';

                                                                    zoomkats($kategoris, $kat, false);

                                                                    echo '
                                                                    </ul>
                                                                    </li>
                                                                    ';
                                                                }
                                                            }
                                                            
                                                            foreach($matkats as $id=>$kat){
                                                                if(!$id || !isset($kategoris[$id])){
                                                                    echo '
                                                                    <li class="row d-block">
                                                                    ';
                                                                    foreach($kat as $m){  

                                                                        echo '

                                                                        <div class="col-md-4 grid-margin stretch-card">
                                                                <div class="card card-border" style="height: 100%;">
                                                                    <div class="card-body">
                                                                        <div class="row align-items-center mb-3"
                                                                            style="flex-wrap: nowrap !important;">
                                                                            <div class="col-2">
                                                                                <div
                                                                                    class="icon-card bg-blue rounded-circle iconpaket">
                                                                                    <i class="p-1 icon-video position-relative"
                                                                                        style="top:-2px"></i>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-8 ps-4">
                                                                                <h6 class="text-sm text-grey">Zoom</h6>
                                                                                <h4 class="fs-6 mb-0 text-start ml-2">
                                                                                    <b>'.$m->judul.'</b>
                                                                                </h4>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <a target="_blank"
                                                                                    href="'.asset($m->link).'">
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

                                                                    }
                                                                    echo '
                                                                    </li>
                                                                    ';
                                                                }
                                                            }

                                                        }
                                                        echo '
                                                        <ul class="mainkat">
                                                        <li class="row d-inline-block">
                                                        <button class="mt-4 mb-4 btn btn-sm btn-info btn-icon-text d-none" id="zoomkatback" onclick="zoomkatback()"> <i class="ti ti-arrow-left"></i> </button>    
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
                                                <center>Belum Ada Data</center>
                                                @endif
                                            </div>
                                            <div id="hasillatihan"
                                                class="tab-pane {{ $tab == 'hasillatihan' ? 'active' : '' }}">
                                                <hr>
                                                <br>
                                                <!-- @if (count($hasilujian) > 0) -->
                                                    <div class="table-responsive">
                                                        <table class="table table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>JENIS</th>
                                                                    <th>NAMA LATIHAN</th>
                                                                    <th>TANGGAL</th>
                                                                    <th>SKOR AKHIR</th>
                                                                    <th>OPSI</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                @foreach ($hasilujian as $key)
                                                                    <tr>
                                                                        <td width="1%">{{ $loop->iteration }}</td>
                                                                        <td width="1%">PILIHAN GANDA</td>
                                                                        <td width="30%">{{ $key->judul }}</td>
                                                                        <td width="10%">
                                                                            {{ Carbon\Carbon::parse($key->mulai)->translatedFormat('l, d F Y , H:i:s') }}
                                                                        </td>
                                                                        <!-- <td width="5%">{{ $key->kkm }}</td> -->
                                                                        <td width="10%" style="text-align:center">
                                                                            {{ $key->point <= 0 ? 0 : $key->point }}
                                                                        </td>
                                                                        @php
                                                                            if ($key->point < $key->kkm) {
                                                                                $lulus = 0;
                                                                            } else {
                                                                                $lulus = 1;
                                                                            }
                                                                        @endphp
                                                                        <!-- <td width="10%">
                                                                                              <label class="{{ statuslulus($lulus, 2) }}">{{ statuslulus($lulus, 1) }}</label>
                                                                                              <a href="{{ url('detailhasil') }}/{{ Crypt::encrypt($key->id) }}">
                                                                                                <label class="_hover badge badge-info">Pembahasan</label>
                                                                                              </a>
                                                                                            </td> -->
                                                                        <td width="10%">
                                                                            <!-- <label class="{{ statuslulus($lulus, 2) }}">{{ statuslulus($lulus, 1) }}</label> -->
                                                                            <a target="_blank"
                                                                                href="{{ url('detailhasil') }}/{{ Crypt::encrypt($key->id) }}">
                                                                                <button class="btn btn-new btn-sm">
                                                                                    <i
                                                                                        class="fas fa-external-link-alt"></i>
                                                                                    Pembahasan
                                                                                </button>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach

                                                                @foreach ($hasilujiankecermatan as $key)
                                                                    <tr>
                                                                        <td width="1%">{{ $loop->iteration }}</td>
                                                                        <td width="1%">KECERMATAN</td>
                                                                        <td width="30%">{{ $key->judul }}</td>
                                                                        <td width="10%">
                                                                            {{ Carbon\Carbon::parse($key->mulai)->translatedFormat('l, d F Y , H:i:s') }}
                                                                        </td>
                                                                        <!-- <td width="5%">{{ $key->kkm }}</td> -->
                                                                        <td width="10%" style="text-align:center">
                                                                            {{ $key->nilai <= 0 ? 0 : $key->nilai }}
                                                                        </td>
                                                                        @php
                                                                            if ($key->nilai < $key->kkm) {
                                                                                $lulus = 0;
                                                                            } else {
                                                                                $lulus = 1;
                                                                            }
                                                                        @endphp
                                                                        <!-- <td width="10%">
                                                                                              <label class="{{ statuslulus($lulus, 2) }}">{{ statuslulus($lulus, 1) }}</label>
                                                                                              <a href="{{ url('detailhasil') }}/{{ Crypt::encrypt($key->id) }}">
                                                                                                <label class="_hover badge badge-info">Pembahasan</label>
                                                                                              </a>
                                                                                            </td> -->
                                                                        <td width="10%">
                                                                            <!-- <label class="{{ statuslulus($lulus, 2) }}">{{ statuslulus($lulus, 1) }}</label> -->
                                                                            <a target="_blank"
                                                                                href="{{ url('detailhasilkecermatan') }}/{{ Crypt::encrypt($key->id) }}">
                                                                                <button class="btn btn-new btn-sm">
                                                                                    <i
                                                                                        class="fas fa-external-link-alt"></i>
                                                                                    Pembahasan
                                                                                </button>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                <!-- @else
                                                    <center><img class="mb-3 img-no"
                                                            src="{{ asset('image/global/no-paket.png') }}"
                                                            alt=""></center>
                                                    <br>
                                                    <center>Belum Ada Data</center>
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
                $(document).on('click', '.btn-kerjakan-kecermatan', function (e) {
                    idform = $(this).attr('idform');
                    var formData = new FormData($('#formKerjakanKecermatan_' + idform)[0]);

                    var url = "{{ url('/mulaiujiankecermatan') }}/"+idform;
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
                            $.LoadingOverlay("show", {
                                image       : "{{asset('/image/global/loading.gif')}}"
                            });
                        },
                        success: function (response) {
                                if (response.status == true) {
                                $('.modal').modal('hide');
                                Swal.fire({
                                    html: response.message,
                                    icon: 'success',
                                    showConfirmButton: false
                                    });
                                    reload_url(0, '{{ url('ujiankecermatan') }}/' + response.id);
                                }else{
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
                                                window.location.href = '{{ url('ujiankecermatan') }}/' +
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
                        error: function (xhr, status) {
                            alert('Error!!!');
                        },
                        complete: function () {
                            $.LoadingOverlay("hide");
                        }
                    });
                });

        });

        function matkatclick(id){
            if(!id)return;
            matkatbackid = id;
            $('#matkatback').removeClass('d-none');
            $('#kat-'+ id + ' > div').addClass('d-none');
            $('#kat-'+ id + ' > ul').removeClass('d-none');            
            $('#kat-'+ id).siblings('li').find('div').addClass('d-none');
            $('#kat-'+ id).siblings('li').find('ul').addClass('d-none');
        }

        function matkatback(id){
            var id = matkatbackid;
            if(!id)return;

            var elm = document.getElementById('kat-'+ id);
            var parent = elm.parentElement.parentElement;

            if(parent.tagName==='LI'){
                matkatbackid = parent.getAttribute('katid');
            }else{
                matkatbackid = 0;
                $('#matkatback').addClass('d-none');
            }
            
            $('#kat-'+ id + ' > div').removeClass('d-none');
            $('#kat-'+ id + ' > ul').addClass('d-none');

            $('#kat-'+ id).siblings('li').find('div').removeClass('d-none');
            $('#kat-'+ id).siblings('li').find('ul').addClass('d-none');
        }

        function zoomkatclick(id){
            if(!id)return;
            zoomkatbackid = id;
            $('#zoomkatback').removeClass('d-none');
            $('#kat-'+ id + ' > div').addClass('d-none');
            $('#kat-'+ id + ' > ul').removeClass('d-none');            
            $('#kat-'+ id).siblings('li').find('div').addClass('d-none');
            $('#kat-'+ id).siblings('li').find('ul').addClass('d-none');
        }

        function zoomkatback(id){
            var id = zoomkatbackid;
            if(!id)return;

            var elm = document.getElementById('kat-'+ id);
            var parent = elm.parentElement.parentElement;

            if(parent.tagName==='LI'){
                zoomkatbackid = parent.getAttribute('katid');
            }else{
                zoomkatbackid = 0;
                $('#zoomkatback').addClass('d-none');
            }
            
            $('#kat-'+ id + ' > div').removeClass('d-none');
            $('#kat-'+ id + ' > ul').addClass('d-none');

            $('#kat-'+ id).siblings('li').find('div').removeClass('d-none');
            $('#kat-'+ id).siblings('li').find('ul').addClass('d-none');
        }

        function detailkatclick(id){
            if(!id)return;
            detailkatbackid = id;
            $('#detailkatback').removeClass('d-none');
            $('.detailkats #kat-'+ id + ' > div').addClass('d-none');
            $('.detailkats #kat-'+ id + ' > ul').removeClass('d-none');            
            $('.detailkats #kat-'+ id).siblings('li').find('div').addClass('d-none');
            $('.detailkats #kat-'+ id).siblings('li').find('ul').addClass('d-none');
        }

        function detailkatback(id){
            var id = detailkatbackid;
            if(!id)return;

//            var elm = document.getElementById('kat-'+ id);
            var elm = document.querySelector('.detailkats #kat-'+ id);
            var parent = elm.parentElement.parentElement;

            if(parent.tagName==='LI'){
                detailkatbackid = parent.getAttribute('katid');
            }else{
                detailkatbackid = 0;
                $('#detailkatback').addClass('d-none');
            }
            
            $('.detailkats #kat-'+ id + ' > div').removeClass('d-none');
            $('.detailkats #kat-'+ id + ' > ul').addClass('d-none');

            $('.detailkats #kat-'+ id).siblings('li').find('div').removeClass('d-none');
            $('.detailkats #kat-'+ id).siblings('li').find('ul').addClass('d-none');
        }

        function cermatkatclick(id){
            if(!id)return;
            cermatkatbackid = id;
            $('#cermatkatback').removeClass('d-none');
            $('.cermatkats #kat-'+ id + ' > div').addClass('d-none');
            $('.cermatkats #kat-'+ id + ' > ul').removeClass('d-none');            
            $('.cermatkats #kat-'+ id).siblings('li').find('div').addClass('d-none');
            $('.cermatkats #kat-'+ id).siblings('li').find('ul').addClass('d-none');
        }

        function cermatkatback(id){
            var id = cermatkatbackid;
            if(!id)return;

            //var elm = document.getElementById('kat-'+ id);
            var elm = document.querySelector('.cermatkats #kat-'+ id);

            var parent = elm.parentElement.parentElement;

            if(parent.tagName==='LI'){
                cermatkatbackid = parent.getAttribute('katid');
            }else{
                cermatkatbackid = 0;
                $('#cermatkatback').addClass('d-none');
            }
            
            $('.cermatkats #kat-'+ id + ' > div').removeClass('d-none');
            $('.cermatkats #kat-'+ id + ' > ul').addClass('d-none');

            $('.cermatkats #kat-'+ id).siblings('li').find('div').removeClass('d-none');
            $('.cermatkats #kat-'+ id).siblings('li').find('ul').addClass('d-none');
        }

    </script>
    <!-- Loading Overlay -->
@endsection
