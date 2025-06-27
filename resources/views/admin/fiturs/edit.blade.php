@extends('layouts.admin')

@section('title', 'Edit Fitur')
@section('content-header', 'Edit Fitur')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('fiturs.update', $fitur->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.fiturs._form', ['fitur' => $fitur])
        </form>
    </div>
</div>
@endsection
