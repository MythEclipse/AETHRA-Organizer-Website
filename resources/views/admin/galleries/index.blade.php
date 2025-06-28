@extends('layouts.admin')

@section('title', 'Manajemen Galeri')
@section('content-header', 'Manajemen Galeri')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Foto Galeri</h3>
        <div class="card-tools">
            <a href="{{ route('galleries.create') }}" class="btn btn-primary btn-sm">Tambah Baru</a>
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th style="width: 150px">Gambar</th>
                        <th>Judul</th>
                        <th>Likes</th>
                        <th style="width: 150px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($galleries as $index => $gallery)
                    <tr>
                        <td>{{ $galleries->firstItem() + $index }}</td>
                        <td>
                            <img src="{{ $gallery->image_url }}" alt="{{ $gallery->title }}" class="img-thumbnail" width="120">
                        </td>
                        <td>{{ $gallery->title }}</td>
                        <td>{{ $gallery->likes }}</td>
                        <td>
                            <a href="{{ route('galleries.edit', $gallery->id) }}" class="btn btn-warning btn-xs">Edit</a>
                            <form action="{{ route('galleries.destroy', $gallery->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Anda yakin ingin menghapus item ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-xs">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada item galeri.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $galleries->links() }}
        </div>
    </div>
</div>
@endsection
