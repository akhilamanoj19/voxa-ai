<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-3">
            <label for="name" class="form-label fw-semibold">Full Name</label>
            <input id="name" type="text" name="name" class="form-control rounded-3" value="{{ old('name') }}" required autofocus autocomplete="name">
            @if($errors->has('name')) <p class="mt-2 text-danger small">{{ $errors->first('name') }}</p> @endif
        </div>

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Email Address</label>
            <input id="email" type="email" name="email" class="form-control rounded-3" value="{{ old('email') }}" required autocomplete="username">
            @if($errors->has('email')) <p class="mt-2 text-danger small">{{ $errors->first('email') }}</p> @endif
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label fw-semibold">Password</label>
            <input id="password" type="password" name="password" class="form-control rounded-3" required autocomplete="new-password">
            @if($errors->has('password')) <p class="mt-2 text-danger small">{{ $errors->first('password') }}</p> @endif
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <label for="password_confirmation" class="form-label fw-semibold">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control rounded-3" required autocomplete="new-password">
            @if($errors->has('password_confirmation')) <p class="mt-2 text-danger small">{{ $errors->first('password_confirmation') }}</p> @endif
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">
                Register
            </button>
        </div>

        <div class="text-center mt-4">
            <span class="text-muted small">Already have an account?</span>
            <a class="text-decoration-none small fw-bold text-primary ms-1" href="{{ route('login') }}">
                Log in
            </a>
        </div>
    </form>
</x-guest-layout>
