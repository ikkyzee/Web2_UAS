@extends('layouts.app')

@section('title', 'Tambah Supplier - KT Inventory')
@section('page_heading', 'Tambah Supplier')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="{{ route('suppliers.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Supplier <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama_supplier" required>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Kontak Person</label>
                            <input type="text" class="form-control" name="kontak_person">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">No Telepon</label>
                            <input type="text" class="form-control" name="no_telepon">
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Alamat Lengkap</label>
                        <textarea class="form-control" name="alamat" rows="3"></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('suppliers.index') }}" class="btn btn-light border"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
