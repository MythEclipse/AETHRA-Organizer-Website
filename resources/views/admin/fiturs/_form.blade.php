<div class="form-group">
    <label for="name">Nama Fitur</label>
    <input
        type="text"
        name="name"
        id="name"
        class="form-control @error('name') is-invalid @enderror"
        value="{{ old('name', $fitur->name ?? '') }}"
        placeholder="Contoh: Dekorasi Pelaminan"
    >
    @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('fiturs.index') }}" class="btn btn-secondary">Batal</a>
</div>
