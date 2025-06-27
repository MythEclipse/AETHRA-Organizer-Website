@extends('layouts.admin')
@section('title', 'Edit Deskripsi Layanan')
@section('content-header', 'Edit Deskripsi Layanan')

@section('content')
<div class="row">
    <div class="col-12">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @foreach($services as $service)
        <div class="card">
            <div class="card-header">
                <h3 class="card-title text-capitalize font-weight-bold">{{ $service->title }}</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.services.update', $service->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $service->description) }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Simpan Perubahan</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
