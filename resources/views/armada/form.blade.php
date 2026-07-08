@extends('layouts.app')

@section('title', (isset($armada) ? 'Edit Armada' : 'Tambah Armada') . ' - KT Inventory')
@section('page_heading', isset($armada) ? 'Edit Armada' : 'Tambah Armada')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
        <div class="p-6">
            <form action="{{ isset($armada) ? route('armadas.update', $armada->id) : route('armadas.store') }}" method="POST">
                @csrf
                @if(isset($armada))
                    @method('PUT')
                @endif

                <div class="space-y-6">
                    <div>
                        <label for="plat_nomor" class="block text-sm font-medium text-gray-700">Plat Nomor <span class="text-red-500">*</span></label>
                        <input type="text" id="plat_nomor" name="plat_nomor" value="{{ old('plat_nomor', $armada->plat_nomor ?? '') }}" required placeholder="Contoh: D 1234 XY"
                            class="mt-1 focus:ring-brand-500 focus:border-brand-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        @error('plat_nomor')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="jenis_kendaraan" class="block text-sm font-medium text-gray-700">Jenis Kendaraan <span class="text-red-500">*</span></label>
                        <input type="text" id="jenis_kendaraan" name="jenis_kendaraan" value="{{ old('jenis_kendaraan', $armada->jenis_kendaraan ?? '') }}" required placeholder="Contoh: Engkel, Box"
                            class="mt-1 focus:ring-brand-500 focus:border-brand-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        @error('jenis_kendaraan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nama_supir" class="block text-sm font-medium text-gray-700">Nama Supir <span class="text-red-500">*</span></label>
                        <input type="text" id="nama_supir" name="nama_supir" value="{{ old('nama_supir', $armada->nama_supir ?? '') }}" required
                            class="mt-1 focus:ring-brand-500 focus:border-brand-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        @error('nama_supir')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-8 flex justify-end gap-3 pt-5 border-t border-gray-100">
                    <a href="{{ route('armadas.index') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
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
