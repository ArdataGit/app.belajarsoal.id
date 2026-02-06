@extends('layouts.Skydash')

@section('content')
<div class="content-wrapper">
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card card-border">
        <div class="card-body">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{url('home')}}"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item active" aria-current="page">Beli Paket</li>
            </ol>
          </nav>
          <p class="card-description">
            <h3 class="font-weight-bold"><b>Pilih Kategori</b></h3>
          </p>
          <div class="row mt-4">
            @forelse($kategori as $key)
            <div class="col-md-6 grid-margin stretch-card">
              <a href="{{url('belipaketsubktg')}}/{{Crypt::encrypt($key->id)}}" class="hrefpaket">
                <div class="card card-border" style="height: 100%;">
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
                      <h4><b>{{$key->judul}}</b></h4>
                      <h6>{{$key->ket}}</h6>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            @empty
            <center><img class="mb-3 img-no" src="{{asset('image/global/no-paket.png')}}" alt=""></center>
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
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})
  $(document).ready(function(){
    $(document).on('click', '.btn-kerjakan', function (e) {

    });
  });
</script>
<!-- Loading Overlay -->
@endsection


