@extends('layouts.Skydash')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="cardx card-border w-100">
                    <div class="card-bodyx">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item text-white"><a href="{{ url('home') }}"><i
                                            class="fas fa-home"></i></a></li>
                                {{-- <li class="breadcrumb-item active text-white" aria-current="page"><a
                                        href="{{ url('paketsayaktg') }}">Paket Saya</a></li> --}}
                                {{-- <li class="breadcrumb-item active text-white" aria-current="page"><a
                                        href="{{ url('paketsayasubktg') }}/{{ Crypt::encrypt($subkategori->fk_paket_kategori) }}">{{
                                        $subkategori->kategori_r->judul }}</a>
                                </li> --}}
                                <li class="breadcrumb-item active text-white" aria-current="page">{{ $subkategori->judul }}
                                </li>
                            </ol>
                        </nav>
                        <p class="card-description">
                        <h3 class="text-white font-weight-bold"><b>Pilih Paket</b></h3>
                        </p>
                        <div class="row mt-4">
                            @forelse($paket as $key)
                                <div class="col-md-4 grid-margin stretch-card">
                                    <div class="card card-border">
                                        <img src="{{ asset($key->banner) }}" alt=""
                                            style="width:100%;height:300px;object-fit:cover;border-top-left-radius: 10px;border-top-right-radius: 10px;">
                                        <div class="card-body">
                                            <div class="row align-items-center mb-3" style="flex-wrap: nowrap !important;">
                                                <div class="col-2">
                                                    <div class="icon-card bg-blue rounded-circle iconpaket">
                                                        <i class="p-2 ti-layers-alt"></i>
                                                    </div>
                                                </div>
                                                <div class="col-8">
                                                    <h4 class="fs-6 mb-0 ms-3 text-white"><b>{{ $key->judul }}</b></h4>
                                                </div>
                                            </div>

                                            <a href="{{ url('paketsayadetail') }}/{{ Crypt::encrypt($key->id) }}"
                                                id="btnMulai_{{ $key->id }}"
                                                class="hrefpaket btn btn-primary bg-green text-white rounded-pill d-flex align-items-center justify-content-center ">
                                                Mulai Belajar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <center><img class="mb-3 img-no" src="{{ asset('image/global/no-paket.png') }}"
                                        alt=""></center>
                                <br>
                                <center class="text-white">Belum Ada Data</center>
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
        $(document).ready(function() {
            $('.password-input').on('input', function() {
                var paketId = $(this).attr('id').split('_')[1];
                var password = $(this).val();

                $.ajax({
                    url: '{{ url('cekpasswordpaket') }}',
                    type: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'paket_id': paketId,
                        'password': password
                    },
                    success: function(response) {
                        if (response.status) {
                            $('#passwordHelp_' + paketId).addClass('d-none');
                            $('#passwordSuccess_' + paketId).removeClass('d-none');
                            $('#btnMulai_' + paketId).removeClass('disabled');
                        } else {
                            $('#passwordHelp_' + paketId).removeClass('d-none');
                            $('#passwordSuccess_' + paketId).addClass('d-none');
                            $('#btnMulai_' + paketId).addClass('disabled');
                        }
                    },
                    error: function() {
                        $('#passwordHelp_' + paketId).removeClass('d-none');
                        $('#passwordSuccess_' + paketId).addClass('d-none');
                        $('#btnMulai_' + paketId).addClass('disabled');
                    }
                });
            });
        });
    </script>
@endsection
