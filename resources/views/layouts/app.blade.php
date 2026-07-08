<!DOCTYPE html>
<html lang="id" class="antialiased text-gray-900 bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Data Stock Gudang')</title>
    
    <!-- Tailwind CSS (via CDN for simplicity as requested, though Vite is recommended for production) -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Tailwind Config for Custom Colors/Fonts -->
    <script>
        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
        
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#f0fdfa',
                            100: '#ccfbf1',
                            500: '#14b8a6',
                            600: '#0d9488',
                            700: '#0f766e',
                            800: '#115e59',
                            900: '#134e4a',
                        },
                        sidebar: '#1e293b',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <style>
        /* Custom Scrollbar for better UI */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        
        .dark ::-webkit-scrollbar-track { background: #1f2937; }
        .dark ::-webkit-scrollbar-thumb { background: #4b5563; }
        .dark ::-webkit-scrollbar-thumb:hover { background: #6b7280; }
        
        /* Smooth transitions */
        .transition-all { transition-property: all; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); transition-duration: 300ms; }
    </style>
    
    <style type="text/tailwindcss">
        @layer base {
            /* Input Visibility Fixes */
            input[type="text"], input[type="email"], input[type="password"], input[type="number"], input[type="date"], select, textarea {
                @apply border-2 border-gray-400 bg-white text-gray-900 rounded-md focus:border-brand-500 focus:ring-brand-500 dark:border-gray-500 dark:bg-gray-700 dark:text-white !important;
            }
            
            /* Global Dark Mode Overrides for utility classes used in the project */
            .dark body { @apply bg-gray-900; }
            .dark .bg-white { background-color: #1f2937 !important; } /* bg-gray-800 */
            .dark .bg-gray-50 { background-color: #111827 !important; } /* bg-gray-900 */
            .dark .bg-gray-100 { background-color: #111827 !important; } /* bg-gray-900 */
            .dark .text-gray-900, .dark .text-gray-800 { color: #f9fafb !important; } /* text-gray-50 */
            .dark .text-gray-700 { color: #e5e7eb !important; } /* text-gray-200 */
            .dark .text-gray-600, .dark .text-gray-500 { color: #9ca3af !important; } /* text-gray-400 */
            .dark .text-gray-400 { color: #6b7280 !important; } /* text-gray-500 */
            .dark .border-gray-100, .dark .border-gray-200, .dark .border-gray-300 { border-color: #374151 !important; } /* border-gray-700 */
            .dark .divide-gray-200 > :not([hidden]) ~ :not([hidden]) { border-color: #374151 !important; }
            .dark thead.bg-gray-50 { background-color: #374151 !important; } /* bg-gray-700 */
            .dark tbody tr:hover { background-color: #374151 !important; } /* bg-gray-700 */
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal flex h-screen overflow-hidden">
    
    <!-- Sidebar -->
    <aside class="bg-sidebar w-64 flex-shrink-0 hidden md:flex flex-col shadow-xl transition-all duration-300">
        <div class="h-16 flex items-center justify-center border-b border-gray-700 px-4">
            <h1 class="text-white text-lg font-bold tracking-widest uppercase">
                Data Stock<span class="text-brand-500"> Gudang</span>
            </h1>
        </div>
        
        <div class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
            <a href="{{ url('/dashboard') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->is('dashboard') ? 'bg-brand-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <i class="fas fa-home w-6 text-center me-2"></i> Dashboard
            </a>
            
            @if(auth()->user() && in_array(auth()->user()->role, ['admin', 'admin_pusat']))
            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Data Master</p>
            </div>
            <a href="{{ url('/kategoris') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->is('kategoris*') ? 'bg-brand-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <i class="fas fa-tags w-6 text-center me-2"></i> Kategori
            </a>
            <a href="{{ url('/barangs') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->is('barangs*') ? 'bg-brand-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <i class="fas fa-box w-6 text-center me-2"></i> Barang
            </a>
            <a href="{{ url('/tokos') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->is('tokos*') ? 'bg-brand-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <i class="fas fa-store w-6 text-center me-2"></i> Toko
            </a>
            <a href="{{ url('/armadas') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->is('armadas*') ? 'bg-brand-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <i class="fas fa-truck w-6 text-center me-2"></i> Armada
            </a>
            <a href="{{ url('/suppliers') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->is('suppliers*') ? 'bg-brand-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <i class="fas fa-building w-6 text-center me-2"></i> Supplier
            </a>
            @endif
            
            @if(auth()->user() && auth()->user()->role === 'admin')
            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">User Management</p>
            </div>
            <a href="{{ url('/users') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->is('users*') ? 'bg-brand-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <i class="fas fa-users w-6 text-center me-2"></i> Users
            </a>
            @endif
            
            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Transaksi & Laporan</p>
            </div>
            @if(auth()->user() && in_array(auth()->user()->role, ['admin', 'admin_pusat']))
            <a href="{{ url('/penerimaans') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->is('penerimaans*') ? 'bg-brand-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <i class="fas fa-arrow-circle-down w-6 text-center me-2"></i> Penerimaan Roll
            </a>
            @endif
            <a href="{{ url('/pengirimans') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->is('pengirimans*') ? 'bg-brand-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <i class="fas fa-shipping-fast w-6 text-center me-2"></i> Pengiriman Keluar
            </a>
            <a href="{{ url('/laporan-stok') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->is('laporan-stok*') ? 'bg-brand-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <i class="fas fa-chart-bar w-6 text-center me-2"></i> Laporan Stok
            </a>
        </div>
    </aside>

    <!-- Main Content wrapper -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden relative">
        
        <!-- Top Navbar -->
        <header class="h-16 bg-white shadow-sm flex items-center justify-between px-4 sm:px-6 lg:px-8 z-10">
            <!-- Mobile menu button & Title -->
            <div class="flex items-center gap-4">
                <button class="md:hidden text-gray-500 hover:text-gray-700 focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <h2 class="text-xl font-semibold text-gray-800 hidden sm:block">@yield('page_heading', 'Dashboard Overview')</h2>
            </div>

            <!-- Right side / Profile Dropdown (Alpine.js) -->
            <div class="flex items-center gap-4">
                
                <!-- Dark Mode Toggle Button -->
                <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 transition-colors">
                    <i id="theme-toggle-dark-icon" class="fas fa-moon hidden text-lg"></i>
                    <i id="theme-toggle-light-icon" class="fas fa-sun hidden text-lg"></i>
                </button>

                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open" class="flex items-center gap-3 focus:outline-none transition-transform transform hover:scale-105">
                        <div class="text-right hidden md:block">
                            <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name ?? 'Guest' }}</p>
                            <p class="text-xs text-gray-500 capitalize">{{ auth()->user()->role ?? '-' }}</p>
                        </div>
                        <!-- Avatar -->
                        <img class="h-10 w-10 rounded-full object-cover border-2 border-brand-500 shadow-sm" 
                             src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name ?? 'G').'&background=0d9488&color=fff' }}" 
                             alt="User Avatar">
                        <i class="fas fa-chevron-down text-xs text-gray-400 transition-transform duration-200" :class="{'rotate-180': open}"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
                         style="display: none;">
                        <div class="py-1">
                            <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-brand-600 transition-colors">
                                <i class="fas fa-user-circle w-5 text-center me-2"></i> Edit Profil
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors">
                                    <i class="fas fa-sign-out-alt w-5 text-center me-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="flex-1 overflow-y-auto bg-gray-50 p-4 sm:p-6 lg:p-8">
            <h2 class="text-xl font-bold text-gray-800 sm:hidden mb-4">@yield('page_heading', 'Dashboard Overview')</h2>
            
            @yield('content')
            
        </main>
    </div>

    <!-- SweetAlert2 Alerts Component -->
    @include('components.alert')

    <!-- Live Search Script & Additional Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Theme Toggle Logic
            const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
            const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
            const themeToggleBtn = document.getElementById('theme-toggle');

            // Change the icons inside the button based on previous settings
            if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                themeToggleLightIcon.classList.remove('hidden');
            } else {
                themeToggleDarkIcon.classList.remove('hidden');
            }

            if(themeToggleBtn) {
                themeToggleBtn.addEventListener('click', function() {
                    // toggle icons
                    themeToggleDarkIcon.classList.toggle('hidden');
                    themeToggleLightIcon.classList.toggle('hidden');

                    // if set via local storage previously
                    if (localStorage.getItem('theme')) {
                        if (localStorage.getItem('theme') === 'light') {
                            document.documentElement.classList.add('dark');
                            localStorage.setItem('theme', 'dark');
                        } else {
                            document.documentElement.classList.remove('dark');
                            localStorage.setItem('theme', 'light');
                        }
                    // if NOT set via local storage previously
                    } else {
                        if (document.documentElement.classList.contains('dark')) {
                            document.documentElement.classList.remove('dark');
                            localStorage.setItem('theme', 'light');
                        } else {
                            document.documentElement.classList.add('dark');
                            localStorage.setItem('theme', 'dark');
                        }
                    }
                });
            }

            // Live Search (Debounce) using Alpine/Vanilla JS
            const searchInputs = document.querySelectorAll('input[name="search"]');
            let debounceTimer;

            searchInputs.forEach(input => {
                input.addEventListener('input', function() {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(() => {
                        const form = this.closest('form');
                        if(!form) return;
                        form.submit(); // Direct submit is safer without full Vue/React router for now. AJAX pagination needs to update DOM properly.
                    }, 500); 
                });
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>
