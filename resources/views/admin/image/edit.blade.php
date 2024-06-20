@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-header">
                    <span>Ubah Gambar</span>
                </div>
                <form method="POST" action="{{ route('admin.image.update', $image->id) }}"autocomplete="off" enctype="multipart/form-data">
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
                        <div class="mb-3">
                            <img src="{{ asset('storage/uploads/' . $image->file) }}" alt="{{ $image->title }}" class="img-thumbnail" style="max-height: 300px;" />
                        </div>

                        <div class="mb-3">
                            <label for="file" class="form-label">Pilih Gambar</label>
                            <input class="form-control" type="file" id="file" name="file" />
                          </div>
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul</label>
                            <input type="text" class="form-control" id="title" name="title" required value="{{ $image->title }}" />
                        </div>
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Kategori</label>
                            <select name="category_id" id="category_id" class="form-select" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $category->id == $image->category_id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="color" class="form-label">Warna</label>
                            <input type="text" class="form-control" id="color" name="color" required value="{{ $image->color }}" />
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <input type="text" class="form-control" id="description" name="description" required value="{{ $image->description }}" />
                        </div>
                        <div class="mb-3">
                            <label for="keywords" class="form-label">Keywords</label>
                            <input type="text" class="form-control" id="keywords" name="keywords" required value="{{ $image->keywords }}" />
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('admin.image.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection