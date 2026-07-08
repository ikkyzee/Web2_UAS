@extends('layouts.app')

@section('title', (isset($armada) ? 'Edit Armada' : 'Tambah Armada') . ' - KT Inventory')
@section('page_heading', isset($armada) ? 'Edit Armada' : 'Tambah Armada')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="{{ isset($armada) ? route('armadas.update', $armada->id) : route('armadas.store') }}" method="POST">
                    @csrf
                    @if(isset($armada))
                        @method('PUT')
                    @endif

                    <div class="mb-3">
                        <label for="plat_nomor" class="form-label fw-bold">Plat Nomor <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('plat_nomor') is-invalid @enderror" id="plat_nomor" name="plat_nomor" value="{{ old('plat_nomor', $armada->plat_nomor ?? '') }}" required placeholder="Contoh: D 1234 XY">
                        @error('plat_nomor')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="jenis_kendaraan" class="form-label fw-bold">Jenis Kendaraan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('jenis_kendaraan') is-invalid @enderror" id="jenis_kendaraan" name="jenis_kendaraan" value="{{ old('jenis_kendaraan', $armada->jenis_kendaraan ?? '') }}" required placeholder="Contoh: Engkel, Box, Fuso">
                        @error('jenis_kendaraan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="nama_supir" class="form-label fw-bold">Nama Supir <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_supir') is-invalid @enderror" id="nama_supir" name="nama_supir" value="{{ old('nama_supir', $armada->nama_supir ?? '') }}" required>
                        @error('nama_supir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('armadas.index') }}" class="btn btn-light border"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
