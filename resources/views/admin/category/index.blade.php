@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <span>Daftar Kategori</span>
                <div class="float-end">
                    <a href="{{ route('admin.category.create') }}" class="btn btn-primary btn-sm">Tambah</a>
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
                            <th>Nama</th>
                            <th width="10%">Status</th>
                            <th width="15%">Dibuat</th>
                            <th width="15%">Diubah</th>
                            <th width="10%">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td class="text-center">
                                    @if($category->status == 'active')
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $category->created_at ? Carbon\Carbon::create($category->created_at)->diffForHumans() : "" }}
                                </td>
                                <td>
                                    {{ $category->updated_at ? Carbon\Carbon::create($category->updated_at)->diffForHumans() : "" }}
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.category.edit', $category->id) }}" class="btn btn-outline-primary btn-sm">Edit</a>
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
@endsection