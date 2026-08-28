<x-guest-layout>
    <div class="min-vh-100 d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5 col-lg-4">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold">Reset Password</h3>
                        <p class="text-muted">Enter your new password</p>
                    </div>

                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <form method="POST" action="{{ route('password.store') }}">
                                @csrf
                                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                                <div class="mb-3">
                                    <label class="form-label fw-medium">Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i class="bi bi-envelope"></i></span>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                               value="{{ old('email', $request->email) }}" required readonly>
                                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-medium">New Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i class="bi bi-lock"></i></span>
                                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                               required placeholder="Minimum 8 characters">
                                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-medium">Confirm Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i class="bi bi-lock-fill"></i></span>
                                        <input type="password" name="password_confirmation" class="form-control" required>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 py-2 fw-medium">
                                    <i class="bi bi-check-lg me-1"></i> Reset Password
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
