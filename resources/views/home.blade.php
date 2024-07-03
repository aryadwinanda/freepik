@extends('layouts.app')

{{-- <div class="input-group mb-3">
    <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2">
    <button class="btn btn-outline-secondary" type="button" id="button-addon2">Button</button>
  </div> --}}

@section('content')
    <div class="container">
        <div class="p-5 mb-4 rounded-3 shadow-sm border bg-hero">
            <div class="container-fluid py-5">
                <h1 class="display-5 fw-bold mb-4">Free Image</h1>
                <form method="GET" action="{{ route("search") }}">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="cari berdasarkan kata kunci" name="keyword" />
                        <button class="btn btn-outline-primary" type="submit" id="button-addon2">Cari</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row row-cols-4 row-cols-md-4 row-cols-lg-6 g-4 mb-4">
            @foreach ($categories as $c)
                <a href="{{ route('category', $c->slug) }}" class="col">
                    <div class="card card-category rounded-3">
                        <img src="{{ asset('storage/uploads/categories/' . $c->cover) }}" class="card-img-top p-4" />
                        <div class="card-body border-top">
                            <h5 class="title-category mb-0">{{ $c->name }}</h5>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection