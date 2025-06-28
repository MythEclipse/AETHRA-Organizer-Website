@extends('layouts.admin')
@section('title', 'Edit Pengguna')
@section('content-header', 'Edit Pengguna')
@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.users._form', ['user' => $user])
        </form>
    </div>
</div>
@endsection
