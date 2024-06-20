@extends('layouts.app')

@section('content')
    <div class="container">
        <h5 class="mb-2">{{ $category->name }}</h5>

        <div class="row">
            @forelse ($images as $i)
                <div class="col-12 col-sm-4 col-md-3">
                    <div class="card">
                        <img src="{{ asset('storage/uploads/' . $i->file) }}" class="card-img-top img-thumbnail" alt="{{ $i->title }}">    
                        <div class="card-body">
                            <h5 class="card-title mb-1">{{ $i->title }}</h5>
                            <p class="card-text text-secondary mb-1">{{ $i->category->name }}</p>
                            <p class="card-text mb-1 text-truncate">{{ $i->description }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col">
                    <div class="alert alert-danger" role="alert">
                        Belum ada gambar yang tersedia.
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection