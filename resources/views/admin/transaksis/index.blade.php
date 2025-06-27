@extends('layouts.admin')

@section('title', 'Manajemen Transaksi')
@section('content-header', 'Manajemen Transaksi')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Semua Transaksi</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Kode Transaksi</th>
                        <th>Pelanggan</th>
                        <th>Paket</th>
                        <th>Tgl. Acara</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transaksis as $transaksi)
                        <tr>
                            <td>{{ $transaksi->transaction_code }}</td>
                            <td>{{ $transaksi->user->name }}</td>
                            <td>{{ $transaksi->paket->name }}</td>
                            <td>{{ $transaksi->event_date->format('d M Y') }}</td>
                            <td>Rp {{ number_format($transaksi->total_amount) }}</td>
                            <td>
                                @if($transaksi->status == 'PENDING')
                                    <span class="badge badge-warning">PENDING</span>
                                @elseif($transaksi->status == 'PAID')
                                    <span class="badge badge-info">PAID</span>
                                @elseif($transaksi->status == 'SUCCESS')
                                    <span class="badge badge-success">SUCCESS</span>
                                @else
                                    <span class="badge badge-danger">{{ $transaksi->status }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.transaksis.show', $transaksi->id) }}" class="btn btn-info btn-xs">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $transaksis->links() }}
        </div>
    </div>
</div>
@endsection
