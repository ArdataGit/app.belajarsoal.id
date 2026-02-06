@extends('layouts.SkydashPublic')

@section('content')
    <div class="container">
        <div class="row mb-0">
            <div class="col-md-12">
                <div class="row mt-3">
                    <div class="col-12 col-lg-12 col-md-12 mb-3 mb-md-0">
                        <div class="card shadow-sm bg-dark text-white">
                            <div class="card-body px-4 py-4">
                                <h5 class="fw-bold text-white mb-3">Informasi</h5>
                                @if($informasi->isNotEmpty())
                                    <ul class="list-group list-group-flush">
                                        @foreach($informasi as $data)
                                            <li class="list-group-item border-0 px-0 py-2 bg-dark text-white">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <div class="fw-bold text-primary">{{ $data->judul }}</div>
                                                        <small class="text-light">
                                                            {{ $data->ket }}
                                                        </small>
                                                    </div>
                                                </div>
                                                @if($data->isi)
                                                    <div class="mt-2">
                                                        <p class="mb-0 text-light">{!! $data->isi !!}</p>
                                                    </div>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <div class="text-center text-muted">
                                        Belum ada Informasi.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        body {
            background-color: #121212;
            color: #ffffff;
        }

        .content-wrapper {
            background-color: #1e1e1e;
        }

        .card {
            background-color: #2c2c2c;
            border: 1px solid #444;
        }

        .list-group-item {
            background-color: #2c2c2c;
            color: #ffffff;
        }

        .text-primary {
            color: #90caf9 !important;
        }

        .text-muted {
            color: #b0bec5 !important;
        }

        .question {
            background-color: #1565c0;
            color: white;
        }

        .answer {
            background-color: #424242;
            color: white;
        }

        .accordion-button:not(.collapsed) {
            color: white;
            background-color: #0d47a1;
            box-shadow: inset 0 -1px 0 rgba(255, 255, 255, .125);
        }
    </style>
@endsection