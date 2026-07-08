@extends('layouts.app')

@section('title', 'Master Barang - KT Inventory')
@section('page_heading', 'Master Barang')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-bottom-0 pt-4 pb-3">
        <div class="row align-items-center">
            <div class="col-md-4 d-flex align-items-center mb-3 mb-md-0">
                <h5 class="fw-bold text-secondary mb-0 me-3">Master Barang</h5>
                <button type="button" class="btn btn-primary btn-sm shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahBarang">
                    <i class="fas fa-plus me-1"></i> Tambah
                </button>
            </div>
            <div class="col-md-8">
                <form action="{{ route('barangs.index') }}" method="GET" class="d-flex justify-content-md-end">
                    <div class="input-group" style="max-width: 300px;">
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari barang atau kode..." value="{{ $search ?? '' }}">
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
                        <th width="15%">Kode</th>
                        <th width="20%">Nama Barang</th>
                        <th width="15%">Kategori</th>
                        <th width="10%">Ukuran</th>
                        <th width="10%">Warna</th>
                        <th width="10%">Stok (Kg)</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barangs as $barang)
                    <tr>
                        <td>{{ $loop->iteration + $barangs->firstItem() - 1 }}</td>
                        <td class="fw-bold text-primary">{{ $barang->kode_barang }}</td>
                        <td class="fw-bold">{{ $barang->nama_barang }}</td>
                        <td>{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                        <td><span class="badge bg-secondary">{{ $barang->ukuran }}</span></td>
                        <td>{{ $barang->warna }}</td>
                        <td>{{ number_format($barang->stok_kiloan, 2) }}</td>
                        <td class="text-center">
                            <a href="{{ route('barangs.edit', $barang->id) }}" class="btn btn-sm btn-warning text-white shadow-sm mb-1"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('barangs.destroy', $barang->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger shadow-sm mb-1"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">Belum ada data barang.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end mt-3">
            {{ $barangs->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<!-- Modal Tambah Barang -->
<div class="modal fade" id="modalTambahBarang" tabindex="-1" aria-labelledby="modalTambahBarangLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light border-bottom-0">
                <h5 class="modal-title fw-bold" id="modalTambahBarangLabel">Tambah Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('barangs.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="kode_barang" class="form-label fw-bold">Kode Barang <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('kode_barang') is-invalid @enderror" id="kode_barang" name="kode_barang" value="{{ old('kode_barang') }}" required placeholder="Contoh: BRG-001">
                            @error('kode_barang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="kategori_id" class="form-label fw-bold">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select @error('kategori_id') is-invalid @enderror" id="kategori_id" name="kategori_id" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="nama_barang" class="form-label fw-bold">Nama Barang <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_barang') is-invalid @enderror" id="nama_barang" name="nama_barang" value="{{ old('nama_barang') }}" required>
                        @error('nama_barang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label for="ukuran" class="form-label fw-bold">Ukuran <span class="text-danger">*</span></label>
                            <select class="form-select @error('ukuran') is-invalid @enderror" id="ukuran" name="ukuran" required>
                                <option value="">-- Pilih --</option>
                                @foreach(['16s', '20s', '24s', '30s', '40s'] as $ukuran)
                                    <option value="{{ $ukuran }}" {{ old('ukuran') == $ukuran ? 'selected' : '' }}>{{ $ukuran }}</option>
                                @endforeach
                            </select>
                            @error('ukuran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="warna" class="form-label fw-bold">Warna <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('warna') is-invalid @enderror" id="warna" name="warna" value="{{ old('warna') }}" required>
                            @error('warna')
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

@if($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var myModal = new bootstrap.Modal(document.getElementById('modalTambahBarang'));
        myModal.show();
    });
</script>
@endif

@endsection
