@extends('layouts.admin')

@section('title', 'User Profile')

@section('content-header', 'User Profile')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">User Profile</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        {{-- Kolom Kiri --}}
        <div class="col-md-6">
            {{-- Form Update Profile Information --}}
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Profile Information</h3>
                </div>
                <div class="card-body">
                    {{-- File partial ini berisi form untuk update nama dan email --}}
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Form Update Password --}}
            <div class="card card-primary mt-4">
                <div class="card-header">
                    <h3 class="card-title">Update Password</h3>
                </div>
                <div class="card-body">
                    {{-- File partial ini berisi form untuk update password --}}
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>

        {{-- Kolom Kanan --}}
        <div class="col-md-6">
            {{-- Form Delete User --}}
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">Delete Account</h3>
                </div>
                <div class="card-body">
                     {{-- File partial ini berisi tombol dan modal untuk hapus akun --}}
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Jika ada script khusus untuk halaman ini, bisa ditambahkan di sini.
         Contoh: <script src="{{ asset('js/profile.js') }}"></script> --}}
@endpush
