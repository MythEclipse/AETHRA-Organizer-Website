<div class="form-group">
    <label for="name">Nama Paket</label>
    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $paket->name ?? '') }}" placeholder="Contoh: Paket Pernikahan Gold">
    @error('name')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

<div class="form-group">
    <label for="price">Harga</label>
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">Rp</span>
        </div>
        <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $paket->price ?? '') }}" placeholder="Contoh: 5000000">
    </div>
    @error('price')
        <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

<div class="form-group">
    <label for="description">Deskripsi</label>
    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="4" placeholder="Jelaskan tentang paket ini">{{ old('description', $paket->description ?? '') }}</textarea>
    @error('description')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

<hr>

<div class="form-group">
    <label>Pilih Fitur yang Termasuk</label>
    <div class="row">
        @forelse($fiturs as $fitur)
            <div class="col-md-4">
                <div class="form-check">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="fiturs[]"
                        value="{{ $fitur->id }}"
                        id="fitur-{{ $fitur->id }}"
                        @if(in_array($fitur->id, old('fiturs', isset($paket) ? $paket->fiturs->pluck('id')->toArray() : []))) checked @endif
                    >
                    <label class="form-check-label" for="fitur-{{ $fitur->id }}">
                        {{ $fitur->name }}
                    </label>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-muted">Belum ada data fitur. Silakan <a href="{{ route('fiturs.create') }}">tambah fitur</a> terlebih dahulu.</p>
            </div>
        @endforelse
    </div>
    @error('fiturs')
        <span class="text-danger mt-2 d-block">{{ $message }}</span>
    @enderror
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-primary">Simpan Paket</button>
    <a href="{{ route('pakets.index') }}" class="btn btn-secondary">Batal</a>
</div>
