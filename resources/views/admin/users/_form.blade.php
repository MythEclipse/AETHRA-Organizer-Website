<div class="form-group">
    <label for="name">Nama Lengkap</label>
    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name ?? '') }}" required>
    @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
</div>

<div class="form-group">
    <label for="email">Alamat Email</label>
    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email ?? '') }}" required>
    @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
</div>

<div class="form-group">
    <label for="role">Role</label>
    <select name="role" id="role" class="form-control @error('role') is-invalid @enderror">
        <option value="user" {{ isset($user) && $user->role == 'user' ? 'selected' : '' }}>User</option>
        <option value="admin" {{ isset($user) && $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
    </select>
    @error('role')<span class="invalid-feedback">{{ $message }}</span>@enderror
</div>

<div class="form-group">
    <label for="password">Password</label>
    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
    @if(isset($user))<small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password.</small>@endif
    @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
</div>

<div class="form-group">
    <label for="password_confirmation">Konfirmasi Password</label>
    <input type="password" name="password_confirmation" class="form-control">
</div>

<button type="submit" class="btn btn-primary">Simpan</button>
<a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
