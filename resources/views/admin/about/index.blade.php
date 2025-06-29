@extends('layouts.admin')
@section('title', 'Halaman About Us')
@section('content-header', 'Edit Konten Halaman About Us')

@section('content')
<div class="card">
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Form akan di-submit ke method update --}}
        <form action="{{ route('admin.about.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="headline">Judul</label>
                <input type="text" name="headline" class="form-control" value="{{ old('headline', $about->headline ?? '') }}">
            </div>

            <div class="form-group">
                <label for="paragraph_1">Paragraf 1</label>
                <textarea name="paragraph_1" class="form-control" rows="4">{{ old('paragraph_1', $about->paragraph_1 ?? '') }}</textarea>
            </div>

            <div class="form-group">
                <label for="paragraph_2">Paragraf 2</label>
                <textarea name="paragraph_2" class="form-control" rows="3">{{ old('paragraph_2', $about->paragraph_2 ?? '') }}</textarea>
            </div>

            <div class="form-group">
                <label for="image">Gambar</label>
                <div class="mb-2">
                    @if($about->image)
                       <img src="{{ Storage::url($about->image) }}" alt="About Image" style="max-height: 200px;">
                    @endif
                </div>
                <input type="file" name="image" class="form-control-file">
                <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah gambar.</small>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection
