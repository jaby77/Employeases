<x-guest-layout>
    <style>
        /* ===== PASSWORD STRENGTH METER ===== */
        .pw-strength { margin-top: .5rem; }

        .pw-strength-bar {
            height: 6px;
            background: #e2e8f0;
            border-radius: 3px;
            overflow: hidden;
        }

        .pw-strength-fill {
            display: block;
            height: 100%;
            width: 0;
            border-radius: 3px;
            transition: width .3s ease, background-color .3s ease;
        }

        .pw-strength-fill.level-1 { background: #dc3545; }
        .pw-strength-fill.level-2 { background: #f97316; }
        .pw-strength-fill.level-3 { background: #f59e0b; }
        .pw-strength-fill.level-4 { background: #16a34a; }

        .pw-strength-label {
            font-size: .75rem;
            font-weight: 600;
            margin-top: .3rem;
            display: flex;
            align-items: center;
            gap: 4px;
            transition: color .3s ease;
        }

        .pw-strength-label.level-1 { color: #dc3545; }
        .pw-strength-label.level-2 { color: #f97316; }
        .pw-strength-label.level-3 { color: #b45309; }
        .pw-strength-label.level-4 { color: #16a34a; }

        /* ===== CONFIRM PASSWORD MATCH ===== */
        #confirmAffix .form-control { transition: border-color .2s ease, box-shadow .2s ease; }

        #confirmAffix.has-success .form-control {
            border-color: #16a34a;
            box-shadow: 0 0 0 .2rem rgba(22, 163, 74, .12);
        }

        #confirmAffix.has-error .form-control {
            border-color: #dc3545;
            box-shadow: 0 0 0 .2rem rgba(220, 53, 69, .12);
        }

        .match-status {
            font-size: .78rem;
            margin-top: .3rem;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .match-status.match-ok { color: #16a34a; }
        .match-status.match-bad { color: #dc3545; }
    </style>

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
                                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"
                                               required placeholder="Min 8 chars, 1 uppercase, 1 number, 1 symbol">
                                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="pw-strength" id="pwStrength" hidden>
                                        <div class="pw-strength-bar">
                                            <span class="pw-strength-fill" id="pwStrengthFill"></span>
                                        </div>
                                        <div class="pw-strength-label" id="pwStrengthLabel"></div>
                                    </div>
                                    <div class="form-text text-muted">Min. 8 characters with uppercase, number, and symbol</div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-medium">Confirm Password</label>
                                    <div class="input-group" id="confirmAffix">
                                        <span class="input-group-text bg-white"><i class="bi bi-lock-fill"></i></span>
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                                    </div>
                                    <div class="match-status" id="matchStatus" hidden></div>
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

    <script src="{{ asset('js/password-security.js') }}" defer></script>
</x-guest-layout>
