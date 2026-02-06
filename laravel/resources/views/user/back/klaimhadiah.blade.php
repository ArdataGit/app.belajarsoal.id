@extends('layouts.Skydash')
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
  @if(count($paket)>0)
    @foreach($paket as $key)
      <div class="col-md-12 grid-margin-md-0 stretch-card" style="margin-bottom:15px">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-4">
                <img class="img-banner" src="{{asset($key->foto)}}" alt="">
              </div>
              <div class="col-md-5">
                <h3>{{$key->judul}}</h3>
                <h4 style="color:#999999">{!!$key->ket!!}</h4>
              </div>
              <div class="col-md-3" style="text-align:right" id="btn-add-{{$key->id}}">
              @php
                $ceksudah = App\Models\Keranjang::where('fk_user_id',Auth::id())->where('fk_paket_hadiah_id',$key->id)->where('status',0)->first();
              @endphp
              @if($ceksudah)
              <span data-bs-toggle="tooltip" data-bs-placement="top" title="Sudah ditambahkan"> 
                <button class="btn btn-sm btn-success disabled"><i class="ti-check"></i> {{formatRupiah($key->harga)}}</button>
              </span>
              @else
              <span data-bs-toggle="tooltip" data-bs-placement="top" title="Masukkan Keranjang"> 
                <button data-bs-toggle="modal" data-bs-target="#myModal_{{$key->id}}" class="btn btn-sm btn-outline-info"><i class="ti-shopping-cart"></i> {{formatRupiah($key->harga)}}</button>
              </span>
              @endif
              </div>
            </div>
            
          </div>
        </div>
      </div>

      <!-- The Modal -->
      <div class="modal fade" id="myModal_{{$key->id}}">
        <div class="modal-dialog">
          <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Masukkan Keranjang</h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
              Ingin menambahkan paket {{$key->judul}}?
              <h6>Harga : {{formatRupiah($key->harga)}}</h6>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
              <form method="post" id="formKeranjang_{{$key->id}}" class="form-horizontal">
                @csrf
                <input type="hidden" name="fk_paket_hadiah_id[]" value="{{Crypt::encrypt($key->id)}}">
                <button type="button" class="btn btn-primary btn-tambah-keranjang" harga="{{formatRupiah($key->harga)}}" idform="{{$key->id}}">Ya</button>
              </form>
            </div>

          </div>
        </div>
      </div>
      @endforeach
      <div class="col-md-12 grid-margin-md-0 stretch-card" style="margin-bottom:15px">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-12" style="text-align:right">
              <span data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Keranjang"> 
                <a href="{{url('keranjangku')}}" class="btn btn-sm btn-primary">Lihat Keranjang</a>
              </span>
              </div>
            </div>
          </div>
        </div>
      </div>
  @else
    <div style="text-align:center;padding-top:15px">
      <h5>Belum Ada Paket Hadiah</h5>
    </div>
  @endif
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
 
    //Fungsi Tambah Keranjang
    $(document).on('click', '.btn-tambah-keranjang', function (e) {
        idform = $(this).attr('idform');
        harga = $(this).attr('harga');
        
        var formData = new FormData($('#formKeranjang_' + idform)[0]);

        var url = "{{ url('tambahkeranjang') }}";
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
                        position: 'top-end',
                        icon: 'success',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 1500
                      });
                      $("#btn-add-"+idform).html('<span data-bs-toggle="tooltip" data-bs-placement="top" title="Sudah ditambahkan"> <button class="btn btn-sm btn-success disabled"><i class="ti-check"></i> '+harga+'</button></span>');

                      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                          return new bootstrap.Tooltip(tooltipTriggerEl)
                      });
                    }else{
                      $('.modal').modal('hide');
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

  });
</script>
<!-- Loading Overlay -->
@endsection


