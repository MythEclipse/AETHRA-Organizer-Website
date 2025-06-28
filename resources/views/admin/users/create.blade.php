@extends('layouts.admin')
@section('title', 'Tambah Pengguna')
@section('content-header', 'Tambah Pengguna Baru')
@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            @include('admin.users._form')
        </form>
    </div>
</div>
@endsection
