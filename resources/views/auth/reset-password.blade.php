<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <label for="email" class="block font-medium text-sm text-gray-700">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" value="{{ old('email', $request->email) }}" required autofocus>
            @if($errors->has('email')) <p class="mt-2 text-sm text-red-600">{{ $errors->first('email') }}</p> @endif
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password" class="block font-medium text-sm text-gray-700">{{ __('Password') }}</label>
            <input id="password" name="password" type="password" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required autocomplete="new-password">
            @if($errors->has('password')) <p class="mt-2 text-sm text-red-600">{{ $errors->first('password') }}</p> @endif
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <label for="password_confirmation" class="block font-medium text-sm text-gray-700">{{ __('Confirm Password') }}</label>
            <input id="password_confirmation" name="password_confirmation" type="password" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required autocomplete="new-password">
            @if($errors->has('password_confirmation')) <p class="mt-2 text-sm text-red-600">{{ $errors->first('password_confirmation') }}</p> @endif
        </div>

        <div class="flex items-center justify-end mt-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                {{ __('Reset Password') }}
            </button>
        </div>
    </form>
</x-guest-layout>
