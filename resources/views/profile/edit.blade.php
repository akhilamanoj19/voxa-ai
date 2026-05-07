<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row g-4">
                {{-- Update Profile Information --}}
                <div class="col-12">
                    <div class="glass-card shadow-sm">
                        <header class="mb-4">
                            <h4 class="fw-bold">{{ __('Profile Information') }}</h4>
                            <p class="text-muted small">{{ __("Update your account's profile information and email address.") }}</p>
                        </header>
                        <form method="post" action="{{ route('profile.update') }}" class="row g-3">
                            @csrf
                            @method('patch')
                            <div class="col-md-6">
                                <label for="name" class="form-label">{{ __('Name') }}</label>
                                <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required autofocus>
                                @if($errors->has('name')) <div class="text-danger small mt-1">{{ $errors->first('name') }}</div> @endif
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">{{ __('Email') }}</label>
                                <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                                @if($errors->has('email')) <div class="text-danger small mt-1">{{ $errors->first('email') }}</div> @endif
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary">{{ __('Save Changes') }}</button>
                                @if (session('status') === 'profile-updated') <span class="ms-3 text-success small animate-fade-in">{{ __('Saved successfully.') }}</span> @endif
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Update Password --}}
                <div class="col-12">
                    <div class="glass-card shadow-sm">
                        <header class="mb-4">
                            <h4 class="fw-bold">{{ __('Update Password') }}</h4>
                            <p class="text-muted small">{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>
                        </header>
                        <form method="post" action="{{ route('password.update') }}" class="row g-3">
                            @csrf
                            @method('put')
                            <div class="col-md-4">
                                <label for="current_password" class="form-label">{{ __('Current Password') }}</label>
                                <input id="current_password" name="current_password" type="password" class="form-control">
                                @if($errors->updatePassword->has('current_password')) <div class="text-danger small mt-1">{{ $errors->updatePassword->first('current_password') }}</div> @endif
                            </div>
                            <div class="col-md-4">
                                <label for="password" class="form-label">{{ __('New Password') }}</label>
                                <input id="password" name="password" type="password" class="form-control">
                                @if($errors->updatePassword->has('password')) <div class="text-danger small mt-1">{{ $errors->updatePassword->first('password') }}</div> @endif
                            </div>
                            <div class="col-md-4">
                                <label for="password_confirmation" class="form-label">{{ __('Confirm New Password') }}</label>
                                <input id="password_confirmation" name="password_confirmation" type="password" class="form-control">
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary">{{ __('Update Password') }}</button>
                                @if (session('status') === 'password-updated') <span class="ms-3 text-success small animate-fade-in">{{ __('Password updated.') }}</span> @endif
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Delete Account --}}
                <div class="col-12">
                    <div class="glass-card border-danger border-opacity-10">
                        <header class="mb-4">
                            <h4 class="fw-bold text-danger">{{ __('Delete Account') }}</h4>
                            <p class="text-muted small">{{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}</p>
                        </header>
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                            {{ __('Permanently Delete Account') }}
                        </button>

                        <!-- Bootstrap Modal -->
                        <div class="modal fade" id="deleteAccountModal" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content glass-card p-0 border-0 overflow-hidden">
                                    <div class="modal-header border-0 px-4 pt-4">
                                        <h5 class="modal-title fw-bold text-danger">{{ __('Are you sure?') }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form method="post" action="{{ route('profile.destroy') }}" class="p-4 pt-2">
                                        @csrf
                                        @method('delete')
                                        <p class="text-muted small">{{ __('Please enter your password to confirm you would like to permanently delete your account.') }}</p>
                                        <div class="mb-4">
                                            <input id="password" name="password" type="password" class="form-control" placeholder="{{ __('Confirm Password') }}">
                                            @if($errors->userDeletion->has('password')) <div class="text-danger small mt-1">{{ $errors->userDeletion->first('password') }}</div> @endif
                                        </div>
                                        <div class="d-flex justify-content-end gap-2">
                                            <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                            <button type="submit" class="btn btn-danger rounded-pill px-4">{{ __('Delete Everything') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
