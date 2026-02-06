@extends('layouts.Skydash')



@section('content')

<div class="content-wrapper">

  <div class="row">

    <div class="col-md-12 grid-margin stretch-card">

      <div class="cardx card-border w-100">

        <div class="card-bodyx">

          <nav aria-label="breadcrumb">

            <ol class="breadcrumb">

              <li class="breadcrumb-item"><a href="{{url('home')}}"><i class="fas fa-home"></i></a></li>

              <li class="breadcrumb-item active" aria-current="page"><a href="{{url('belipaketktg')}}">Beli Paket</a></li>

              <li class="breadcrumb-item active" aria-current="page"><a href="{{url('belipaketsubktg')}}/{{Crypt::encrypt($subkategori->fk_paket_kategori)}}">{{$subkategori->kategori_r->judul}}</a></li>

              <li class="breadcrumb-item active" aria-current="page">{{$subkategori->judul}}</li>

            </ol>

          </nav>

          <p class="card-description">

            <h3 class="font-weight-bold"><b>Pilih Paket</b></h3>

          </p>

          <div class="row mt-4">

         @php
  $isAnyPaketDisplayed = false;
@endphp

@forelse($paket as $key)
  @if($key->is_gratis != 1)
    @php
      $isAnyPaketDisplayed = true;
    @endphp

            <div class="col-md-4  stretch-card mb-4">

              <a href="{{url('paketdetail')}}/{{Crypt::encrypt($key->id)}}" class="hrefpaket d-flex w-100">

                <div class="card card-border w-100">

                  

                  <div class="card-body px-7 py-6 w-100">

                    <h3 class="fs-5 text-black mb-4"><b>{{$key->judul}}</b></h3>

                    <div class="row" style="align-items:center">

                      <div class="col-12">

                        <span class="coret me-2 mt-1">{{formatCoret($key->harga)}}</span><span class="btn text-xs btn-sm btn-primary bg-blue py-1 px-2 text-sm me-3">Diskon 50%</span>

                        <div class="fs-3 text-black fw-bold mt-1 mb-4">{{formatRupiah($key->harga)}}</div>

						

                      </div>

                    </div>

                    <h6>/ {{count($key->paket_dtl_r)}} Paket</h6>

					

					<div class="row mt-3"> 

                

						@foreach($key->fitur_r as $keydata)  

						<div class="col-md-12 mt-3">

						  <div class="row" style="align-items:center">

							<div class="col-2 col-md-2 pe-0">

							  <img src="{{ asset('image/global/check.png') }}" alt="check" >

							</div>

							<div class="col-10 col-md-10 ps-0">

							  <span>{{$keydata->judul}}</span>

							</div>

						  </div>

						</div>

						@endforeach

						

				  </div>

                    <button class="mt-4  btn btn-md btn-primary fw-600 btn-block py-3 border-2 rounded-3 border-blue text-blue bg-white">Lihat Paket</button>

                  </div>

                </div>

              </a>

            </div>
             @endif

            @empty

            <center><img class="mb-3 img-no" src="{{asset('image/global/no-paket.png')}}" alt=""></center>

            <br>

            <center>Belum Ada Data</center>

            @endforelse
            
            @if(!$isAnyPaketDisplayed)
  <div class="text-center"> <!-- Sesuaikan class untuk styling -->
    <p>Tidak Ada Paket yang Tersedia</p>
  </div>
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

var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {

  return new bootstrap.Tooltip(tooltipTriggerEl)

})

  $(document).ready(function(){

    $( "#paket{{$subkategori->fk_paket_kategori}}" ).addClass( "active" );

  });

</script>

<!-- Loading Overlay -->

@endsection





