@extends('layouts.admin')

@section('title', 'Tambah Paket Baru')
@section('content-header', 'Tambah Paket Baru')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('pakets.store') }}" method="POST">
            @csrf
            @include('admin.pakets._form')
        </form>
    </div>
</div>
@endsection
