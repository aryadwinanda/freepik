@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <span>Daftar Gambar</span>
                    <div class="float-end">
                        <a href="{{ route('admin.image.create') }}" class="btn btn-primary btn-sm">Tambah</a>
                    </div>
                </div>
                <div class="card-body">
                    @if (flash()->message)
                        <div class="alert alert-{{ flash()->class }}">
                            {{ flash()->message }}
                        </div>
                    @endif
                    <table class="table table-sm table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th width="15%">Dibuat</th>
                                <th width="15%">Diubah</th>
                                <th width="10%">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($images as $c)
                                <tr>
                                    <td>{{ $c->title }}</td>
                                    <td>{{ $c->category->name }}</td>
                                    <td class="text-center">
                                        @if($c->status == 'active')
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $c->created_at ? Carbon\Carbon::create($c->created_at)->diffForHumans() : "" }}
                                    </td>
                                    <td>
                                        {{ $c->updated_at ? Carbon\Carbon::create($c->updated_at)->diffForHumans() : "" }}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.image.edit', $c->id) }}" class="btn btn-outline-primary btn-sm">Edit</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection