@extends('layouts.admin')

@section('title', 'Edit Item Galeri')
@section('content-header', 'Edit Item Galeri')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('galleries.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.galleries._form', ['gallery' => $gallery])
        </form>
    </div>
</div>
@endsection
