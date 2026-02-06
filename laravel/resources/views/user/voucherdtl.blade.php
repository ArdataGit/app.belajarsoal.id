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
              <li class="breadcrumb-item active" aria-current="page">Voucher</li>
            </ol>
          </nav>
          <p class="card-description">
            <center>
              <!-- <h3 class="mb-2 font-weight-bold"><b>{{$data->judul}}</b></h3> -->
              <img style="border-radius:10px" src="{{asset($data->gambar)}}" alt="" width="100%">
            </center>
            <!-- <h6 class="mt-3"><i>{{tglIndo($data->created_at)}}</i></h6> -->
            <p class="mt-3">
              {{$data->ket}}
            </p>
            <h6 class="mt-3">Kode Voucher : </h6>
            <center><h2>{{$data->kode}}</h2></center>
          </p>
          <div class="row mt-4">
            
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


