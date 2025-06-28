<div class="form-group">
    <label for="title">Judul Foto/Event</label>
    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
        value="{{ old('title', $gallery->title ?? '') }}" placeholder="Contoh: Pernikahan Budi & Ani">
    @error('title')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

<div class="form-group">
    <label for="image">Gambar Galeri</label>

    @if (isset($gallery) && $gallery->image)
        <div class="mb-2">
            <img src="{{ Storage::url($gallery->image) }}" alt="Current Image" style="max-height: 150px;">
        </div>
    @endif

    <input type="file" name="image" id="image" class="form-control-file @error('image') is-invalid @enderror">
    <small class="form-text text-muted">Format: JPG, PNG, WEBP. Maks: 2MB. @if (isset($gallery))
            Kosongkan jika tidak ingin mengubah gambar.
        @endif
    </small>
    @error('image')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

<div class="form-group">
    <label for="description">Deskripsi (Opsional)</label>
    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
        rows="4" placeholder="Ceritakan sedikit tentang foto atau event ini">{{ old('description', $gallery->description ?? '') }}</textarea>
    @error('description')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('galleries.index') }}" class="btn btn-secondary">Batal</a>
</div>
