@extends('layouts.app')

@section('title', (isset($user) ? 'Edit User' : 'Tambah User') . ' - KT Inventory')
@section('page_heading', isset($user) ? 'Edit User' : 'Tambah User')

@section('content')
<div class="max-w-4xl" x-data="{ role: '{{ old('role', $user->role ?? '') }}' }">
    <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
        <div class="p-6">
            <form action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}" method="POST">
                @csrf
                @if(isset($user))
                    @method('PUT')
                @endif

                <div class="space-y-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" required 
                                class="mt-1 focus:ring-brand-500 focus:border-brand-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Alamat Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" required 
                                class="mt-1 focus:ring-brand-500 focus:border-brand-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Password {{ isset($user) ? '(Kosongkan jika tidak diubah)' : '*' }}</label>
                            <input type="password" name="password" {{ isset($user) ? '' : 'required' }} 
                                class="mt-1 focus:ring-brand-500 focus:border-brand-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Konfirmasi Password {{ isset($user) ? '(Kosongkan jika tidak diubah)' : '*' }}</label>
                            <input type="password" name="password_confirmation" {{ isset($user) ? '' : 'required' }} 
                                class="mt-1 focus:ring-brand-500 focus:border-brand-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Role Akses <span class="text-red-500">*</span></label>
                            <select name="role" x-model="role" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm">
                                <option value="">-- Pilih Role --</option>
                                <option value="admin">Admin Pusat</option>
                                <option value="admin_pusat">Admin Pusat (Petugas Gudang)</option>
                                <option value="admin_toko">Admin Toko</option>
                            </select>
                        </div>
                        <div x-show="role === 'admin_toko'" style="display: none;">
                            <label class="block text-sm font-medium text-gray-700">Pilih Toko Cabang <span class="text-red-500">*</span></label>
                            <select name="toko_id" x-bind:required="role === 'admin_toko'" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm">
                                <option value="">-- Pilih Toko --</option>
                                @foreach($tokos as $toko)
                                    <option value="{{ $toko->id }}" {{ old('toko_id', $user->toko_id ?? '') == $toko->id ? 'selected' : '' }}>
                                        {{ $toko->nama_toko }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-end gap-3 pt-5 border-t border-gray-100">
                    <a href="{{ route('users.index') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
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
