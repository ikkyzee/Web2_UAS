<!DOCTYPE html>
<html lang="id" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Distribusi PT Karunia Textile')</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar { min-height: 100vh; background-color: #212529; color: white; }
        .sidebar a { color: #adb5bd; text-decoration: none; padding: 10px 20px; display: block; transition: 0.3s; font-size: 0.95rem; }
        .sidebar a:hover, .sidebar a.active { color: white; background-color: #343a40; border-radius: 5px;}
        .card-stats { border: none; transition: transform 0.2s; }
        .card-stats:hover { transform: translateY(-5px); }
        .sidebar-heading { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: #6c757d; margin: 15px 20px 5px; font-weight: bold; }
    </style>
    <!-- Script untuk memuat Dark Mode seketika -->
    <script>
        const storedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-bs-theme', storedTheme);
    </script>
    @stack('styles')
</head>
<body class="bg-light">
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar py-3 shadow-lg" style="width: 260px;">
            <h5 class="mb-4 mt-2 text-center text-light border-bottom pb-3 px-2">
                Data Stock<br>
                <small style="font-size: 0.85rem; font-weight: normal; color: #adb5bd;">Gudang</small>
            </h5>
            <nav class="px-2">
                <a href="{{ url('/dashboard') }}" class="{{ request()->is('dashboard') ? 'bg-primary text-white rounded mb-1' : 'mb-1' }}"><i class="fas fa-home me-2 w-20"></i> Dashboard</a>
                
                @if(auth()->user() && in_array(auth()->user()->role, ['admin', 'petugas']))
                <div class="sidebar-heading">Data Master</div>
                <a href="{{ url('/kategoris') }}" class="{{ request()->is('kategoris*') ? 'bg-primary text-white rounded mb-1' : 'mb-1' }}"><i class="fas fa-tags me-2"></i> Kategori</a>
                <a href="{{ url('/barangs') }}" class="{{ request()->is('barangs*') ? 'bg-primary text-white rounded mb-1' : 'mb-1' }}"><i class="fas fa-box me-2"></i> Barang</a>
                <a href="{{ url('/tokos') }}" class="{{ request()->is('tokos*') ? 'bg-primary text-white rounded mb-1' : 'mb-1' }}"><i class="fas fa-store me-2"></i> Toko</a>
                <a href="{{ url('/armadas') }}" class="{{ request()->is('armadas*') ? 'bg-primary text-white rounded mb-1' : 'mb-1' }}"><i class="fas fa-truck me-2"></i> Armada</a>
                <a href="{{ url('/suppliers') }}" class="{{ request()->is('suppliers*') ? 'bg-primary text-white rounded mb-1' : 'mb-1' }}"><i class="fas fa-building me-2"></i> Supplier</a>
                @endif
                
                @if(auth()->user() && auth()->user()->role === 'admin')
                <div class="sidebar-heading">User Management</div>
                <a href="{{ url('/users') }}" class="{{ request()->is('users*') ? 'bg-primary text-white rounded mb-1' : 'mb-1' }}"><i class="fas fa-users me-2"></i> Users</a>
                @endif
                
                <div class="sidebar-heading">Transaksi & Laporan</div>
                @if(auth()->user() && in_array(auth()->user()->role, ['admin', 'petugas']))
                <a href="{{ url('/barang-masuks') }}" class="{{ request()->is('barang-masuks*') ? 'bg-primary text-white rounded mb-1' : 'mb-1' }}"><i class="fas fa-arrow-circle-down me-2"></i> Barang Masuk</a>
                @endif
                <a href="{{ url('/pengirimans') }}" class="{{ request()->is('pengirimans*') ? 'bg-primary text-white rounded mb-1' : 'mb-1' }}"><i class="fas fa-shipping-fast me-2"></i> Pengiriman Keluar</a>
                <a href="{{ url('/laporan-stok') }}" class="{{ request()->is('laporan-stok*') ? 'bg-primary text-white rounded mb-1' : 'mb-1' }}"><i class="fas fa-chart-bar me-2"></i> Laporan Stok</a>
                
                <form method="POST" action="{{ route('logout') }}" class="mt-4 px-3">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm w-100"><i class="fas fa-sign-out-alt me-2"></i> Logout</button>
                </form>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-grow-1 p-4" style="height: 100vh; overflow-y: auto;">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white mb-4 shadow-sm rounded px-3 py-2 d-flex justify-content-between align-items-center">
                <span class="navbar-brand fw-bold mb-0 h1">@yield('page_heading', 'Dashboard Overview')</span>
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-sm btn-outline-secondary rounded-circle" id="theme-toggle" title="Toggle Dark Mode">
                        <i class="fas fa-moon"></i>
                    </button>
                    <span class="text-muted">Halo, <strong>{{ auth()->user()->name ?? 'Guest' }}</strong> ({{ auth()->user()->role ?? '-' }})</span>
                </div>
            </nav>

            <!-- Alerts -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Content Area -->
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('theme-toggle').addEventListener('click', () => {
            const currentTheme = document.documentElement.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            
            // Toggle icon
            const icon = document.querySelector('#theme-toggle i');
            if(newTheme === 'dark') {
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
            } else {
                icon.classList.remove('fa-sun');
                icon.classList.add('fa-moon');
            }
        });
        
        // Init icon state
        window.addEventListener('DOMContentLoaded', () => {
            if(document.documentElement.getAttribute('data-bs-theme') === 'dark') {
                const icon = document.querySelector('#theme-toggle i');
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
            }
        });
    </script>
    
    <!-- Live Search & AJAX Pagination Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Live Search (Debounce)
            const searchInputs = document.querySelectorAll('input[name="search"]');
            let debounceTimer;

            searchInputs.forEach(input => {
                input.addEventListener('input', function() {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(() => {
                        const form = this.closest('form');
                        if(!form) return;
                        
                        const url = new URL(form.action);
                        url.searchParams.set('search', this.value);
                        
                        fetchTableData(url);
                    }, 400); // 400ms delay before fetching
                });
            });

            // 2. AJAX Pagination
            document.body.addEventListener('click', function(e) {
                const paginationLink = e.target.closest('.pagination a');
                if(paginationLink) {
                    e.preventDefault();
                    const url = new URL(paginationLink.href);
                    fetchTableData(url);
                }
            });

            // Reusable fetch function
            function fetchTableData(url) {
                // Update Browser URL without reloading
                window.history.pushState({}, '', url);

                // Adding visual feedback (opacity)
                const currentCardBody = document.querySelector('.card-body');
                if(currentCardBody) currentCardBody.style.opacity = '0.5';

                fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    
                    const newCardBody = doc.querySelector('.card-body');
                    
                    if(newCardBody && currentCardBody) {
                        currentCardBody.innerHTML = newCardBody.innerHTML;
                        currentCardBody.style.opacity = '1'; // Restore opacity
                    }
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    if(currentCardBody) currentCardBody.style.opacity = '1';
                });
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
