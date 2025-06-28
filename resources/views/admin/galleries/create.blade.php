@extends('layouts.admin')

@section('title', 'Tambah Item Galeri')
@section('content-header', 'Tambah Item Galeri Baru')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('galleries.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.galleries._form')
        </form>
    </div>
</div>
@endsection
