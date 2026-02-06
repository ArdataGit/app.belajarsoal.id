@extends('layouts.Skydash')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card card-border" style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);">
                    <div class="card-body">
                        <h4 class="card-title text-white">FAQ</h4>
                        <div class="accordion" id="faqAccordion">

                            @foreach($data as $faq)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading_{{ $faq->id }}">
                                        <button class="accordion-button question" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse_{{ $faq->id }}" aria-expanded="true"
                                            aria-controls="collapse_{{ $faq->id }}">
                                            <strong>{{ $faq->question }}</strong>
                                        </button>
                                    </h2>
                                    <div id="collapse_{{ $faq->id  }}" class="accordion-collapse collapse"
                                        aria-labelledby="heading_{{ $faq->id }}" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body answer">
                                            {!! $faq->answer !!}
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .question {
            background-color: #007bff;
            /* Warna background untuk pertanyaan */
            color: white;
            /* Warna teks untuk pertanyaan */
        }

        .answer {
            background-color: #f8f9fa;
            /* Warna background untuk jawaban */
        }

        .accordion-button:not(.collapsed) {
            color: white;
            background-color: #0062cc;
            /* Warna background untuk pertanyaan ketika accordion dibuka */
            box-shadow: inset 0 -1px 0 rgba(0, 0, 0, .125);
        }
    </style>
@endsection