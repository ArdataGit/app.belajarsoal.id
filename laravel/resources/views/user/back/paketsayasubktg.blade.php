@extends('layouts.Skydash')

@section('content')

@php
  $gratis = $gratis ? '/gratis' : '';
@endphp

<div class="content-wrapper">
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="cardx card-border w-100">
        <div class="card-bodyx w-100">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{url('home')}}"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item active" aria-current="page"><a href="{{url('paketsayaktg')}}">Paket Saya</a></li>
              <li class="breadcrumb-item active" aria-current="page">{{$kategori->judul}}</li>
            </ol>
          </nav>
          <p class="card-description">
            <h3 class="font-weight-bold"><b>Pilih {{$kategori->judul}}</b></h3>
          </p>
          <div class="row mt-4">
            @forelse($subkategori as $key)
            <div class="col-md-4 mb-4 stretch-card">
                <div class="card">
                  <div class="card-body py-4">
                    <div class="row align-items-center mb-3" style="flex-wrap: nowrap !important;">
						<div class="col-2">
							
            <div class="icon-card bg-blue rounded-circle iconpaket">
								<i class="p-2 ti-layers-alt"></i>
							</div>

						</div>
						<div class="col-8">
							<h4 class="fs-6 mb-0"><b>{{$key->judul}}</b></h4>
							<div class="text-sm mt-2">{{$key->ket}}</div>
						</div>
					</div>
					<a href="{{url('paketsaya')}}/{{Crypt::encrypt($key->id)}}{{$gratis}}" class="hrefpaket btn btn-primary bg-green text-white rounded-pill d-flex align-items-center justify-content-center">Pilih Paket <i class="ti-arrow-right ms-2" style="font-size: 10pt;"></i></a>
                  </div>
                </div>
				
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


