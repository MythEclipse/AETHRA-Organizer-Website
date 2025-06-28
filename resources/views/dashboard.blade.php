@extends('layouts.admin')

@section('title', 'Dashboard')
@section('content-header', 'Dashboard Utama')
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
@endsection

@section('content')
{{-- Baris untuk Info Box --}}
<div class="row">
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-dollar-sign"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Pendapatan</span>
                <span class="info-box-number">Rp {{ number_format($totalRevenue) }}</span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Pengguna</span>
                <span class="info-box-number">{{ $userCount }}</span>
            </div>
        </div>
    </div>
    <div class="clearfix hidden-md-up"></div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-box-open"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Jumlah Paket</span>
                <span class="info-box-number">{{ $paketCount }}</span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-images"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Item Galeri</span>
                <span class="info-box-number">{{ $galleryCount }}</span>
            </div>
        </div>
    </div>
</div>

{{-- Baris untuk Chart dan Konten Utama --}}
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Laporan Rekap Bulanan</h5>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="chart">
                    <canvas id="salesChart" height="100" style="height: 100px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    {{-- Kolom Kiri: Pengguna Terbaru --}}
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Anggota Terbaru</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body p-0">
                <ul class="users-list clearfix">
                    @forelse($latestMembers as $user)
                    <li>
                        <img src="{{ $user->profile_photo_url }}" alt="User Image" class="img-circle" style="width: 80px; height: 80px; object-fit: cover;">
                        <a class="users-list-name" href="#">{{ $user->name }}</a>
                        <span class="users-list-date">{{ $user->created_at->diffForHumans() }}</span>
                    </li>
                    @empty
                    <li class="p-4 text-center">Belum ada pengguna baru.</li>
                    @endforelse
                </ul>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('admin.users.index') }}">Lihat Semua Pengguna</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function () {
  'use strict'

  var salesChartCanvas = $('#salesChart').get(0).getContext('2d')

  var salesChartData = {
    // Mengambil data label (bulan) dari controller
    labels: @json($salesLabels),
    datasets: [
      {
        label: 'Pendapatan',
        backgroundColor: 'rgba(60,141,188,0.9)',
        borderColor: 'rgba(60,141,188,0.8)',
        pointRadius: false,
        pointColor: '#3b8bba',
        pointStrokeColor: 'rgba(60,141,188,1)',
        pointHighlightFill: '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
        // Mengambil data nilai (total pendapatan) dari controller
        data: @json($salesValues)
      }
    ]
  }

  var salesChartOptions = {
    maintainAspectRatio: false,
    responsive: true,
    legend: {
      display: false
    },
    scales: {
      xAxes: [{
        gridLines: {
          display: false
        }
      }],
      yAxes: [{
        gridLines: {
          display: false
        },
        // Callback untuk format Rupiah di sumbu Y
        ticks: {
          callback: function (value, index, values) {
            return 'Rp ' + new Intl.NumberFormat().format(value);
          }
        }
      }]
    }
  }

  // This will get the chart type from the string in a dynamically
  var salesChart = new Chart(salesChartCanvas, {
    type: 'line',
    data: salesChartData,
    options: salesChartOptions
  })
})
</script>
@endpush
