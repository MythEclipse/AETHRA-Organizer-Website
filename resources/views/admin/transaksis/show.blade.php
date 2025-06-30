@extends('layouts.admin')

@section('title', 'Detail Transaksi')
@section('content-header', 'Detail Transaksi ' . $transaksi->transaction_code)

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <h4>Detail Pesanan</h4>
                <table class="table table-bordered">
                    <tr>
                        <th>Kode Transaksi</th>
                        <td>{{ $transaksi->transaction_code }}</td>
                    </tr>
                    <tr>
                        <th>Paket Dipesan</th>
                        <td>{{ $transaksi->paket->name }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Acara</th>
                        <td>{{ $transaksi->event_date->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <th>Total Bayar</th>
                        <td>Rp {{ number_format($transaksi->total_amount) }}</td>
                    </tr>
                    <tr>
                        <th>Metode Pembayaran</th>
                        <td>{{ $transaksi->payment_method ?? 'BRI (AETHRA ORGANIZER) 00212398900' }}</td>
                    </tr>
                </table>

                <h4 class="mt-4">Data Pelanggan</h4>
                 <table class="table table-bordered">
                    <tr>
                        <th>Nama</th>
                        <td>{{ $transaksi->user->name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $transaksi->user->email }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Update Status</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.transaksis.updateStatus', $transaksi->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="status">Status Transaksi</label>
                        <select name="status" id="status" class="form-control">
                            <option value="PENDING" @if($transaksi->status == 'PENDING') selected @endif>PENDING</option>
                            <option value="PAID" @if($transaksi->status == 'PAID') selected @endif>PAID</option>
                            <option value="SUCCESS" @if($transaksi->status == 'SUCCESS') selected @endif>SUCCESS</option>
                            <option value="CANCELLED" @if($transaksi->status == 'CANCELLED') selected @endif>CANCELLED</option>
                            <option value="FAILED" @if($transaksi->status == 'FAILED') selected @endif>FAILED</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Update Status</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
