@extends('layouts.admin')

@section('title', 'Tambah Fitur Baru')
@section('content-header', 'Tambah Fitur Baru')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('fiturs.store') }}" method="POST">
            @csrf
            @include('admin.fiturs._form')
        </form>
    </div>
</div>
@endsection
