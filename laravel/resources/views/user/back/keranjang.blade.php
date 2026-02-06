@extends('layouts.Skydash')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://app-sandbox.duitku.com/lib/js/duitku.js"></script>
<!-- partial -->
<style>
  .modal-footer{
    display: block !important;
    text-align: center;
  }
  .card{
    box-shadow: rgb(0 0 0 / 25%) 0px 54px 55px, rgb(0 0 0 / 12%) 0px -12px 30px, rgb(0 0 0 / 12%) 0px 4px 6px, rgb(0 0 0 / 17%) 0px 12px 13px, rgb(0 0 0 / 9%) 0px -3px 5px !important;
  }
  h5.txt-success{
    font-size:1.125rem;
    margin-bottom:0px;
    color:green;
  }
  h5.txt-danger{
    font-size:1.125rem;
    margin-bottom:0px;
    color:red;
  }
  .template-demo span{
    padding:0px 10px;
  }
  .img-banner{
    width:100%;height:15vw;object-fit:cover;margin-bottom: 0px;border-radius: 20px;
  }
  ._mb-4{
    margin-bottom:1rem;
  }
  .select2-container--default .select2-results__option--highlighted[aria-selected] {
    background: #fd7e14 !important;
  }
  .select2 .select2-selection--single{
    border-radius: 15px !important;
  }
  #ongkir , #ongkir-m{
    color:red;
  }
  @media(max-width: 768px){
    .template-demo span{
       padding:0px 0.5vw;
    } 
    .img-banner{
      height:50vw;
      margin-bottom: 5vw;
    }
    ._mb-4{
      margin-bottom:1vw;
    }
  }
</style>
@section('content')
<div class="content-wrapper">
  <!-- <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-12 col-xl-12 _mb-4" style="text-align:center">
          <h3 class="font-weight-bold">Jadwal</h3>
          <h2 class="font-weight-bold"></h2>
        </div>  
      </div>
    </div>
  </div> -->
  <div class="row mt-3">
  @php
    $total = 0;
  @endphp
  @if(count($data)>0)
    <form id="formBuatPesanan" class="form-horizontal" method="post">
    @csrf
    @foreach($data as $key)
      <div class="col-md-12 grid-margin-md-0 stretch-card" style="margin-bottom:15px">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-4">
                <img class="img-banner" src="{{asset($key->paket_hadiah_r->foto)}}" alt="">
              </div>
              <div class="col-md-5">
                <input type="hidden" class="id_paket" name="id_data[]" value="{{Crypt::encrypt($key->paket_hadiah_r->id)}}">
                <input type="hidden" class="id_keranjang" name="id_data_keranjang[]" value="{{Crypt::encrypt($key->id)}}">
                <h3>{{$key->paket_hadiah_r->judul}}</h3>
                <h4 style="color:#999999">{!!$key->paket_hadiah_r->ket!!}</h4>
              </div>
              <div class="col-md-3" style="text-align:right" id="btn-add-{{$key->id}}">
              {{formatRupiah($key->total_harga)}}
              <span data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Paket"> 
                <button data-bs-toggle="modal" data-bs-target="#myModal_{{$key->id}}" class="btn btn-sm btn-danger"><i class="ti-trash"></i></button>
              </span>
              </div>
            </div>
          </div>
        </div>
      </div>
      @php
        $total +=  $key->total_harga;
      @endphp
      @endforeach

      @if($template->fk_kabupaten)
      <div class="col-md-12 grid-margin-md-0 stretch-card" style="margin-bottom:15px">
        <div class="card">
          <div class="card-body">
            <div class="row" style="align-items: baseline;">
              <div class="col-md-2">
                  <label for=""><h5>Alamat</h5></label>  
              </div>
              <div class="col-md-8">
                <div class="form-group" style="margin-bottom:0px">
                  <select class="form-control form-control-lg" id="alamat" name="alamat">
                  <option value=""></option>
                  </select>
                </div>
              </div>
              <div class="col-md-2" style="text-align:right">
                  <a target="_blank" href="{{url('tambahalamat')}}" class="btn btn-md btn-info">Tambah Alamat</a>  
              </div>
            </div>
            <br>
            <div class="row" style="align-items: baseline;">
              <div class="col-md-2">
                  <label for=""><h5>Kurir</h5></label>  
              </div>
              <div class="col-md-8">
                <div class="form-group" style="margin-bottom:0px">
                  <select class="form-control form-control-lg kurir" id="kurir" name="kurir">
                  <option value=""></option>
                  <option value="jne">JNE</option>
                  <option value="tiki">TIKI</option>
                  <option value="pos">POS</option>
                  </select>
                </div>
              </div>
            </div>
            <br>
            <div class="row" style="align-items: baseline;">
              <div class="col-md-2">
                  <label for=""><h5>Tipe Pengiriman</h5></label>  
              </div>
              <div class="col-md-8">
                <div class="form-group" style="margin-bottom:0px">
                  <select class="form-control form-control-lg tipe" id="tipe" name="tipe">
                  <option value=""></option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-md-12 grid-margin-md-0 stretch-card" style="margin-bottom:15px">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-12" style="text-align:right">
              
              
              <div class="row">
                <div class="col-6 col-md-9 col-lg-9">
                  Jumlah
                </div>
                <div class="col-6 col-md-3 col-lg-3">
                {{formatRupiah($total)}}
                </div>
              </div>
              <div class="row">
                <div class="col-6 col-md-9 col-lg-9">
                  Ongkir
                </div>
                <div class="col-6 col-md-3 col-lg-3">
                 <span id="ongkir">{{formatRupiah(0)}}</span>
                </div>
              </div>
              <b>
              <div class="row">
                <div class="col-6 col-md-9 col-lg-9">
                  Total
                </div>
                <div class="col-6 col-md-3 col-lg-3">
                 <span id="total">{{formatRupiah($total)}}</span>
                </div>
              </div>
              </b>
              <br>
              <span data-bs-toggle="tooltip" data-bs-placement="top" title="Ajukan Pesanan"> 
                <!-- <button id="btn-ajukan-pesanan" data-bs-toggle="modal" data-bs-target="#myModal" class="btn btn-sm btn-primary">Ajukan Pesanan</button> -->
                <button type="submit" class="btn btn-md btn-primary">Ajukan Pesanan</button>
              </span>
             
              </div>
            </div>
          </div>
        </div>
      </div>
      @else
      <div class="col-md-12 grid-margin-md-0 stretch-card" style="margin-bottom:15px">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-12" style="text-align:right">
                <center>Belum bisa memesan paket hadiah, hubungi admin untuk info lebih lanjut</center>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endif
      </form>

      @if($template->fk_kabupaten)

      <!-- The Modal -->
      <div class="modal fade" id="myModal">
        <div class="modal-dialog">
          <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h3 class="modal-title">Detail Pesanan</h3>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
              <table class="table table-borderless">
              <!-- <thead>
                  <tr style="border-bottom:1px solid black">
                    <th colspan="2">Detail Pesanan</th>
                  </tr>
                </thead> -->
                <tbody>
                  @foreach($data as $keynew)
                  <tr>
                    <td>{{$keynew->paket_hadiah_r->judul}}</td>
                    <td style="text-align:right">{{formatRupiah($keynew->total_harga)}}</td>
                  </tr>
                  @endforeach
                  <tr>
                    <td>Ongkir</td>
                    <td style="text-align:right"><span id="ongkir-m"></span></td>
                  </tr>
                  <tr style="border-top:1px solid black">
                    <td>Total</td>
                    <td style="text-align:right;font-weight:bold"><span id="total-m"></span></td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer" id="modal-footer-beli">
                <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">Tidak</button>
                <button id="btn-beli-duitku" type="button" class="btn btn-primary">Ya</button>
            </div>

          </div>
        </div>
      </div>
      @endif

      @foreach($data as $key)
     <!-- The Modal -->
     <div class="modal fade" id="myModal_{{$key->id}}">
        <div class="modal-dialog">
          <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Hapus Paket</h4>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
              Ingin menghapus paket {{$key->paket_hadiah_r->judul}}?
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
              <form method="post" id="formKeranjang_{{$key->id}}" class="form-horizontal">
                @csrf
                <input type="hidden" name="id_data[]" value="{{Crypt::encrypt($key->id)}}">
                <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">Tidak</button>
                <button type="button" class="btn btn-primary btn-hapus-keranjang" idform="{{$key->id}}">Ya</button>
              </form>
            </div>

          </div>
        </div>
      </div>
      @endforeach
  @else
    <div style="text-align:center;padding-top:15px">
      <h5>Belum Ada Paket</h5>
    </div>
  @endif
  </div>
</div>

@endsection

@section('footer')
<!-- jquery-validation -->
<script src="{{ asset('layout/adminlte3/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/jquery-validation/additional-methods.min.js') }}"></script>
<!-- SweetAlert2 -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
  // Initialize tooltips
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})
  $(document).ready(function(){
      var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

      function formatState (txt) {
        if (!txt.id) {
          return txt.text;
        }
        var $txt = $(
          '<span>'+txt.text+'</span>'+'<span style="float:right"><b>' + txt.harga + '</b></span>'
        );
        return $txt;
      };

      $('.kurir').select2({
        placeholder: "Silahkan Pilih Kurir"
      })

      $( "#kurir" ).on('select2:select', function (e) {
        $('#tipe').empty();
        $('#ongkir').html("Rp. 0");
        $('#ongkir-m').html("Rp. 0");
        jumlah = "{{$total}}";
        jumlah = parseInt(jumlah);
        $('#total').html(formatRupiah(jumlah));
        $('#total-m').html(formatRupiah(jumlah));
      });

      $( "#alamat" ).select2({
          placeholder: "Silahkan Pilih Alamat",
          ajax: { 
          url: "{{url('getalamat')}}",
          type: "post",
          dataType: 'json',
          delay: 100,
          data: function (params) {
              return {
              _token: CSRF_TOKEN,
              search: params.term // search term
              };
          },
          processResults: function (response) {
              return {
              results: response.data
              };
          },
          cache: true
          }
      });

      $( "#alamat" ).on('select2:select', function (e) {
        $('#tipe').empty();
        $('#ongkir').html("Rp. 0");
        $('#ongkir-m').html("Rp. 0");
        jumlah = "{{$total}}";
        jumlah = parseInt(jumlah);
        $('#total').html(formatRupiah(jumlah));
        $('#total-m').html(formatRupiah(jumlah));
      });

      $( "#tipe" ).select2({
          templateResult: formatState,
          placeholder: "Silahkan Pilih Tipe Pengiriman",
          ajax: { 
          url: "{{url('cekongkir')}}",
          type: "post",
          dataType: 'json',
          delay: 100,
          data: function (params) {
              return {
              _token: CSRF_TOKEN,
              search: params.term, // search term
              id_kurir:$("#kurir").val(),
              id_alamat : $("#alamat").val(),
              id_paket : $(".id_paket").map(function(){return $(this).val();}).get()
              };
          },
          processResults: function (response) {
            if(response.status){
              return {
                results: $.map(response.data[0]['costs'], function (item) {
                      return {
                          harga:formatRupiah(item['cost'][0]['value']),
                          text: item['service']+" ("+item['description']+") "+item['cost'][0]['etd']+" Hari ",
                          id: item['cost'][0]['value']
                      }
                  })
              };
            }else{
              return {
                results: $.map(response.data, function (item) {
                      return {
                          text: item,
                          id: item
                      }
                  })
              };
            }
          },
          cache: true
          }
      });

      $( "#tipe" ).on('select2:select', function (e) {
        ongkir = $(this).val();
        ongkir = parseInt(ongkir);
        jumlah = "{{$total}}";
        jumlah = parseInt(jumlah);
        total = ongkir + jumlah;
        $('#ongkir').html(formatRupiah(ongkir));
        $('#ongkir-m').html(formatRupiah(ongkir));
        $('#total').html(formatRupiah(total));
        $('#total-m').html(formatRupiah(total));
      });

      // $('.cekongkir').on('change', function (e) {
      //   id_alamat = $("#alamat").val();
      //   id_kurir = $("#kurir").val();
      //   id_tipe = $("#tipe").val();
      //   id_paket = $(".id_paket").map(function(){return $(this).val();}).get();
      //   $.ajaxSetup({
      //       headers: {
      //           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      //       }
      //   });
      //   $.ajax({
      //       type: "POST",
      //       dataType: "JSON",
      //       url: "{{url('cekongkir')}}",
      //       async: false,
      //       data: {
      //         id_alamat :id_alamat,
      //         id_kurir :id_kurir,
      //         id_tipe :id_tipe,
      //         id_paket : id_paket
      //       },
      //       beforeSend: function () {
      //           $.LoadingOverlay("show", {
      //               image       : "{{asset('/image/global/loading.gif')}}"
      //           });
      //       },
      //       success: function(response)
      //       {
      //         if (response.status) {
      //             alert('x');
      //         }else{
      //             Swal.fire({
      //                 html: response.message,
      //                 icon: 'error',
      //                 confirmButtonText: 'Ok'
      //             });
      //         }
      //       },
      //       error: function (xhr, status) {
      //             alert('Error!!!');
      //         },
      //         complete: function () {
      //             $.LoadingOverlay("hide");
      //         }
      //     });
      // });

      // Fungsi Add Data
      $('#formBuatPesanan').validate({
            rules: {
              alamat: {
                required: true
              },
              kurir: {
                required: true
              },
              tipe: {
                required: true
              }
            },
            messages: {
              alamat: {
                required: "Alamat harus dipilih"
              },
              kurir: {
                required: "Kurir harus dipilih"
              },
              tipe: {
                required: "Tipe pengiriman harus dipilih"
              }
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
                  $("#myModal").modal('show');
            }
        });

      //Fungsi Hapus Data
      $(document).on('click', '.btn-hapus-keranjang', function (e) {
        idform = $(this).attr('idform');
        var formData = new FormData($('#formKeranjang_' + idform)[0]);

        var url = "{{ url('hapuskeranjang') }}";
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
                          html: response.message,
                          icon: 'success',
                          showConfirmButton: false
                        });
                        reload(1000);
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
    });

    $( "#btn-beli-duitku" ).click(function() {
          userid = "{{Crypt::encrypt(Auth::id())}}";
          jumlah = "{{$total}}";
          ongkir = $("#tipe").val();

          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.ajax({
              type: "POST",
              data:{
              userid: userid,
              jumlah: jumlah,
              ongkir: ongkir,
              id_alamat: $("#alamat").val(),
              id_paket : $(".id_paket").map(function(){return $(this).val();}).get(),
              id_keranjang : $(".id_keranjang").map(function(){return $(this).val();}).get()
              },
              url: '{{url("createorderhadiah")}}',
              dataType: "json",
              cache: false,
              beforeSend: function () {
                      $.LoadingOverlay("show", {
                          image       : "{{asset('/image/global/loading.gif')}}"
                      });
                      $("#modal-footer-beli").html("");
                      $("#btn-ajukan-pesanan").removeAttr("data-bs-toggle");
                      $("#btn-ajukan-pesanan").removeAttr("data-bs-toggle");
                      $("#btn-ajukan-pesanan").html('<span class="spinner-border spinner-border-sm"></span>Loading..');
                  },
              success: function (result) { 
                      // console.log(result.reference);
                      // console.log(result);
                      $('.modal').modal('hide');
                      checkout.process(result.reference, {
                          successEvent: function(result){
                          // Add Your Action
                              // console.log('success');
                              // console.log(result);
                              $.LoadingOverlay("show", {
                                  image       : "{{asset('/image/global/loading.gif')}}"
                              });

                              // alert('Payment Success');
                              reload_url(1000,"{{url('/transaksi')}}?transaksi=hadiah");

                          },
                          pendingEvent: function(result){
                          // Add Your Action
                              // console.log('pending');
                              // console.log(result);
                              $.LoadingOverlay("show", {
                                  image       : "{{asset('/image/global/loading.gif')}}"
                              });

                              // alert('Payment Pending');
                              reload_url(1000,"{{url('/transaksi')}}?transaksi=hadiah");
                          },
                          errorEvent: function(result){
                          // Add Your Action
                              // console.log('error');
                              // console.log(result);
                              alert('Payment Error');
                          },
                          closeEvent: function(result){
                            reload_url(1000,"{{url('/transaksi')}}?transaksi=hadiah");

                          // Add Your Action
                              // console.log('customer closed the popup without finishing the payment');
                              // console.log(result);
                              // reload_url(1000,"{{url('/topuphistory')}}");
                              // alert('customer closed the popup without finishing the payment');
                          }
                      });  
                      $.LoadingOverlay("hide");                               
              },
              error: function (xhr, status) {
                  alert('Error! Please Try Again');
              },
              complete: function () {
                  $.LoadingOverlay("hide");
                  $("#btn-ajukan-pesanan").html('Complete');
              }
          });
      });

  });
</script>
<!-- Loading Overlay -->
@endsection


