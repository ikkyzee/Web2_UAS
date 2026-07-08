@extends('layouts.app')

@section('title', 'Master Armada - KT Inventory')
@section('page_heading', 'Master Armada')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-bottom-0 pt-4 pb-3">
        <div class="row align-items-center">
            <div class="col-md-4 d-flex align-items-center mb-3 mb-md-0">
                <h5 class="fw-bold text-secondary mb-0 me-3">Daftar Armada</h5>
                <button type="button" class="btn btn-primary btn-sm shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahArmada">
                    <i class="fas fa-plus me-1"></i> Tambah
                </button>
            </div>
            <div class="col-md-8">
                <form action="{{ route('armadas.index') }}" method="GET" class="d-flex justify-content-md-end">
                    <div class="input-group" style="max-width: 300px;">
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari plat atau supir..." value="{{ $search ?? '' }}">
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
                        <th width="20%">Plat Nomor</th>
                        <th width="25%">Jenis Kendaraan</th>
                        <th width="30%">Nama Supir</th>
                        <th width="20%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($armadas as $armada)
                    <tr>
                        <td>{{ $loop->iteration + $armadas->firstItem() - 1 }}</td>
                        <td class="fw-bold">{{ $armada->plat_nomor }}</td>
                        <td>{{ $armada->jenis_kendaraan }}</td>
                        <td>{{ $armada->nama_supir }}</td>
                        <td class="text-center">
                            <a href="{{ route('armadas.edit', $armada->id) }}" class="btn btn-sm btn-warning text-white shadow-sm"><i class="fas fa-edit"></i> Edit</a>
                            <form action="{{ route('armadas.destroy', $armada->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus armada ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger shadow-sm"><i class="fas fa-trash"></i> Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Belum ada data armada.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end mt-3">
            {{ $armadas->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<!-- Modal Tambah Armada -->
<div class="modal fade" id="modalTambahArmada" tabindex="-1" aria-labelledby="modalTambahArmadaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light border-bottom-0">
                <h5 class="modal-title fw-bold" id="modalTambahArmadaLabel">Tambah Armada</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('armadas.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="plat_nomor" class="form-label fw-bold">Plat Nomor <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('plat_nomor') is-invalid @enderror" id="plat_nomor" name="plat_nomor" value="{{ old('plat_nomor') }}" required placeholder="Contoh: D 1234 XY">
                        @error('plat_nomor')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="jenis_kendaraan" class="form-label fw-bold">Jenis Kendaraan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('jenis_kendaraan') is-invalid @enderror" id="jenis_kendaraan" name="jenis_kendaraan" value="{{ old('jenis_kendaraan') }}" required placeholder="Contoh: Engkel, Box, Fuso">
                        @error('jenis_kendaraan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label for="nama_supir" class="form-label fw-bold">Nama Supir <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_supir') is-invalid @enderror" id="nama_supir" name="nama_supir" value="{{ old('nama_supir') }}" required>
                        @error('nama_supir')
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
        var myModal = new bootstrap.Modal(document.getElementById('modalTambahArmada'));
        myModal.show();
    });
</script>
@endif

@endsection
