<x-guest-layout>
    <div class="min-vh-100 d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5 col-lg-4">
                    <div class="text-center mb-4">
                        <div class="d-inline-flex align-items-center gap-2 mb-3">
                            <div class="bg-primary text-white rounded-3 p-2">
                                <i class="bi bi-shield-lock-fill fs-3"></i>
                            </div>
                        </div>
                        <h3 class="fw-bold">Confirm Password</h3>
                        <p class="text-muted">Secure area — please confirm your password</p>
                    </div>

                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="alert alert-info d-flex align-items-center mb-4" role="alert">
                                <i class="bi bi-info-circle-fill me-2"></i>
                                <div>{{ __('This is a secure area of the application. Please confirm your password before continuing.') }}</div>
                            </div>

                            <form method="POST" action="{{ route('password.confirm') }}">
                                @csrf

                                <div class="mb-4">
                                    <label class="form-label fw-medium">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i class="bi bi-lock"></i></span>
                                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                               required autocomplete="current-password" placeholder="Enter your password">
                                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 py-2 fw-medium">
                                    <i class="bi bi-check-lg me-1"></i> {{ __('Confirm') }}
                                </button>
                            </form>

                            <div class="text-center mt-4">
                                <a href="{{ route('login') }}" class="text-decoration-none small">
                                    <i class="bi bi-arrow-left me-1"></i> Back to Login
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
