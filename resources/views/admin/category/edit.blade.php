@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-header">
                    <span>Ubah Kategori</span>
                </div>
                <form method="POST" action="{{ route('admin.category.update', $category->id) }}" autocomplete="off" enctype="multipart/form-data">
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

                        {{-- current image --}}
                        @if($category->image != null)
                            <div class="mb-3">
                                <img src="{{ asset('storage/uploads/categories/' . $category->cover) }}" alt="{{ $category->title }}" class="img-thumbnail" style="max-height: 300px;" />
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="file" class="form-label">Pilih Cover</label>
                            <input class="form-control" type="file" id="file" name="file" />
                        </div>

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