<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Stock Gudang - Login</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <script>
        // Check local storage for theme
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <style>
        :root {
            --primary-blue: #0d6efd;
            --dark-steel: #212529;
            --logistics-orange: #fd7e14;
            --off-white: #f8f9fa;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--off-white);
            color: var(--dark-steel);
            overflow-x: hidden;
        }

        .brand-font {
            font-family: 'Inter', sans-serif;
            font-weight: 800;
            letter-spacing: -1px;
        }

        /* Split Screen Layout */
        .auth-container {
            min-height: 100vh;
            display: flex;
            flex-wrap: wrap;
        }

        .auth-image {
            width: 55%;
            /* Image of a modern warehouse / racks */
            background-image: url('https://images.unsplash.com/photo-1586528116311-ad8ed7c83a75?q=80&w=2000&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .auth-image::after {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(to bottom, rgba(33, 37, 41, 0.4), rgba(33, 37, 41, 0.9));
        }

        .auth-image-content {
            position: absolute;
            bottom: 10%;
            left: 10%;
            z-index: 2;
            color: white;
            max-width: 80%;
        }

        .auth-form-wrapper {
            width: 45%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 4rem;
            background-color: white;
            animation: fadeIn 0.6s ease-out;
        }

        .auth-form-inner {
            width: 100%;
            max-width: 420px;
        }

        /* Form Controls - Improved Visibility */
        .form-control {
            background-color: #ffffff;
            border: 2px solid #adb5bd;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 0.95rem;
            transition: all 0.2s;
            color: var(--dark-steel);
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
            border-color: var(--primary-blue);
            background-color: white;
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--dark-steel);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        /* Dark Mode Overrides */
        html.dark body {
            background-color: #121212;
            color: #f8f9fa;
        }
        
        html.dark .auth-form-wrapper {
            background-color: #1e1e1e;
        }
        
        html.dark .form-control {
            background-color: #2b2b2b;
            border-color: #6c757d;
            color: #ffffff;
        }
        
        html.dark .form-control:focus {
            background-color: #1e1e1e;
            border-color: var(--primary-blue);
            color: #ffffff;
        }
        
        html.dark .form-label {
            color: #adb5bd;
        }
        
        html.dark h2, html.dark h3, html.dark h4, html.dark h5 {
            color: #ffffff !important;
        }
        
        html.dark p, html.dark .text-muted {
            color: #ced4da !important;
        }

        /* Theme Toggle Button */
        .theme-toggle-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            background: transparent;
            border: none;
            font-size: 1.5rem;
            color: var(--dark-steel);
            cursor: pointer;
            z-index: 10;
        }
        html.dark .theme-toggle-btn {
            color: #f8f9fa;
        }

        /* Buttons */
        .btn-gold { /* Overriding btn-gold from previous theme to use primary blue */
            background-color: var(--primary-blue);
            color: white;
            border: none;
            font-weight: 700;
            padding: 14px 20px;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .btn-gold:hover {
            background-color: #0b5ed7;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(13, 110, 253, 0.2);
        }

        .auth-link {
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: 0.2s;
        }
        
        .auth-link:hover {
            color: var(--logistics-orange);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsive */
        @media (max-width: 991px) {
            .auth-image { display: none; }
            .auth-form-wrapper { width: 100%; padding: 2rem; }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <!-- Left Side: Warehouse Image -->
        <div class="auth-image">
            <div class="auth-image-content">
                <div class="mb-3">
                    <span class="badge bg-primary px-3 py-2 text-uppercase tracking-wide" style="letter-spacing: 1px;">Sistem Informasi</span>
                </div>
                <h1 class="display-4 mb-3 brand-font">Data Stock<br><span style="color: var(--logistics-orange);">Gudang</span></h1>
                <p class="lead fw-normal opacity-75 border-start border-4 border-warning ps-3">Platform manajemen dan pencatatan sirkulasi gudang secara terpusat, memantau *inbound* dan *outbound* secara real-time.</p>
            </div>
        </div>
        
        <!-- Right Side: Form -->
        <div class="auth-form-wrapper shadow-lg position-relative">
            <button id="guest-theme-toggle" class="theme-toggle-btn">
                <i id="theme-icon-dark" class="fas fa-moon d-none"></i>
                <i id="theme-icon-light" class="fas fa-sun d-none"></i>
            </button>
            <div class="auth-form-inner">
                {{ $slot }}
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('guest-theme-toggle');
            const iconDark = document.getElementById('theme-icon-dark');
            const iconLight = document.getElementById('theme-icon-light');
            
            if (document.documentElement.classList.contains('dark')) {
                iconLight.classList.remove('d-none');
            } else {
                iconDark.classList.remove('d-none');
            }
            
            toggleBtn.addEventListener('click', function() {
                iconDark.classList.toggle('d-none');
                iconLight.classList.toggle('d-none');
                
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                }
            });
        });
    </script>
</body>
</html>
