<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Data Stock Gudang</title>
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
                <p class="text-lg text-gray-300 max-w-md">Sistem pelacakan stok dan distribusi roll kain tersentralisasi. Mengelola aset gudang menjadi lebih cepat dan presisi.</p>
            </div>
        </div>

        <!-- Right Side: Forgot Password Form -->
        <div class="w-full lg:w-1/2 flex flex-col justify-center px-8 sm:px-16 md:px-24 xl:px-32 relative">
            
            <!-- Mobile Background Overlay -->
            <div class="absolute inset-0 lg:hidden z-0">
                <img class="h-full w-full object-cover opacity-20" src="{{ asset('images/warehouse_bg.jpg') }}" alt="Background">
                <div class="absolute inset-0 bg-white/90 backdrop-blur-sm"></div>
            </div>

            <div class="relative z-10 w-full max-w-md mx-auto">
                <div class="text-center lg:text-left mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-3">Lupa Password?</h2>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Tidak masalah. Cukup beritahu kami alamat email Anda, dan kami akan mengirimkan tautan untuk mereset password agar Anda bisa memilih password baru.
                    </p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-md">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-green-700 font-medium">{{ session('status') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}" autofocus
                                class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 sm:text-sm transition-colors {{ $errors->has('email') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : '' }}" 
                                placeholder="nama@karuniatex.com">
                        </div>
                        @error('email')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-all duration-300 transform hover:-translate-y-0.5">
                            Kirim Tautan Reset Password <i class="fas fa-paper-plane ml-2 mt-1 text-xs"></i>
                        </button>
                    </div>
                </form>
                
                <div class="mt-8 text-center">
                    <a href="{{ route('login') }}" class="font-medium text-sm text-teal-600 hover:text-teal-500 transition-colors">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali ke halaman Login
                    </a>
                </div>
                
                <div class="mt-12 text-center text-xs text-gray-500">
                    &copy; {{ date('Y') }} PT Karunia Textile. All rights reserved.
                </div>
            </div>
        </div>
    </div>

</body>
</html>
