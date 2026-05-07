<x-guest-layout>
    @if (session('status'))
        <div class="font-medium text-sm text-green-600 mb-4">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Email Address</label>
            <input id="email" type="email" name="email" class="form-control rounded-3" value="{{ old('email') }}" required autofocus autocomplete="username">
            @if($errors->has('email')) <p class="mt-2 text-danger small">{{ $errors->first('email') }}</p> @endif
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label fw-semibold">Password</label>
            <input id="password" type="password" name="password" class="form-control rounded-3" required autocomplete="current-password">
            @if($errors->has('password')) <p class="mt-2 text-danger small">{{ $errors->first('password') }}</p> @endif
        </div>

        <!-- Remember Me -->
        <div class="form-check mb-4">
            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
            <label for="remember_me" class="form-check-label small text-muted">Remember me</label>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">
                Log in
            </button>
        </div>

        <div class="text-center mt-4">
            @if (Route::has('password.request'))
                <a class="text-decoration-none small text-muted me-3" href="{{ route('password.request') }}">
                    Forgot password?
                </a>
            @endif
            <a class="text-decoration-none small fw-bold text-primary" href="{{ route('register') }}">
                Create account
            </a>
        </div>
    </form>
</x-guest-layout>
