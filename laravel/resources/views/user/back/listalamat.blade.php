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
  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-10 col-xl-10">
          <h3 class="font-weight-bold">Alamat</h3>
        </div>  
        <div class="col-2 col-xl-2" style="text-align:right">
          <span >
            <h2 class="font-weight-bold"><a data-bs-toggle="tooltip" data-bs-placement="left" title="Tambah ALamat" style="color:black;text-decoration:none" href="{{url('tambahalamat')}}">+</a></h2>
          </span>
        </div>  
      </div>
    </div>
  </div>
  <div class="row mt-3">
  @if(count($data)>0)
    @foreach($data as $key)
      <div class="col-md-12 grid-margin-md-0 stretch-card" style="margin-bottom:15px">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-9">
                <h5>{{$key->nama_penerima}} [{{$key->no_hp_penerima}}]</h5>
                <h6 style="color:#999999">{{$key->alamat_lengkap}} [{{$key->kode_pos}}]</h6>
              </div>
              <div class="col-md-3" style="text-align:right" id="btn-add-{{$key->id}}">
              <span data-bs-toggle="tooltip" data-bs-placement="top" title="Ubah ALamat"> 
                <a href="{{url('ubahalamat')}}/{{Crypt::encrypt($key->id)}}" class="btn btn-sm btn-warning"><i class="ti-pencil"></i> Ubah</a>
              </span>
              <span data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Alamat"> 
                <button data-bs-toggle="modal" data-bs-target="#myModal_{{$key->id}}" class="btn btn-sm btn-danger"><i class="ti-trash"></i> Hapus</button>
              </span>
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
              <h4 class="modal-title">Hapus Alamat</h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                Yakin ingin hapus alamat ini?
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
              <form method="post" id="fornHapus_{{$key->id}}" class="form-horizontal">
                @csrf
                <input type="hidden" name="id_data[]" value="{{Crypt::encrypt($key->id)}}">
                <button type="button" class="btn btn-primary btn-hapus" idform="{{$key->id}}">Ya</button>
              </form>
            </div>

          </div>
        </div>
      </div>
      @endforeach
  @else
    <div style="text-align:center;padding-top:15px">
      <h5>Belum Ada Alamat</h5>
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
    $(document).on('click', '.btn-hapus', function (e) {
        idform = $(this).attr('idform');
        
        var formData = new FormData($('#fornHapus_' + idform)[0]);

        var url = "{{ url('hapusalamat') }}";
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
                      reload(1500);
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


