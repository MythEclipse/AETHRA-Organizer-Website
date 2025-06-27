@extends('layouts.admin')

@section('title', 'Edit Paket')
@section('content-header', 'Edit Paket')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('pakets.update', $paket->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.pakets._form', ['paket' => $paket])
        </form>
    </div>
</div>
@endsection
