@forelse($subkategori as $key)
<div class="col-md-6 grid-margin stretch-card">
    <a href="{{url('belipaket')}}/{{Crypt::encrypt($key->id)}}" class="hrefpaket">
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
<center>Data "{{$datacari}}" tidak ditemukan</center>
@endforelse