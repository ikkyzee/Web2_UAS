@extends('layouts.app')

@section('title', (isset($user) ? 'Edit User' : 'Tambah User') . ' - KT Inventory')
@section('page_heading', isset($user) ? 'Edit User' : 'Tambah User')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}" method="POST">
                    @csrf
                    @if(isset($user))
                        @method('PUT')
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name ?? '') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-bold">Alamat Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="password" class="form-label fw-bold">Password {{ isset($user) ? '(Kosongkan jika tidak diubah)' : '*' }}</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" {{ isset($user) ? '' : 'required' }}>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label fw-bold">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" {{ isset($user) ? '' : 'required' }}>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="role" class="form-label fw-bold">Role Akses <span class="text-danger">*</span></label>
                            <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required onchange="toggleToko(this.value)">
                                <option value="">-- Pilih Role --</option>
                                <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>Admin Pusat</option>
                                <option value="petugas" {{ old('role', $user->role ?? '') == 'petugas' ? 'selected' : '' }}>Petugas Gudang</option>
                                <option value="admin_toko" {{ old('role', $user->role ?? '') == 'admin_toko' ? 'selected' : '' }}>Admin Toko</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6" id="toko_wrapper" style="display: {{ old('role', $user->role ?? '') == 'admin_toko' ? 'block' : 'none' }};">
                            <label for="toko_id" class="form-label fw-bold">Pilih Toko Cabang <span class="text-danger">*</span></label>
                            <select class="form-select @error('toko_id') is-invalid @enderror" id="toko_id" name="toko_id">
                                <option value="">-- Pilih Toko --</option>
                                @foreach($tokos as $toko)
                                    <option value="{{ $toko->id }}" {{ old('toko_id', $user->toko_id ?? '') == $toko->id ? 'selected' : '' }}>
                                        {{ $toko->nama_toko }}
                                    </option>
                                @endforeach
                            </select>
                            @error('toko_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('users.index') }}" class="btn btn-light border"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function toggleToko(role) {
        if(role === 'admin_toko') {
            document.getElementById('toko_wrapper').style.display = 'block';
            document.getElementById('toko_id').required = true;
        } else {
            document.getElementById('toko_wrapper').style.display = 'none';
            document.getElementById('toko_id').required = false;
            document.getElementById('toko_id').value = '';
        }
    }
    // Initialize on load if there's a selected role
    window.onload = function() {
        toggleToko(document.getElementById('role').value);
    }
</script>
@endpush
@endsection
