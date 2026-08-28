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
                        <h3 class="fw-bold">Forgot Password?</h3>
                        <p class="text-muted">Enter your email and we'll send you a reset link</p>
                    </div>

                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            @if (session('status'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="bi bi-check-circle me-1"></i> {{ session('status') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf

                                <div class="mb-4">
                                    <label class="form-label fw-medium">Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i class="bi bi-envelope"></i></span>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                               value="{{ old('email') }}" required placeholder="you@example.com">
                                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 py-2 fw-medium">
                                    <i class="bi bi-send me-1"></i> Send Reset Link
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
