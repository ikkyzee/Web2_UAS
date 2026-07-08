<x-guest-layout>
    <div class="mb-5">
        <h2 class="fw-bold brand-font" style="color: var(--dark-steel);">Login Portal</h2>
        <p class="text-muted small">Silakan masuk ke akun Anda untuk mengakses sistem Data Stock Gudang.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4 text-success fw-bold" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="form-label">Email Address</label>
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="admin@karunia.com">
            <x-input-error :messages="$errors->get('email')" class="text-danger small mt-1" />
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password" placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="text-danger small mt-1" />
        </div>

        <!-- Remember Me -->
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div class="form-check">
                <input id="remember_me" type="checkbox" class="form-check-input border-secondary" name="remember">
                <label for="remember_me" class="form-check-label small text-muted">Ingat Saya</label>
            </div>
            @if (Route::has('password.request'))
                <a class="auth-link small" href="{{ route('password.request') }}">
                    Lupa Password?
                </a>
            @endif
        </div>

        <div class="d-grid gap-2 mb-4">
            <button type="submit" class="btn btn-gold text-uppercase">
                Masuk <i class="fas fa-arrow-right ms-2"></i>
            </button>
        </div>

        @if (Route::has('register'))
            <div class="text-center mt-4">
                <span class="text-muted small">Belum punya akun?</span>
                <a href="{{ route('register') }}" class="auth-link ms-1 fw-bold">Daftar Sekarang</a>
            </div>
        @endif
    </form>
</x-guest-layout>
