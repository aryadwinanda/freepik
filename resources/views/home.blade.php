@extends('layouts.app')

{{-- <div class="input-group mb-3">
    <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2">
    <button class="btn btn-outline-secondary" type="button" id="button-addon2">Button</button>
  </div> --}}

@section('content')
    <div class="container">
        <div class="p-5 mb-4 bg-body-tertiary rounded-3 shadow-sm">
            <div class="container-fluid py-5">
                <h1 class="display-5 fw-bold mb-4">Free Image</h1>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="cari berdasarkan kata kunci" />
                    <button class="btn btn-outline-primary" type="button" id="button-addon2">Cari</button>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach ($categories as $c)
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="card category-card mb-4">
                        <a href="{{ route('category', $c->slug) }}">
                            <div class="card-body">
                                <h5 class="card-title category-title mb-0">{{ $c->name }}</h5>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection