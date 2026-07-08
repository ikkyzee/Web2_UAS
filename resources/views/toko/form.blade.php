@extends('layouts.app')

@section('title', (isset($toko) ? 'Edit Toko' : 'Tambah Toko') . ' - KT Inventory')
@section('page_heading', isset($toko) ? 'Edit Toko' : 'Tambah Toko')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
        <div class="p-6">
            <form action="{{ isset($toko) ? route('tokos.update', $toko->id) : route('tokos.store') }}" method="POST">
                @csrf
                @if(isset($toko))
                    @method('PUT')
                @endif

                <div class="space-y-6">
                    <div>
                        <label for="nama_toko" class="block text-sm font-medium text-gray-700">Nama Toko <span class="text-red-500">*</span></label>
                        <input type="text" id="nama_toko" name="nama_toko" value="{{ old('nama_toko', $toko->nama_toko ?? '') }}" required 
                            class="mt-1 focus:ring-brand-500 focus:border-brand-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        @error('nama_toko')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="alamat_toko" class="block text-sm font-medium text-gray-700">Alamat Lengkap <span class="text-red-500">*</span></label>
                        <textarea id="alamat_toko" name="alamat_toko" rows="4" required
                            class="mt-1 shadow-sm focus:ring-brand-500 focus:border-brand-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ old('alamat_toko', $toko->alamat_toko ?? '') }}</textarea>
                        @error('alamat_toko')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-8 flex justify-end gap-3 pt-5 border-t border-gray-100">
                    <a href="{{ route('tokos.index') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
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
