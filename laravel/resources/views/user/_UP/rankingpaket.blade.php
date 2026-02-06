@extends($extend)
<!-- partial -->
@section('content')
<style>
  tr th{
    text-align:left;
  }
  thead tr{
    background:#e5e5e5;
  }
  tbody{
    border-top:unset !important;
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
              <!-- <li class="breadcrumb-item active" aria-current="page"><a href="{{url('tryout')}}">Peringkat</a></li> -->
              <li class="breadcrumb-item active" aria-current="page">Peringkat {{$datapaket->judul}}</li>
            </ol>
          </nav>
          <p class="card-description">
            <h3 class="font-weight-bold"><b>Peringkat Peserta</b></h3>
          </p>
          <div class="alert alert-success p-3 mt-3" role="alert">
            <div class="row">
              <div class="col-4">
                <table class="table table-borderless table-sm">
                      <tbody>
                        <tr>
                          <th>Paket</th>
                          <th>: {{$datapaket->judul}}</th>
                        </tr>
                        <!-- <tr>
                          <th>Jumlah Peserta</th>
                          <th>: {{count($udatapaket)}} Peserta</th>
                        </tr> -->
                    </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="row mt-4">
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>PERINGKAT</th>
                    <th>NAMA</th>
                    <th>NILAI</th>
                    <th>PROVINSI / KOTA</th>
                  </tr>
                </thead>
                <tbody>
                  @if(count($udatapaket)>0)
                    @foreach($udatapaket->sortByDesc('set_nilai') as $key)
                    <tr>
                      <th style="text-align:left">{{$loop->iteration}}</th>
                      <td width="40%">{{$key->user_r->name}} @if($loop->iteration==1)<i style="color:gold" class="ti-medall btn-icon-prepend"></i>@endif</td>
                      <td width="10%" style="text-align:left" class="font-weight-bold">{{$key->set_nilai}}</td>
                      <td style="text-align:left" width="40%"><span data-bs-toggle="tooltip" data-bs-placement="top" title="Kecamatan : {{$key->user_r->kecamatan_r ? $key->user_r->kecamatan_r->nama : '-'}}, {{$key->user_r->kabupaten_r ? ucwords(strtolower($key->user_r->kabupaten_r->nama)) : '-'}}, Provinsi : {{$key->user_r->provinsi_r ? $key->user_r->provinsi_r->nama : ''}}">{{$key->user_r->kabupaten_r ? ucwords(strtolower($key->user_r->kabupaten_r->nama)) : '-'}}, {{$key->user_r->provinsi_r ? $key->user_r->provinsi_r->nama : '-'}}</span></td>
                    </tr>
                    @endforeach
                  @else
                    <tr>
                      <td colspan="7" style="text-align:center" class="font-weight-bold">Belum Ada Data</td>
                    </tr>
                  @endif
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('footer')
<!-- jQuery -->
<script>
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})
  $(document).ready(function(){
  
  });
</script>
<!-- Loading Overlay -->
@endsection


