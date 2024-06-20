@extends('layouts.app')

@section('content')
    <div class="container">
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