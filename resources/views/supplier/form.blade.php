@extends('layouts.app')

@section('title', (isset($supplier) ? 'Edit Supplier' : 'Tambah Supplier') . ' - KT Inventory')
@section('page_heading', isset($supplier) ? 'Edit Supplier' : 'Tambah Supplier')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
        <div class="p-6">
            <form action="{{ isset($supplier) ? route('suppliers.update', $supplier->id) : route('suppliers.store') }}" method="POST">
                @csrf
                @if(isset($supplier))
                    @method('PUT')
                @endif

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Supplier <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_supplier" value="{{ old('nama_supplier', $supplier->nama_supplier ?? '') }}" required 
                            class="mt-1 focus:ring-brand-500 focus:border-brand-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kontak Person</label>
                            <input type="text" name="kontak_person" value="{{ old('kontak_person', $supplier->kontak_person ?? '') }}" 
                                class="mt-1 focus:ring-brand-500 focus:border-brand-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">No Telepon</label>
                            <input type="text" name="no_telepon" value="{{ old('no_telepon', $supplier->no_telepon ?? '') }}" 
                                class="mt-1 focus:ring-brand-500 focus:border-brand-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                        <textarea name="alamat" rows="4"
                            class="mt-1 shadow-sm focus:ring-brand-500 focus:border-brand-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ old('alamat', $supplier->alamat ?? '') }}</textarea>
                    </div>
                </div>

                <div class="mt-8 flex justify-end gap-3 pt-5 border-t border-gray-100">
                    <a href="{{ route('suppliers.index') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        <i class="fas fa-arrow-left mr-2 mt-1"></i> Kembali
                    </a>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-brand-600 hover:bg-brand-700 transition-colors">
                        <i class="fas fa-save mr-2 mt-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
