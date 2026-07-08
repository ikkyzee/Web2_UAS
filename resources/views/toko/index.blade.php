@extends('layouts.app')

@section('title', 'Master Toko - KT Inventory')
@section('page_heading', 'Master Toko')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-bottom-0 pt-4 pb-3">
        <div class="row align-items-center">
            <div class="col-md-4 d-flex align-items-center mb-3 mb-md-0">
                <h5 class="fw-bold text-secondary mb-0 me-3">Daftar Toko Cabang</h5>
                <button type="button" class="btn btn-primary btn-sm shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahToko">
                    <i class="fas fa-plus me-1"></i> Tambah
                </button>
            </div>
            <div class="col-md-8">
                <form action="{{ route('tokos.index') }}" method="GET" class="d-flex justify-content-md-end">
                    <div class="input-group" style="max-width: 300px;">
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari toko atau alamat..." value="{{ $search ?? '' }}">
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
                        <th width="35%">Nama Toko</th>
                        <th width="40%">Alamat</th>
                        <th width="20%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tokos as $toko)
                    <tr>
                        <td>{{ $loop->iteration + $tokos->firstItem() - 1 }}</td>
                        <td class="fw-bold">{{ $toko->nama_toko }}</td>
                        <td>{{ $toko->alamat_toko }}</td>
                        <td class="text-center">
                            <a href="{{ route('tokos.edit', $toko->id) }}" class="btn btn-sm btn-warning text-white shadow-sm"><i class="fas fa-edit"></i> Edit</a>
                            <form action="{{ route('tokos.destroy', $toko->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus toko ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger shadow-sm"><i class="fas fa-trash"></i> Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">Belum ada data toko.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end mt-3">
            {{ $tokos->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<!-- Modal Tambah Toko -->
<div class="modal fade" id="modalTambahToko" tabindex="-1" aria-labelledby="modalTambahTokoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light border-bottom-0">
                <h5 class="modal-title fw-bold" id="modalTambahTokoLabel">Tambah Toko</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('tokos.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="nama_toko" class="form-label fw-bold">Nama Toko <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_toko') is-invalid @enderror" id="nama_toko" name="nama_toko" value="{{ old('nama_toko') }}" required>
                        @error('nama_toko')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label for="alamat_toko" class="form-label fw-bold">Alamat Lengkap <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('alamat_toko') is-invalid @enderror" id="alamat_toko" name="alamat_toko" rows="3" required>{{ old('alamat_toko') }}</textarea>
                        @error('alamat_toko')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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

@if($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var myModal = new bootstrap.Modal(document.getElementById('modalTambahToko'));
        myModal.show();
    });
</script>
@endif

@endsection
