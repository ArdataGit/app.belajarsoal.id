@extends('layouts.Skydash')

@section('content')
@if(env('DUITKU_SANDBOX_MODE'))
<script src="https://app-sandbox.duitku.com/lib/js/duitku.js"></script>
@else
<script src="https://app-prod.duitku.com/lib/js/duitku.js"></script>
@endif

<style>
  .bg-harga-beli{
    background:#effff1;
    align-items:center;
    text-align:center;
    border-radius:8px;
  }
  .custom-buttom:hover{
    cursor:pointer;
  }
  .bg-primary-custom{
    background: #fea31d;
  }
  .img-lock{
    width: 50px;
    border-top-left-radius: 5px;
    border-bottom-left-radius: 5px;
    padding: 12px;
  }
  .img-btn-beli{
    width:100%;
  }
  .border-top{
    border: 1px solid #cccccc;
    border-top: 6px solid #A95CFF !important;
  }
  @media(max-width: 768px){
    .img-btn-beli{
      width:100%;
    }	
}
</style>
<div class="content-wrapper">
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card card-border">
        <div class="card-body">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{url('home')}}"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item active" aria-current="page"><a href="{{url('belipaketktg')}}">Beli Paket</a></li>
              <li class="breadcrumb-item active" aria-current="page"><a href="{{url('belipaketsubktg')}}/{{Crypt::encrypt($paket->fk_paket_kategori)}}">{{$paket->kategori_r->judul}}</a></li>
              <li class="breadcrumb-item active" aria-current="page"><a href="{{url('belipaket')}}/{{Crypt::encrypt($paket->fk_paket_subkategori)}}">{{$paket->subkategori_r->judul}}</a></li>
              <li class="breadcrumb-item active" aria-current="page">{{$paket->judul}}</li>
            </ol>
          </nav>
          <p class="card-description">
            <h3 class="font-weight-bold"><b>{{$paket->judul}}</b></h3>
            <h6 class="txt-abu">{!!$paket->ket!!}</h6>
          </p>
          <div class="row mt-4">
            <div class="col-md-8">
             <div class="row">
               @forelse($paketdtl as $key)
               <div class="col-md-6 mt-3">
                  <div class="row"  style="align-items:center">
                    <div class="col-12">
                      <div style="border: 1px solid #106571;border-radius:8px;overflow: hidden;">
                        <div class="row">
                          <div class="col-4 col-lg-3 col-md-4 bg-primary-custom" style="justify-content: center;padding-right:0px;display: flex;align-items: center;">
                            <img class="img-lock" src="{{asset('image/global/lock-white.png')}}" alt="">
                          </div>
                          <div class="col-8 col-lg-9 col-md-8" style="align-items:center;display: grid;">
                            <h5 style="margin-bottom:0px"><b>{{$key->paket_mst_r->judul}}</b></h5>
                            <span>{{$key->paket_mst_r->total_soal}} Soal</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
               </div>
               @empty
               <center><img class="mb-3 img-no" src="{{asset('image/global/no-paket.png')}}" alt=""></center>
               <br>
               <center>Belum Ada Data</center>
               @endforelse
             </div>
             <div class="row mt-3"> 
              @foreach($paket->fitur_r as $keydata)  
                <div class="col-md-6 mt-3">
                  <div class="row" style="align-items:center">
                    <div class="col-2 col-md-1 pr-0">
                      <img src="{{asset('image/global/check.png')}}" alt="check" width="100%">
                    </div>
                    <div class="col-10 col-md-11">
                      <span>{{$keydata->judul}}</span>
                    </div>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
            <div class="col-md-4">
              <div class="bg-harga-beli p-4">
                  <h3>HARGA SPESIAL</h3>
                  <h6 class="txt-merah" style="text-decoration: line-through;">{{formatCoret($paket->harga)}}</h6>
                  <h2 class="mb-3"><b>{{formatRupiah($paket->harga)}}</b></h2>
                  @if(!$ceksudahbeli)
                  <a href="{{url('checkout')}}/{{Crypt::encrypt($paket->id)}}" class="custom-buttom"><img src="{{asset('image/global/btn-beli-paket.png')}}" class="img-btn-beli" alt=""></a>
                  @else
                  <span  data-bs-toggle="tooltip" data-bs-placement="left" title="Anda sudah membeli paket ini!" class="custom-buttom disabled"><img src="{{asset('image/global/btn-beli-paket.png')}}" class="img-btn-beli" alt=""></span>
                  @endif
                  <h6 class="mt-3">Ekstra diskon tambahan dengan voucher</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @if(!$ceksudahbeli)
  <!-- The Modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <!-- <div class="modal-header">
          <h3 class="modal-title">Detail Pesanan</h3>
        </div> -->

        <!-- Modal body -->
        <div class="modal-body">

        </div>

        <!-- Modal footer -->
        <div class="modal-footer" id="modal-footer-beli">
            <!-- <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">Tidak</button> -->
            
        </div>

      </div>
    </div>
  </div>
  @endif
</div>
@endsection

@section('footer')
<!-- jquery-validation -->
<script src="{{ asset('layout/adminlte3/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/jquery-validation/additional-methods.min.js') }}"></script>
<!-- SweetAlert2 -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  // Initialize tooltips
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})
  $(document).ready(function(){

          // $(document).on('click', '.btn-beli-paket', function (e) {
          //   $("#myModal").modal('show');
          // });

          // Fungsi Cek Kode
          $('#_formData').validate({
                rules: {
                  kode: {
                    required: true
                  }
                },
                messages: {
                  kode: {
                    required: "Kode voucher harus diisi"
                  }
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                  error.addClass('invalid-feedback');
                  element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                  $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                  $(element).removeClass('is-invalid');
                },

                submitHandler: function () {
                
                  var formData = new FormData($('#_formData')[0]);

                  var url = "{{ url('cekkode') }}";
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
                          $.LoadingOverlay("show");
                      },
                      success: function (response) {
                          if (response.status == true) {
                              Swal.fire({
                                title: response.message,
                                html: "Anda mendapat potongan "+formatRupiah(response.promo),
                                icon: 'success',
                                showConfirmButton: true
                              });
                              $("#jumlahdiskon").html(formatRupiah(response.promo));
                              $("#jumlahtotal").html(formatRupiah(response.total));
                              $("#idpromo").val(response.idpromo);
                          }else{
                            Swal.fire({
                                html: response.message,
                                icon: 'error',
                                confirmButtonText: 'Ok'
                            });
                          }
                      },
                      error: function (xhr, status) {
                          alert('Error!!!');
                      },
                      complete: function () {
                          $.LoadingOverlay("hide");
                      }
                  });   
                }
            });

          $( "#btn-beli-duitku" ).click(function() {

          idpaket = "{{Crypt::encrypt($paket->id)}}";
          idpromo = $("#idpromo").val();

          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.ajax({
              type: "POST",
              data:{
              idpaket: idpaket,
              idpromo:idpromo,
              urlpaket:"{{url()->full()}}"
              },
              url: '{{url("createordertripay")}}',
              dataType: "json",
              cache: false,
              beforeSend: function () {
                      $.LoadingOverlay("show", {
                          image       : "{{asset('/image/global/loading.gif')}}"
                      });
                      // $('.modal').modal('hide');
                      // $("#modal-footer-beli").html("");
                      // $("#btn-ajukan-pesanan").removeAttr("data-bs-toggle");
                      // $("#btn-ajukan-pesanan").removeAttr("data-bs-toggle");
                      // $("#btn-ajukan-pesanan").html('<span class="spinner-border spinner-border-sm"></span>Loading..');
                  },

                  success: function (response) {
                    if (response.success == true) {
                        Swal.fire({
                          html: response.message,
                          icon: 'success',
                          showConfirmButton: false
                        });
                        reload_url(1500,response.url);
                    }else{
                      Swal.fire({
                          html: response.message,
                          icon: 'error',
                          confirmButtonText: 'Ok'
                      });
                    }
                },
              // success: function (result) { 
                      // console.log(result.reference);
                      // console.log(result);
                      // $('.modal').modal('hide');
                      // checkout.process(result.reference, {
                      //     successEvent: function(result){
                     
                      //         $.LoadingOverlay("show", {
                      //             image       : "{{asset('/image/global/loading.gif')}}"
                      //         });

                          
                      //         reload_url(1000,"{{url('/pembelian')}}");

                      //     },
                      //     pendingEvent: function(result){
                       
                      //         $.LoadingOverlay("show", {
                      //             image       : "{{asset('/image/global/loading.gif')}}"
                      //         });

                            
                      //         reload_url(1000,"{{url('/pembelian')}}");
                      //     },
                      //     errorEvent: function(result){
                        
                      //         alert('Payment Error');
                      //     },
                      //     closeEvent: function(result){
                      //       reload_url(1000,"{{url('/pembelian')}}");

                      //     }
                      // });  
                      // $.LoadingOverlay("hide");                               
              // },
              error: function (xhr, status) {
                  alert('Error! Please Try Again');
              },
              complete: function () {
                  $.LoadingOverlay("hide");
                  // $("#btn-ajukan-pesanan").html('Complete');
              }
          });
      });
  });
</script>
<!-- Loading Overlay -->
@endsection

