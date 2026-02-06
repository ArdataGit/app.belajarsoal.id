@extends('layouts.Skydash')

@section('content')
@php
    $template = App\Models\Template::where('id','<>','~')->first();
@endphp
<style>
    .code{
        color:#025ade;
        font-weight:bold;
    }
    .input-foto-error .custom-file-label{
      border: 1px solid red;
    }
</style>

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick-theme.min.css"/>
<div class="content-wrapper">
    <div class="main">
        <div class="row">
            <div class="col-md-2 align-items-stretch">
            </div>

            <div class="col-md-8 align-items-stretch">
              <div class="row">

              <div class="col-md-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <br>
                      <h4>No.Pendaftaran : {{$transaksi->merchant_order_id}}</h4>
                      <!-- <code style="padding:15px 0px">Bayar Sebelum : {{Carbon\Carbon::parse($transaksi->expired)->addSeconds(1)->translatedFormat('l, d F Y , H:i:s')}}</code> -->
                      <br>
                      <h5 class="card-title">Jumlah yang harus dibayar:</h5>
                      <h1 style="text-align:center;color:#025ade;font-weight: bold;">{{formatRupiahCekGratis($transaksi->harga)}}</h1>
                      <br>

                     @if($transaksi->harga>0)
                      <h4 class="card-title">Pembayaran dapat dilakukan ke salah satu nomor rekening / e-wallet dibawah ini:</h4>
                      <!-- <p class="card-description">
                        Add class <code>.icon-lg</code>, <code>.icon-md</code>, <code>.icon-sm</code>
                      </p> -->
                      <div class="table-responsive">
                        <div class="d-none d-md-block d-lg-block">
                          <table class="table table-borderless">
                            <tbody>
                            <tr>
                                <td colspan="2" style="text-align:center;background:antiquewhite;border-radius: 8px;"><h4>Transfer Bank</h4></td>
                            </tr>
                            @foreach($rek->where('kategori',0) as $datarek)
                            <tr>
                                <td class="_bankrek">{{$datarek->nama}} <code class="code">({{$datarek->partner}})</code></td>
                                <td class="_rek">{{$datarek->no}}</td>
                            </tr>
                            @endforeach
                            @foreach($rek->where('kategori',1) as $datarek)
                            <tr>
                                <td colspan="2" style="text-align:center;background:antiquewhite;border-radius: 8px;"><h4>E-Wallet</h4></td>
                            </tr>
                            <tr>
                                <td class="_bankrek">{{$datarek->nama}} <code class="code">({{$datarek->partner}})</code></td>
                                <td class="_rek">{{$datarek->no}}</td>
                            </tr>
                            @endforeach
                            
                            <!-- <tr>
                                <td class="_bankrek">BANK BRI</td>
                                <td class="_rek">12345678910</td>
                            </tr>
                            <tr>
                                <td class="_bankrek">BANK BNI</td>
                                <td class="_rek">12345678910</td>
                            </tr>
                            <tr>
                                <td class="_bankrek">PERMATA BANK</td>
                                <td class="_rek">12345678910</td>
                            </tr>
                            <tr>
                                <td class="_bankrek">BANK MANDIRI</td>
                                <td class="_rek">12345678910</td>
                            </tr> -->
                            </tbody>
                        </table>
                      </div>
                      <br>
                      <div class="d-block d-md-none d-lg-none">
                          <table class="table table-borderless">
                              <tbody>
                              <tr>
                                <td style="text-align:center;background:antiquewhite;border-radius: 8px;padding:0.1rem"><code><h4>Transfer Bank</h4></code></td>
                              </tr>
                              <tr>
                                <td></td>
                              </tr>
                              @foreach($rek->where('kategori',0) as $datarek)
                              <tr>
                                  <td class="_bankrek2">{{$datarek->nama}} <code>({{$datarek->partner}})</code></td>
                              </tr>
                              <tr>
                                  <td class="_rek2">{{$datarek->no}}</td>
                              </tr>
                              @endforeach
                              <tr>
                                <td style="text-align:center;background:antiquewhite;border-radius: 8px;padding:0.1rem"><code><h4>E-Wallet</h4></code></td>
                              </tr>
                              <tr>
                                <td></td>
                              </tr>
                              @foreach($rek->where('kategori',1) as $datarek)
                              <tr>
                                  <td class="_bankrek2">{{$datarek->nama}} <code>({{$datarek->partner}})</code></td>
                              </tr>
                              <tr>
                                  <td class="_rek2">{{$datarek->no}}</td>
                              </tr>
                              @endforeach
                              <!-- <tr>
                                  <td class="_bankrek2">BANK BRI</td>
                              </tr>
                              <tr>
                                  <td class="_rek2">12345678910</td>
                              </tr>
                              <tr>
                                  <td class="_bankrek2">BANK BNI</td>
                              </tr>
                              <tr>
                                  <td class="_rek2">12345678910</td>
                              </tr>
                              <tr>
                                  <td class="_bankrek2">PERMATA BANK</td>
                                </tr>
                              <tr>
                                  <td class="_rek2">12345678910</td>
                              </tr>
                              <tr>
                                  <td class="_bankrek2">BANK MANDIRI</td>
                              </tr>
                              <tr>
                                  <td class="_rek2">12345678910</td>
                              </tr> -->
                              </tbody>
                          </table>
                      </div>
                    </div>
                    <br>
                    <br>
                    @if($transaksi->status==0)
                    <form id="formBuktiBayar" class="form-horizontal" method="post">
                        @csrf
                        <input type="hidden" value="{{Crypt::encrypt($transaksi->id)}}" name="id_transaksi">
                        <div class="form-group row" style="align-items:center">
                            <label class="col-sm-12 col-form-label">Bukti Photo<br><span class="input-keterangan">(jpg/jpeg/png)</span></label>
                            <div class="col-sm-12">
                            <div class="input-group">
                                <div class="custom-file">
                                <input type="file" class="input-foto" id="photo" name="photo" idlabel="label-photo">
                                <label id="label-photo" class="custom-file-label" style="border-radius: .25rem;" for="photo">Choose file</label>
                                </div>
                            </div> 
                            </div>
                        </div>

                        @if($transaksi->bukti)
                        <code>Lihat bukti sebelumnya <a style="color:red" target="_blank" href="{{asset($transaksi->bukti)}}">disini</a>  </code>
                        @endif

                        <div class="col-md-12 grid-margin" style="text-align:center">
                            <button type="submit" class="btn btn-primary btn-icon-text">
                                <i class="ti-back-left btn-icon-prepend"></i>                                                    
                                UPLOAD BUKTI PEMBAYARAN {{$transaksi->bukti ? "KEMBALI" : ""}}
                            </button>   
                        </div>

                        <!-- <div class="col-md-12 grid-margin" style="text-align:center">
                            <a href="https://api.whatsapp.com/send?phone={{$template->no_hp}}&text=Halo Admin Saya {{Auth::user()->name}} ({{Auth::user()->username}}) Mau Upload Bukti Pembayaran dengan Order ID {{$transaksi->merchant_order_id}}" target="_blank" class="btn btn-primary btn-icon-text">
                            <i class="ti-back-left btn-icon-prepend"></i>                                                    
                            UPLOAD BUKTI PEMBAYARAN
                            </a>   
                        </div> -->
                    </form>
                    @else
                    <center>
                        <code>Anda sudah melakukan pembayaran</code>
                    </center>
                    @endif
                    
                    @else
                    <center>
                        <code>Harap tunggu atau hubungi admin untuk konfirmasi pendaftaran</code>
                    </center>
                    @endif
                    </div>
                  </div>
                </div>

               

              </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- jquery-validation -->
<script src="{{ asset('layout/adminlte3/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/jquery-validation/additional-methods.min.js') }}"></script>
<!-- Custom Input File -->
<script src="{{ asset('layout/adminlte3/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('footer')
<!-- jQuery -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- jquery-validation -->
<script src="{{ asset('layout/adminlte3/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/jquery-validation/additional-methods.min.js') }}"></script>
<!-- Custom Input File -->
<script src="{{ asset('layout/adminlte3/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
  $(document).ready(function(){
    bsCustomFileInput.init();

    $(document).on('change', '.input-foto', function (e) {
        var idphoto = $(this).attr('id');
        onlyPhoto(idphoto);
    });

        $('#formBuktiBayar').validate({
            rules: {
                photo: {
                    required:true,
                    extension: "jpeg|jpg|png"
                },
            },
            messages: {
                photo: {
                required: "Bukti photo harus ada",
                extension: "Masukkan format file yang sesuai"
                },
            
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                if (element.hasClass('select')) {     
                    element.parent().addClass('select2-error');
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                }else if (element.hasClass('input-foto')){
                    element.parent().addClass('input-foto-error');
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                }else {                                      
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                }
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
                if(element.tagName.toLowerCase()=='select'){
                var x = element.getAttribute('id');
                $('#'+x).parent().addClass('select2-error');
                }else if(element.tagName.toLowerCase()=='input'){
                var x = element.getAttribute('class');
                var z = element.getAttribute('id');
                if(x=="input-foto is-invalid"){
                    $('#'+z).parent().addClass('input-foto-error');
                }
                }
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
                if(element.tagName.toLowerCase()=='select'){
                var x = element.getAttribute('id');
                $('#'+x).parent().removeClass('select2-error');
                }else if(element.tagName.toLowerCase()=='input'){
                var x = element.getAttribute('class');
                var z = element.getAttribute('id');
                if(x=="input-foto"){
                    $('#'+z).parent().removeClass('input-foto-error');
                }
                }
            },

            submitHandler: function () {

                var formData = new FormData($('#formBuktiBayar')[0]);

                var url = "{{ url('/updateBuktiBayar') }}";
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
                        // $.LoadingOverlay("show");
                    },
                    success: function (response) {
                        if (response.status == true) {
                        Swal.fire({
                            html: response.message,
                            icon: 'success',
                            showConfirmButton: true
                            }).then((result) => {
                                reload_url(500,"{{url('transaksi')}}");
                            });
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
                        // $.LoadingOverlay("hide");
                    }
                });

                }

            });
  });
</script>
<!-- Loading Overlay -->
@endsection