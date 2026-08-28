<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'EMPLOYEASE') }} - PESO Tagudin</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ===== LOGIN PAGE OVERRIDES ===== */
        body {
            margin: 0;
            padding: 0;
            background: #f0f2f5;
            overflow: hidden;
        }

        .login-page {
            display: flex;
            height: 100vh;
            width: 100vw;
            overflow: hidden;
        }

        /* ===== LEFT PANEL ===== */
        .login-brand {
            width: 480px;
            min-width: 480px;
            background: linear-gradient(145deg, #0F172A 0%, #1E293B 40%, #0B1220 100%);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 3rem;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .login-brand::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            z-index: -1;
        }

        .login-brand .brand-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #fff;
            text-decoration: none;
        }

        .login-brand .brand-logo .logo-img {
            width: 48px;
            height: 48px;
            padding: 4px;
            background: #fff;
            border-radius: 50%;
            object-fit: contain;
            box-shadow: 0 2px 10px rgba(0,0,0,.25);
        }

        .login-brand .brand-logo span {
            font-size: 1.2rem;
            font-weight: 700;
            letter-spacing: .5px;
        }

        .login-brand .brand-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-brand .brand-content h1 {
            font-size: 2.5rem;
            font-weight: 800;
            color: #fff;
            line-height: 1.15;
            margin-bottom: 1rem;
        }

        .login-brand .brand-content h1 span {
            color: #E3A008;
        }

        .login-brand .brand-content p {
            color: rgba(255,255,255,.7);
            font-size: 1rem;
            line-height: 1.6;
            max-width: 380px;
            margin-bottom: 2rem;
        }

        .login-brand .brand-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .login-brand .brand-badges .badge-item {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255,255,255,.1);
            backdrop-filter: blur(6px);
            border: 1px solid rgba(255,255,255,.12);
            padding: 6px 14px;
            border-radius: 20px;
            font-size: .8rem;
            color: rgba(255,255,255,.9);
        }

        .login-brand .brand-badges .badge-item i {
            color: #E3A008;
        }

        .login-brand .brand-footer {
            color: rgba(255,255,255,.5);
            font-size: .8rem;
        }

        .login-brand .deco-circle {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
        }
        .login-brand .deco-circle.c1 {
            width: 380px;
            height: 380px;
            top: -120px;
            right: -100px;
            background: rgba(255,255,255,.05);
        }
        .login-brand .deco-circle.c2 {
            width: 220px;
            height: 220px;
            bottom: 60px;
            left: -60px;
            background: rgba(255,255,255,.06);
        }
        .login-brand .deco-circle.c3 {
            width: 130px;
            height: 130px;
            bottom: 200px;
            right: 40px;
            background: rgba(255,255,255,.07);
        }

        /* ===== RIGHT PANEL ===== */
        .login-form-panel {
            flex: 1;
            display: flex;
            padding: 2rem;
            background: #f0f2f5;
            position: relative;
            overflow-y: auto;
        }

        .login-form-panel .form-container {
            width: 100%;
            max-width: 420px;
            margin: auto;
        }

        /* ===== GLASSMORPHISM CARD ===== */
        .glass-card {
            background: rgba(255,255,255,.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,.5);
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow:
                0 1px 3px rgba(0,0,0,.04),
                0 8px 32px rgba(0,0,0,.08),
                0 20px 60px rgba(0,0,0,.04);
        }

        .glass-card .card-header {
            text-align: center;
            margin-bottom: 2rem;
            padding-top: .5rem;
            overflow: visible;
        }

        .glass-card .card-header .icon-wrap {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #E3A008, #C99700);
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            color: #0A2540;
            margin-bottom: 1rem;
            overflow: visible;
            box-shadow: 0 4px 12px rgba(227,160,8,.25);
        }

        .glass-card .card-header h4 {
            font-weight: 700;
            font-size: 1.3rem;
            margin-bottom: .5rem;
        }

        .glass-card .card-header p {
            color: #64748b;
            font-size: .9rem;
            margin: 0;
        }

        /* ===== FORM INPUTS ===== */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group label {
            display: block;
            font-size: .8rem;
            font-weight: 600;
            color: #475569;
            margin-bottom: .4rem;
            letter-spacing: .3px;
        }

        .input-affix {
            display: flex;
            align-items: stretch;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            background: #fff;
            transition: all .2s ease;
        }

        .input-affix:focus-within {
            border-color: #C99700;
            box-shadow: 0 0 0 3px rgba(227,160,8,.15);
        }

        .input-affix.has-error {
            border-color: #dc3545;
        }

        .input-affix.has-error:focus-within {
            box-shadow: 0 0 0 3px rgba(220,53,69,.12);
        }

        .input-affix .affix-icon {
            display: flex;
            align-items: center;
            padding: 0 14px;
            color: #94a3b8;
            font-size: 1rem;
            background: transparent;
            border: none;
            transition: color .2s;
        }

        .input-affix:focus-within .affix-icon {
            color: #C99700;
        }

        .input-affix input {
            flex: 1;
            border: none;
            outline: none;
            background: transparent;
            padding: .75rem 0;
            font-size: .95rem;
            font-family: inherit;
            color: #1e293b;
            min-width: 0;
        }

        .input-affix input::placeholder {
            color: #94a3b8;
        }

        .input-affix .toggle-btn {
            display: flex;
            align-items: center;
            padding: 0 14px;
            color: #94a3b8;
            background: transparent;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            transition: color .2s;
        }

        .input-affix .toggle-btn:hover {
            color: #475569;
        }

        .error-text {
            font-size: .8rem;
            color: #dc3545;
            margin-top: .35rem;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* ===== REMEMBER + FORGOT ===== */
        .form-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 1.25rem 0 1.5rem;
        }

        .form-actions .remember-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .form-actions .remember-wrap input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #E3A008;
            cursor: pointer;
        }

        .form-actions .remember-wrap label {
            font-size: .85rem;
            color: #64748b;
            cursor: pointer;
            margin: 0;
        }

        .form-actions .forgot-link {
            font-size: .85rem;
            color: #64748b;
            text-decoration: none;
            transition: color .2s;
        }

        .form-actions .forgot-link:hover {
            color: #C99700;
        }

        /* ===== BUTTON ===== */
        .btn-login {
            width: 100%;
            padding: .85rem 1.5rem;
            background: linear-gradient(135deg, #E3A008, #C99700);
            color: #0A2540;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: all .3s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(227,160,8,.35);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login:disabled {
            opacity: .7;
            cursor: not-allowed;
            transform: none;
        }

        .btn-login .spinner {
            display: none;
            width: 18px;
            height: 18px;
            border: 2px solid rgba(10,37,64,.25);
            border-top-color: #0A2540;
            border-radius: 50%;
            animation: spin .6s linear infinite;
        }

        .btn-login.loading .spinner {
            display: inline-block;
        }

        .btn-login.loading .btn-text {
            display: none;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* ===== DIVIDER ===== */
        .divider {
            position: relative;
            text-align: center;
            margin: 1.5rem 0;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e2e8f0;
        }

        .divider span {
            position: relative;
            background: rgba(255,255,255,.85);
            padding: 0 12px;
            color: #94a3b8;
            font-size: .85rem;
        }

        /* ===== REGISTER LINK ===== */
        .register-wrap {
            text-align: center;
        }

        .register-wrap p {
            font-size: .9rem;
            color: #64748b;
            margin: 0;
        }

        .register-wrap a {
            color: #A16207;
            font-weight: 600;
            text-decoration: none;
        }

        .register-wrap a:hover {
            text-decoration: underline;
        }

        /* ===== BACK LINK ===== */
        .back-home-link {
            position: fixed;
            bottom: 24px;
            right: 24px;
            width: 44px;
            height: 44px;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            font-size: 1.1rem;
            text-decoration: none;
            box-shadow: 0 2px 8px rgba(0,0,0,.08);
            transition: all .2s ease;
            z-index: 100;
        }

        .back-home-link:hover {
            background: #0F172A;
            border-color: #0F172A;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(227,160,8,.3);
        }

        /* ===== ALERT ===== */
        .alert-custom {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 14px;
            border-radius: 10px;
            font-size: .85rem;
            margin-bottom: 1.25rem;
        }

        .alert-custom.success {
            background: #ecfdf5;
            color: #059669;
            border: 1px solid #a7f3d0;
        }

        .alert-custom.error {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 991px) {
            .login-brand {
                display: none;
            }

            .login-form-panel {
                padding: 1.5rem;
            }

            .glass-card {
                padding: 1.75rem;
                border-radius: 16px;
            }
        }

        @media (max-width: 480px) {
            .login-form-panel {
                padding: 1rem;
            }

            .glass-card {
                padding: 1.5rem;
            }

            .form-actions {
                flex-direction: column;
                gap: 10px;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <div class="login-page">
        <!-- Left: Brand Panel -->
        <div class="login-brand">
            <a href="{{ url('/') }}" class="brand-logo">
                <img src="{{ asset('images/employease-mark.webp') }}" alt="EmployEase logo" class="logo-img" width="48" height="48">
                <span>EMPLOYEASE</span>
            </a>

            <div class="brand-content">
                <h1>
                    Your Gateway to<br>
                    <span>Employment Opportunities</span>
                </h1>
                <p>
                    EMPLOYEASE connects job seekers with local employment opportunities in Tagudin, Ilocos Sur through the Municipal PESO employment system.
                </p>
                <div class="brand-badges">
                    <span class="badge-item"><i class="bi bi-building"></i> Local Jobs</span>
                    <span class="badge-item"><i class="bi bi-people"></i> Job Seekers</span>
                    <span class="badge-item"><i class="bi bi-shield-check"></i> Free Service</span>
                </div>
            </div>

            <div class="brand-footer">
                <i class="bi bi-geo-alt me-1"></i> Municipal PESO — Tagudin, Ilocos Sur
            </div>

            <div class="deco-circle c1"></div>
            <div class="deco-circle c2"></div>
            <div class="deco-circle c3"></div>
        </div>

        <!-- Right: Form Panel -->
        <div class="login-form-panel">
            <div class="form-container">
                <!-- Mobile Header -->
                <div class="d-lg-none text-center mb-4">
                    <div style="width:52px;height:52px;background:#fff;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;margin-bottom:1rem;box-shadow:0 4px 12px rgba(227,160,8,.25);">
                        <img src="{{ asset('images/employease-mark.webp') }}" alt="EmployEase logo" width="38" height="38" style="object-fit:contain;">
                    </div>
                    <h4 class="fw-bold mb-2">Welcome Back</h4>
                    <p class="text-muted small mb-0">Sign in to your account</p>
                </div>

                <!-- Glassmorphism Card -->
                <div class="glass-card">
                    <div class="card-header d-none d-lg-block">
                        <div class="icon-wrap"><i class="bi bi-box-arrow-in-right"></i></div>
                        <h4>Welcome Back</h4>
                        <p>Sign in to your EMPLOYEASE account</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}" id="loginForm">
                        @csrf

                        @if (session('status'))
                            <div class="alert-custom success">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>{{ session('status') }}</span>
                            </div>
                        @endif

                        @if ($errors->has('email') && !old('email'))
                            <div class="alert-custom error">
                                <i class="bi bi-exclamation-circle-fill"></i>
                                <span>{{ $errors->first('email') }}</span>
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="email">EMAIL ADDRESS</label>
                            <div class="input-affix @error('email') has-error @enderror">
                                <span class="affix-icon"><i class="bi bi-envelope"></i></span>
                                <input id="email" type="email" name="email"
                                       value="{{ old('email') }}" required autofocus
                                       placeholder="you@example.com">
                            </div>
                            @error('email')
                                <div class="error-text"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">PASSWORD</label>
                            <div class="input-affix @error('password') has-error @enderror">
                                <span class="affix-icon"><i class="bi bi-lock"></i></span>
                                <input id="password" type="password" name="password"
                                       required placeholder="Enter your password">
                                <button type="button" class="toggle-btn" onclick="togglePass()" tabindex="-1">
                                    <i class="bi bi-eye" id="passIcon"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="error-text"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-actions">
                            <label class="remember-wrap">
                                <input type="checkbox" name="remember" id="remember">
                                Remember me
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="forgot-link">Forgot Password?</a>
                            @endif
                        </div>

                        <button type="submit" class="btn-login" id="submitBtn">
                            <span class="spinner"></span>
                            <span class="btn-text"><i class="bi bi-box-arrow-in-right me-1"></i> Sign In</span>
                        </button>
                    </form>

                    <div class="divider"><span>New here?</span></div>

                    <div class="register-wrap">
                        <p>Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
                    </div>
                </div>

            </div>
        </div>

        <!-- Fixed Back to Home -->
        <a href="{{ route('home') }}" class="back-home-link">
            <i class="bi bi-arrow-left"></i>
        </a>
    </div>

    <script>
        // Password toggle
        function togglePass() {
            const pw = document.getElementById('password');
            const icon = document.getElementById('passIcon');
            if (pw.type === 'password') {
                pw.type = 'text';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                pw.type = 'password';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        }

        // Loading state on submit
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const btn = document.getElementById('submitBtn');
            btn.classList.add('loading');
            btn.disabled = true;
        });

        // Entrance animation
        document.addEventListener('DOMContentLoaded', function() {
            const items = document.querySelectorAll('.glass-card > *');
            items.forEach((el, i) => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(16px)';
                el.style.transition = 'all .45s cubic-bezier(.4,0,.2,1)';
                setTimeout(() => {
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, 80 + (i * 70));
            });
        });
    </script>
</body>
</html>
