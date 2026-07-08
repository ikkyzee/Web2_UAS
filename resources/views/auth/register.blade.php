<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Data Stock Gudang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-white">

    <div class="min-h-screen flex">
        <!-- Left Side: Image (Hidden on small screens) -->
        <div class="hidden lg:flex lg:w-1/2 relative bg-gray-900 overflow-hidden">
            <img class="absolute inset-0 h-full w-full object-cover opacity-60" src="{{ asset('images/warehouse_bg.jpg') }}" alt="Textile Warehouse">
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40 to-transparent"></div>
            
            <div class="relative z-10 flex flex-col justify-end p-12 text-white">
                <h1 class="text-4xl font-bold tracking-tight mb-2">Data Stock <span class="text-teal-400">Gudang</span></h1>
                <p class="text-lg text-gray-300 max-w-md">Bergabunglah dengan sistem pelacakan stok dan distribusi roll kain tersentralisasi untuk PT Karunia Textile.</p>
            </div>
        </div>

        <!-- Right Side: Register Form -->
        <div class="w-full lg:w-1/2 flex flex-col justify-center px-8 sm:px-16 md:px-24 xl:px-32 relative py-12">
            
            <!-- Mobile Background Overlay (Only visible on mobile) -->
            <div class="absolute inset-0 lg:hidden z-0">
                <img class="h-full w-full object-cover opacity-20" src="{{ asset('images/warehouse_bg.jpg') }}" alt="Background">
                <div class="absolute inset-0 bg-white/90 backdrop-blur-sm"></div>
            </div>

            <div class="relative z-10 w-full max-w-md mx-auto">
                <div class="text-center lg:text-left mb-8">
                    <h2 class="text-3xl font-bold text-gray-900">Buat Akun Baru</h2>
                    <p class="mt-2 text-sm text-gray-600">Lengkapi form di bawah untuk mendaftar ke Data Stock Gudang.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5" enctype="multipart/form-data">
                    @csrf
                    
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                            <input id="name" name="name" type="text" required value="{{ old('name') }}" autofocus
                                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 sm:text-sm transition-colors {{ $errors->has('name') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : '' }}" 
                                placeholder="Budi Santoso">
                        </div>
                        @error('name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="photo" class="block text-sm font-medium text-gray-700">Foto Profil (Opsional)</label>
                        <div class="mt-1 flex items-center">
                            <input type="file" name="photo" id="photo" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 border border-gray-300 rounded-lg focus:outline-none focus:ring-teal-500 focus:border-teal-500 transition-colors {{ $errors->has('photo') ? 'border-red-500' : '' }}">
                        </div>
                        @error('photo')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 sm:text-sm transition-colors {{ $errors->has('email') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : '' }}" 
                                placeholder="nama@karuniatex.com">
                        </div>
                        @error('email')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role Selection -->
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700">Pilih Peran (Role)</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user-tag text-gray-400"></i>
                            </div>
                            <select id="role" name="role" required class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 sm:text-sm transition-colors {{ $errors->has('role') ? 'border-red-500' : '' }}" onchange="toggleTokoSelect()">
                                <option value="">-- Pilih Role --</option>
                                <option value="admin_pusat" {{ old('role') == 'admin_pusat' ? 'selected' : '' }}>Admin Pusat (Petugas Gudang)</option>
                                <option value="admin_toko" {{ old('role') == 'admin_toko' ? 'selected' : '' }}>Admin Toko</option>
                            </select>
                        </div>
                        @error('role')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Toko Selection (Hidden by default unless Admin Toko) -->
                    <div id="toko_container" style="display: {{ old('role') == 'admin_toko' ? 'block' : 'none' }};">
                        <label for="toko_id" class="block text-sm font-medium text-gray-700">Toko Cabang</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-store text-gray-400"></i>
                            </div>
                            <select id="toko_id" name="toko_id" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 sm:text-sm transition-colors {{ $errors->has('toko_id') ? 'border-red-500' : '' }}">
                                <option value="">-- Pilih Toko --</option>
                                @foreach($tokos as $toko)
                                    <option value="{{ $toko->id }}" {{ old('toko_id') == $toko->id ? 'selected' : '' }}>{{ $toko->nama_toko }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('toko_id')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input id="password" name="password" type="password" autocomplete="new-password" required 
                                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 sm:text-sm transition-colors {{ $errors->has('password') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : '' }}" 
                                placeholder="••••••••">
                        </div>
                        @error('password')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input id="password_confirmation" name="password_confirmation" type="password" required 
                                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 sm:text-sm transition-colors" 
                                placeholder="••••••••">
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-all duration-300 transform hover:-translate-y-0.5">
                            Daftar Sekarang <i class="fas fa-user-plus ml-2 mt-1 text-xs"></i>
                        </button>
                    </div>
                </form>
                
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="font-medium text-teal-600 hover:text-teal-500 transition-colors">
                            Masuk di sini
                        </a>
                    </p>
                </div>
                
                <div class="mt-8 text-center text-xs text-gray-500">
                    &copy; {{ date('Y') }} PT Karunia Textile. All rights reserved.
                </div>
            </div>
        </div>
    </div>

</body>
<script>
    function toggleTokoSelect() {
        var role = document.getElementById('role').value;
        var tokoContainer = document.getElementById('toko_container');
        if (role === 'admin_toko') {
            tokoContainer.style.display = 'block';
            document.getElementById('toko_id').setAttribute('required', 'required');
        } else {
            tokoContainer.style.display = 'none';
            document.getElementById('toko_id').removeAttribute('required');
            document.getElementById('toko_id').value = '';
        }
    }
</script>
</html>
