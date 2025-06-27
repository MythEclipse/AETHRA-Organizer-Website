@extends('layouts.admin')

@section('title', 'Manajemen Fitur')
@section('content-header', 'Manajemen Fitur')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Fitur</h3>
        <div class="card-tools">
            <a href="{{ route('fiturs.create') }}" class="btn btn-primary btn-sm">Tambah Baru</a>
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
                        <th>Nama Fitur</th>
                        <th style="width: 150px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($fiturs as $index => $fitur)
                    <tr>
                        <td>{{ $fiturs->firstItem() + $index }}</td>
                        <td>{{ $fitur->name }}</td>
                        <td>
                            <a href="{{ route('fiturs.edit', $fitur->id) }}" class="btn btn-warning btn-xs">Edit</a>
                            <form action="{{ route('fiturs.destroy', $fitur->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Anda yakin ingin menghapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-xs">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center">Belum ada data fitur.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $fiturs->links() }}
        </div>
    </div>
</div>
@endsection
