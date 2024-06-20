@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-header">
                    <span>Tambah Kategori</span>
                </div>
                <form method="POST" action="{{ route('admin.category.update', $category->id) }}" autocomplete="off">
                    <div class="card-body">
                        @if (flash()->message)
                            <div class="alert alert-{{ flash()->class }}">
                                {{ flash()->message }}
                            </div>
                        @endif
                        
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                {{ $errors->first() }}
                            </div>
                        @endif
                        
                        {{ csrf_field() }}
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $category->name }}" />
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('admin.category.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection