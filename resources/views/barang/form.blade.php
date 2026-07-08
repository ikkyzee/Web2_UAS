@extends('layouts.app')

@section('title', (isset($barang) ? 'Edit Barang' : 'Tambah Barang') . ' - KT Inventory')
@section('page_heading', isset($barang) ? 'Edit Barang' : 'Tambah Barang')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="{{ isset($barang) ? route('barangs.update', $barang->id) : route('barangs.store') }}" method="POST">
                    @csrf
                    @if(isset($barang))
                        @method('PUT')
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="kode_barang" class="form-label fw-bold">Kode Barang <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('kode_barang') is-invalid @enderror" id="kode_barang" name="kode_barang" value="{{ old('kode_barang', $barang->kode_barang ?? '') }}" required placeholder="Contoh: BRG-001">
                            @error('kode_barang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="kategori_id" class="form-label fw-bold">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select @error('kategori_id') is-invalid @enderror" id="kategori_id" name="kategori_id" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}" {{ old('kategori_id', $barang->kategori_id ?? '') == $kategori->id ? 'selected' : '' }}>
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
                        <input type="text" class="form-control @error('nama_barang') is-invalid @enderror" id="nama_barang" name="nama_barang" value="{{ old('nama_barang', $barang->nama_barang ?? '') }}" required>
                        @error('nama_barang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="ukuran" class="form-label fw-bold">Ukuran <span class="text-danger">*</span></label>
                            <select class="form-select @error('ukuran') is-invalid @enderror" id="ukuran" name="ukuran" required>
                                <option value="">-- Pilih --</option>
                                @foreach(['16s', '20s', '24s', '30s', '40s'] as $ukuran)
                                    <option value="{{ $ukuran }}" {{ old('ukuran', $barang->ukuran ?? '') == $ukuran ? 'selected' : '' }}>{{ $ukuran }}</option>
                                @endforeach
                            </select>
                            @error('ukuran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="warna" class="form-label fw-bold">Warna <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('warna') is-invalid @enderror" id="warna" name="warna" value="{{ old('warna', $barang->warna ?? '') }}" required>
                            @error('warna')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('barangs.index') }}" class="btn btn-light border"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
