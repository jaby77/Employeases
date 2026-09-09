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
        body { margin: 0; padding: 0; background: #f0f2f5; overflow: hidden; }

        .register-page {
            display: flex;
            height: 100vh;
            width: 100vw;
            overflow: hidden;
        }

        /* ===== LEFT PANEL ===== */
         .register-brand {
            width: 480px;
            min-width: 480px;
            background: linear-gradient(145deg, rgba(15,23,42,.95) 0%, rgba(30,41,59,.92) 40%, rgba(11,18,32,.95) 100%);
            background: linear-gradient(145deg, #0F172A 0%, #1E293B 40%, #0B1220 100%);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 3rem;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .register-brand::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            z-index: -1;
        }

        .register-brand .brand-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #fff;
            text-decoration: none;
        }

        .register-brand .brand-logo .logo-img {
            width: 48px;
            height: 48px;
            padding: 4px;
            background: #fff;
            border-radius: 50%;
            object-fit: contain;
            box-shadow: 0 2px 10px rgba(0,0,0,.25);
        }

        .register-brand .brand-logo span {
            font-size: 1.2rem;
            font-weight: 700;
            letter-spacing: .5px;
        }

        .register-brand .brand-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .register-brand .brand-content h1 {
            font-size: 2.5rem;
            font-weight: 800;
            color: #fff;
            line-height: 1.15;
            margin-bottom: 1rem;
        }

        .register-brand .brand-content h1 span {
            color: #E3A008;
        }

        .register-brand .brand-content p {
            color: rgba(255,255,255,.7);
            font-size: 1rem;
            line-height: 1.6;
            max-width: 380px;
            margin-bottom: 2rem;
        }

        .register-brand .brand-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .register-brand .brand-badges .badge-item {
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

        .register-brand .brand-badges .badge-item i {
            color: #E3A008;
        }

        .register-brand .brand-footer {
            color: rgba(255,255,255,.5);
            font-size: .8rem;
        }

        .register-brand .deco-circle {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
        }
        .register-brand .deco-circle.c1 {
            width: 380px; height: 380px; top: -120px; right: -100px;
            background: rgba(255,255,255,.05);
        }
        .register-brand .deco-circle.c2 {
            width: 220px; height: 220px; bottom: 60px; left: -60px;
            background: rgba(255,255,255,.06);
        }
        .register-brand .deco-circle.c3 {
            width: 130px; height: 130px; bottom: 200px; right: 40px;
            background: rgba(255,255,255,.07);
        }

        /* ===== RIGHT PANEL ===== */
        .register-form-panel {
            flex: 1;
            display: flex;
            padding: 2rem;
            background: #f0f2f5;
            position: relative;
            overflow-y: auto;
        }

        .register-form-panel .form-container {
            width: 100%;
            max-width: 460px;
            margin: auto;
        }

        /* ===== GLASSMORPHISM CARD ===== */
        .glass-card {
            background: rgba(255,255,255,.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,.5);
            border-radius: 20px;
            padding: 2.25rem;
            box-shadow: 0 1px 3px rgba(0,0,0,.04), 0 8px 32px rgba(0,0,0,.08), 0 20px 60px rgba(0,0,0,.04);
        }

        .glass-card .card-header {
            text-align: center;
            margin-bottom: 1.5rem;
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
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            font-size: .75rem;
            font-weight: 600;
            color: #475569;
            margin-bottom: .35rem;
            letter-spacing: .3px;
        }

        .input-affix {
            display: flex;
            align-items: stretch;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
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
            padding: 0 12px;
            color: #94a3b8;
            font-size: .95rem;
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
            padding: .65rem 0;
            font-size: .9rem;
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
            padding: 0 12px;
            color: #94a3b8;
            background: transparent;
            border: none;
            cursor: pointer;
            font-size: .95rem;
            transition: color .2s;
        }

        .input-affix .toggle-btn:hover {
            color: #475569;
        }

        .error-text {
            font-size: .78rem;
            color: #dc3545;
            margin-top: .3rem;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .hint-text {
            font-size: .75rem;
            color: #94a3b8;
            margin-top: .25rem;
        }

        /* ===== PASSWORD STRENGTH METER ===== */
        .pw-strength {
            margin-top: .5rem;
        }

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
        .input-affix.has-success {
            border-color: #16a34a;
        }

        .input-affix.has-success:focus-within {
            box-shadow: 0 0 0 3px rgba(22,163,74,.12);
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

        /* ===== BUTTON ===== */
        .btn-register {
            width: 100%;
            padding: .8rem 1.5rem;
            background: linear-gradient(135deg, #E3A008, #C99700);
            color: #0A2540;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: all .3s ease;
            margin-top: .5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(227,160,8,.35);
        }

        .btn-register:active {
            transform: translateY(0);
        }

        .btn-register .spinner {
            display: none;
            width: 18px;
            height: 18px;
            border: 2px solid rgba(10,37,64,.25);
            border-top-color: #0A2540;
            border-radius: 50%;
            animation: spin .6s linear infinite;
        }

        .btn-register.loading .spinner { display: inline-block; }
        .btn-register.loading .btn-text { display: none; }

        @keyframes spin { to { transform: rotate(360deg); } }

        /* ===== SIGN IN LINK ===== */
        .signin-wrap {
            text-align: center;
            margin-top: 1.25rem;
        }

        .signin-wrap p {
            font-size: .9rem;
            color: #64748b;
            margin: 0;
        }

        .signin-wrap a {
            color: #A16207;
            font-weight: 600;
            text-decoration: none;
        }

        .signin-wrap a:hover {
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

        /* ===== RESPONSIVE ===== */
        @media (max-width: 991px) {
            .register-brand { display: none; }
            .register-form-panel { padding: 1.5rem; }
            .glass-card { padding: 1.5rem; border-radius: 16px; }
        }

        @media (max-width: 480px) {
            .register-form-panel { padding: 1rem; }
            .glass-card { padding: 1.25rem; }
        }
    </style>
</head>
<body>
    <div class="register-page">
        <!-- Left: Brand Panel -->
        <div class="register-brand">
            <a href="{{ url('/') }}" class="brand-logo">
                <span>EMPLOYEASE</span>
            </a>

            <div class="brand-content">
                <h1>
                    Start Your<br>
                    <span>Career Journey</span>
                </h1>
                <p>
                    Create your free account and connect with local employers in Tagudin, Ilocos Sur. Your next opportunity awaits.
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
        <div class="register-form-panel">
            <div class="form-container">
                <!-- Mobile Header -->
                <div class="d-lg-none text-center mb-4">
                    <div style="width:52px;height:52px;background:linear-gradient(135deg, #E3A008, #C99700);border-radius:16px;display:inline-flex;align-items:center;justify-content:center;margin-bottom:1rem;box-shadow:0 4px 12px rgba(227,160,8,.25);">
                        <i class="bi bi-person-plus" style="font-size:1.4rem;color:#0A2540;"></i>
                    </div>
                    <h4 class="fw-bold mb-2">Create Account</h4>
                    <p class="text-muted small mb-0">Register as a Job Seeker</p>
                </div>

                <!-- Glassmorphism Card -->
                <div class="glass-card">
                    <div class="card-header d-none d-lg-block">
                        <div class="icon-wrap"><i class="bi bi-person-plus"></i></div>
                        <h4>Create Account</h4>
                        <p>Register as a Job Seeker in EMPLOYEASE</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}" id="registerForm">
                        @csrf

                        <div class="form-group">
                            <label for="name">FULL NAME</label>
                            <div class="input-affix @error('name') has-error @enderror">
                                <span class="affix-icon"><i class="bi bi-person"></i></span>
                                <input id="name" type="text" name="name"
                                       value="{{ old('name') }}" required autofocus
                                       placeholder="John Doe">
                            </div>
                            @error('name')
                                <div class="error-text"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">EMAIL ADDRESS</label>
                            <div class="input-affix @error('email') has-error @enderror">
                                <span class="affix-icon"><i class="bi bi-envelope"></i></span>
                                <input id="email" type="email" name="email"
                                       value="{{ old('email') }}" required
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
                                       required placeholder="Minimum 8 characters">
                                <button type="button" class="toggle-btn" onclick="togglePass()" tabindex="-1">
                                    <i class="bi bi-eye" id="passIcon"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="error-text"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                            <div class="pw-strength" id="pwStrength" hidden>
                                <div class="pw-strength-bar">
                                    <span class="pw-strength-fill" id="pwStrengthFill"></span>
                                </div>
                                <div class="pw-strength-label" id="pwStrengthLabel"></div>
                            </div>
                            <div class="hint-text">Must be at least 8 characters</div>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">CONFIRM PASSWORD</label>
                            <div class="input-affix" id="confirmAffix">
                                <span class="affix-icon"><i class="bi bi-lock-fill"></i></span>
                                <input id="password_confirmation" type="password" name="password_confirmation"
                                       required placeholder="Confirm your password">
                                <button type="button" class="toggle-btn" onclick="toggleConfirmPass()" tabindex="-1">
                                    <i class="bi bi-eye" id="confirmPassIcon"></i>
                                </button>
                            </div>
                            <div class="match-status" id="matchStatus" hidden></div>
                        </div>

                        <button type="submit" class="btn-register" id="submitBtn">
                            <span class="spinner"></span>
                            <span class="btn-text"><i class="bi bi-person-plus me-1"></i> Create Account</span>
                        </button>
                    </form>

                    <div class="signin-wrap">
                        <p>Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
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
        // ===== Password visibility toggles =====
        function toggleFieldVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        }

        function togglePass() {
            toggleFieldVisibility('password', 'passIcon');
        }

        function toggleConfirmPass() {
            toggleFieldVisibility('password_confirmation', 'confirmPassIcon');
        }

        // ===== Live password strength =====
        const pwInput = document.getElementById('password');
        const confirmInput = document.getElementById('password_confirmation');
        const strengthBox = document.getElementById('pwStrength');
        const strengthFill = document.getElementById('pwStrengthFill');
        const strengthLabel = document.getElementById('pwStrengthLabel');
        const matchStatus = document.getElementById('matchStatus');
        const confirmAffix = document.getElementById('confirmAffix');

        const STRENGTH_LEVELS = [
            { min: 0, width: 25, cls: 'level-1', label: 'Very weak', icon: 'bi-emoji-frown' },
            { min: 2, width: 50, cls: 'level-2', label: 'Weak', icon: 'bi-emoji-neutral' },
            { min: 4, width: 75, cls: 'level-3', label: 'Medium', icon: 'bi-emoji-smile' },
            { min: 5, width: 100, cls: 'level-4', label: 'Strong', icon: 'bi-shield-check' }
        ];

        function passwordScore(val) {
            let score = 0;
            if (val.length >= 8) score++;
            if (val.length >= 12) score++;
            if (/[a-z]/.test(val)) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;
            return score;
        }

        function updateStrength() {
            const val = pwInput.value;
            if (!val) {
                strengthBox.hidden = true;
                strengthFill.style.width = '0';
                strengthLabel.className = 'pw-strength-label';
                strengthLabel.innerHTML = '';
                return;
            }
            const score = passwordScore(val);
            let level = STRENGTH_LEVELS[0];
            for (const l of STRENGTH_LEVELS) {
                if (score >= l.min) level = l;
            }
            strengthBox.hidden = false;
            strengthFill.style.width = level.width + '%';
            strengthFill.className = 'pw-strength-fill ' + level.cls;
            strengthLabel.className = 'pw-strength-label ' + level.cls;
            strengthLabel.innerHTML = '<i class="bi ' + level.icon + '"></i> ' + level.label;
        }

        // ===== Live confirm-password match =====
        function updateMatch() {
            const pwVal = pwInput.value;
            const confirmVal = confirmInput.value;

            if (!confirmVal) {
                matchStatus.hidden = true;
                confirmAffix.classList.remove('has-error', 'has-success');
                return;
            }

            matchStatus.hidden = false;
            if (pwVal && confirmVal === pwVal) {
                matchStatus.className = 'match-status match-ok';
                matchStatus.innerHTML = '<i class="bi bi-check-circle"></i> Passwords match';
                confirmAffix.classList.remove('has-error');
                confirmAffix.classList.add('has-success');
            } else {
                matchStatus.className = 'match-status match-bad';
                matchStatus.innerHTML = '<i class="bi bi-x-circle"></i> Passwords do not match';
                confirmAffix.classList.remove('has-success');
                confirmAffix.classList.add('has-error');
            }
        }

        pwInput.addEventListener('input', function() {
            updateStrength();
            updateMatch();
        });
        confirmInput.addEventListener('input', updateMatch);

        // ===== Submit guard + loading state =====
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            if (confirmInput.value !== pwInput.value) {
                e.preventDefault();
                updateMatch();
                confirmInput.focus();
                return;
            }
            const btn = document.getElementById('submitBtn');
            btn.classList.add('loading');
            btn.disabled = true;
        });

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
