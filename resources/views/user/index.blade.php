@extends('layouts.app')

@section('title', 'Master User - KT Inventory')
@section('page_heading', 'Master User')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-bottom-0 pt-4 pb-3">
        <div class="row align-items-center">
            <div class="col-md-4 d-flex align-items-center mb-3 mb-md-0">
                <h5 class="fw-bold text-secondary mb-0 me-3">Manajemen User</h5>
                <button type="button" class="btn btn-primary btn-sm shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahUser">
                    <i class="fas fa-plus me-1"></i> Tambah
                </button>
            </div>
            <div class="col-md-8">
                <form action="{{ route('users.index') }}" method="GET" class="d-flex justify-content-md-end">
                    <div class="input-group" style="max-width: 300px;">
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama, email, role..." value="{{ $search ?? '' }}">
                        <button class="btn btn-outline-secondary btn-sm" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="20%">Nama Lengkap</th>
                        <th width="25%">Email</th>
                        <th width="15%">Role</th>
                        <th width="20%">Cabang/Toko</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $loop->iteration + $users->firstItem() - 1 }}</td>
                        <td class="fw-bold">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->role === 'admin')
                                <span class="badge bg-danger">Admin Pusat</span>
                            @elseif($user->role === 'petugas')
                                <span class="badge bg-info">Petugas Gudang</span>
                            @else
                                <span class="badge bg-success">Admin Toko</span>
                            @endif
                        </td>
                        <td>{{ $user->toko->nama_toko ?? 'Pusat' }}</td>
                        <td class="text-center">
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning text-white shadow-sm mb-1"><i class="fas fa-edit"></i></a>
                            @if($user->role !== 'admin')
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger shadow-sm mb-1"><i class="fas fa-trash"></i></button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Belum ada data user.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end mt-3">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<!-- Modal Tambah User -->
<div class="modal fade" id="modalTambahUser" tabindex="-1" aria-labelledby="modalTambahUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light border-bottom-0">
                <h5 class="modal-title fw-bold" id="modalTambahUserLabel">Tambah User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-bold">Alamat Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="password" class="form-label fw-bold">Password *</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label fw-bold">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label for="role" class="form-label fw-bold">Role Akses <span class="text-danger">*</span></label>
                            <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required onchange="toggleTokoModal(this.value)">
                                <option value="">-- Pilih Role --</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin Pusat</option>
                                <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>Petugas Gudang</option>
                                <option value="admin_toko" {{ old('role') == 'admin_toko' ? 'selected' : '' }}>Admin Toko</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6" id="toko_wrapper_modal" style="display: {{ old('role') == 'admin_toko' ? 'block' : 'none' }};">
                            <label for="toko_id" class="form-label fw-bold">Pilih Toko Cabang <span class="text-danger">*</span></label>
                            <select class="form-select @error('toko_id') is-invalid @enderror" id="toko_id_modal" name="toko_id">
                                <option value="">-- Pilih Toko --</option>
                                @foreach($tokos as $toko)
                                    <option value="{{ $toko->id }}" {{ old('toko_id') == $toko->id ? 'selected' : '' }}>
                                        {{ $toko->nama_toko }}
                                    </option>
                                @endforeach
                            </select>
                            @error('toko_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 bg-light">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function toggleTokoModal(role) {
        if(role === 'admin_toko') {
            document.getElementById('toko_wrapper_modal').style.display = 'block';
            document.getElementById('toko_id_modal').required = true;
        } else {
            document.getElementById('toko_wrapper_modal').style.display = 'none';
            document.getElementById('toko_id_modal').required = false;
            document.getElementById('toko_id_modal').value = '';
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        @if($errors->any())
            var myModal = new bootstrap.Modal(document.getElementById('modalTambahUser'));
            myModal.show();
        @endif
        
        const roleSelect = document.getElementById('role');
        if(roleSelect) {
            toggleTokoModal(roleSelect.value);
        }
    });
</script>
@endpush

@endsection
