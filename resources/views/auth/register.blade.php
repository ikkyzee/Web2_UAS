<x-guest-layout>
    <div class="mb-5">
        <h2 class="fw-bold brand-font" style="color: var(--dark-steel);">Pendaftaran Staf</h2>
        <p class="text-muted small">Silakan lengkapi data diri Anda untuk bergabung ke dalam sistem Data Stock Gudang.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-4">
            <label for="name" class="form-label">Nama Lengkap</label>
            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="John Doe">
            <x-input-error :messages="$errors->get('name')" class="text-danger small mt-1" />
        </div>

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="form-label">Email Address</label>
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="john@example.com">
            <x-input-error :messages="$errors->get('email')" class="text-danger small mt-1" />
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password" placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="text-danger small mt-1" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-5">
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
            <x-input-error :messages="$errors->get('password_confirmation')" class="text-danger small mt-1" />
        </div>

        <div class="d-grid gap-2 mb-4">
            <button type="submit" class="btn btn-gold text-uppercase">
                Daftar Sekarang <i class="fas fa-user-plus ms-2"></i>
            </button>
        </div>

        <div class="text-center mt-4">
            <span class="text-muted small">Sudah memiliki akun?</span>
            <a href="{{ route('login') }}" class="auth-link ms-1 fw-bold">Masuk di sini</a>
        </div>
    </form>
</x-guest-layout>
