@extends('layouts.admin')

@section('title', 'Manajemen Paket')
@section('content-header', 'Manajemen Paket')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Paket Event</h3>
        <div class="card-tools">
            <a href="{{ route('pakets.create') }}" class="btn btn-primary btn-sm">Tambah Baru</a>
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
                        <th>Nama Paket & Fitur</th>
                        <th>Harga</th>
                        <th style="width: 150px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pakets as $index => $paket)
                    <tr>
                        <td>{{ $pakets->firstItem() + $index }}</td>
                        <td>
                            <strong>{{ $paket->name }}</strong><br>
                            <div class="mt-1">
                                @foreach($paket->fiturs as $fitur)
                                    <span class="badge badge-info font-weight-normal">{{ $fitur->name }}</span>
                                @endforeach
                            </div>
                        </td>
                        <td>Rp {{ number_format($paket->price, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('pakets.edit', $paket->id) }}" class="btn btn-warning btn-xs">Edit</a>
                            <form action="{{ route('pakets.destroy', $paket->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Anda yakin ingin menghapus paket ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-xs">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Belum ada data paket.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $pakets->links() }}
        </div>
    </div>
</div>
@endsection
