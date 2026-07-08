@extends('layouts.app')

@section('title', 'Edit Profil - KT Inventory')
@section('page_heading', 'Pengaturan Profil')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    <!-- Update Profile Information -->
    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        <div class="max-w-xl">
            <header>
                <h2 class="text-lg font-medium text-gray-900">
                    Informasi Profil
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    Perbarui informasi profil akun dan alamat email Anda.
                </p>
            </header>

            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                @csrf
            </form>

            <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
                @csrf
                @method('patch')

                <!-- Photo Upload -->
                <div x-data="{ photoName: null, photoPreview: null }" class="col-span-6 sm:col-span-4">
                    <input type="file" class="hidden" name="photo" x-ref="photo"
                        x-on:change="
                                photoName = $refs.photo.files[0].name;
                                const reader = new FileReader();
                                reader.onload = (e) => {
                                    photoPreview = e.target.result;
                                };
                                reader.readAsDataURL($refs.photo.files[0]);
                        " />

                    <label class="block text-sm font-medium text-gray-700" for="photo">
                        Foto Profil
                    </label>

                    <div class="mt-2 flex items-center gap-4">
                        <!-- Current Profile Photo -->
                        <div x-show="! photoPreview" class="relative h-20 w-20 rounded-full overflow-hidden border border-gray-200">
                            <img src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name ?? 'G').'&background=0d9488&color=fff' }}" alt="{{ auth()->user()->name }}" class="object-cover w-full h-full">
                        </div>

                        <!-- New Profile Photo Preview -->
                        <div x-show="photoPreview" style="display: none;" class="relative h-20 w-20 rounded-full overflow-hidden border border-gray-200">
                            <span class="block w-full h-full bg-cover bg-no-repeat bg-center"
                                  x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                            </span>
                        </div>

                        <button type="button" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 mt-2" x-on:click.prevent="$refs.photo.click()">
                            Pilih Foto Baru
                        </button>
                    </div>
                    @error('photo')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                    <input id="name" name="name" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                    @error('name')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" name="email" type="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm" value="{{ old('email', $user->email) }}" required autocomplete="username" />
                    @error('email')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-4">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-brand-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-brand-700 focus:bg-brand-700 active:bg-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Simpan Perubahan
                    </button>
                    
                    @if (session('status') === 'profile-updated')
                        <p class="text-sm text-gray-600">Tersimpan.</p>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Update Password -->
    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        <div class="max-w-xl">
            <header>
                <h2 class="text-lg font-medium text-gray-900">
                    Perbarui Password
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.
                </p>
            </header>

            <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                @csrf
                @method('put')

                <div>
                    <label for="update_password_current_password" class="block text-sm font-medium text-gray-700">Password Saat Ini</label>
                    <input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm" autocomplete="current-password" />
                    @error('current_password', 'updatePassword')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="update_password_password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                    <input id="update_password_password" name="password" type="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm" autocomplete="new-password" />
                    @error('password', 'updatePassword')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="update_password_password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                    <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm" autocomplete="new-password" />
                    @error('password_confirmation', 'updatePassword')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-4">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Ubah Password
                    </button>
                    
                    @if (session('status') === 'password-updated')
                        <p class="text-sm text-gray-600">Berhasil diperbarui.</p>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
