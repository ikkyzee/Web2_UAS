@extends('layouts.app')

@section('title', (isset($toko) ? 'Edit Toko' : 'Tambah Toko') . ' - KT Inventory')
@section('page_heading', isset($toko) ? 'Edit Toko' : 'Tambah Toko')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="{{ isset($toko) ? route('tokos.update', $toko->id) : route('tokos.store') }}" method="POST">
                    @csrf
                    @if(isset($toko))
                        @method('PUT')
                    @endif

                    <div class="mb-3">
                        <label for="nama_toko" class="form-label fw-bold">Nama Toko <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_toko') is-invalid @enderror" id="nama_toko" name="nama_toko" value="{{ old('nama_toko', $toko->nama_toko ?? '') }}" required>
                        @error('nama_toko')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="alamat_toko" class="form-label fw-bold">Alamat Lengkap <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('alamat_toko') is-invalid @enderror" id="alamat_toko" name="alamat_toko" rows="4" required>{{ old('alamat_toko', $toko->alamat_toko ?? '') }}</textarea>
                        @error('alamat_toko')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('tokos.index') }}" class="btn btn-light border"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
