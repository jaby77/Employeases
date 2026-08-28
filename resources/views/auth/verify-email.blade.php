<x-guest-layout>
    <style>
        /* ===== VERIFY EMAIL PAGE ===== */
        .verify-page {
            min-height: calc(100vh - 66px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3.5rem 1rem 4rem;
            background:
                radial-gradient(640px circle at 12% -10%, rgba(10, 37, 64, .05), transparent 55%),
                radial-gradient(560px circle at 92% 8%, rgba(227, 160, 8, .08), transparent 55%),
                #f5f7fa;
        }

        .verify-container {
            width: 100%;
            max-width: 460px;
        }

        .verify-card {
            background: #fff;
            border: 1px solid rgba(10, 37, 64, .06);
            border-radius: 20px;
            padding: 2.75rem 2.5rem 2.5rem;
            text-align: center;
            box-shadow:
                0 1px 2px rgba(10, 37, 64, .04),
                0 12px 32px rgba(10, 37, 64, .08),
                0 32px 80px rgba(10, 37, 64, .06);
        }

        /* Blue (brand navy) rounded-square icon with envelope + checkmark */
        .verify-icon-wrap {
            width: 76px;
            height: 76px;
            margin: 0 auto 1.5rem;
            border-radius: 22px;
            background: linear-gradient(135deg, #0A2540, #1E3A5F);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            box-shadow: 0 10px 26px rgba(10, 37, 64, .3);
        }

        .verify-title {
            font-size: 1.45rem;
            font-weight: 700;
            color: var(--brand-navy);
            letter-spacing: -.3px;
            margin: 0 0 .5rem;
        }

        .verify-subtitle {
            color: #64748b;
            font-size: .95rem;
            margin: 0 0 1.75rem;
        }

        /* Amber/gold shield with checkmark */
        .verify-shield {
            width: 56px;
            height: 56px;
            margin: 0 auto 1.5rem;
            border-radius: 50%;
            background: var(--brand-gold-soft);
            border: 1px solid rgba(201, 151, 0, .3);
            color: var(--brand-gold-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.65rem;
        }

        .verify-text {
            color: #475569;
            font-size: .95rem;
            line-height: 1.75;
            margin: 0 0 1.5rem;
        }

        .verify-text strong {
            color: var(--brand-navy);
            font-weight: 600;
            word-break: break-all;
        }

        .verify-alert {
            display: flex;
            align-items: flex-start;
            gap: .55rem;
            text-align: left;
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #047857;
            border-radius: 12px;
            padding: .8rem 1rem;
            font-size: .875rem;
            line-height: 1.5;
            margin-bottom: 1.5rem;
        }

        .verify-alert i {
            margin-top: 2px;
            flex-shrink: 0;
        }

        /* Prominent solid resend button */
        .verify-btn {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            padding: .9rem 1.5rem;
            background: linear-gradient(135deg, #E3A008, #C99700);
            color: var(--brand-navy);
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: all .25s ease;
            box-shadow: 0 4px 14px rgba(227, 160, 8, .28);
        }

        .verify-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(227, 160, 8, .38);
        }

        .verify-btn:active {
            transform: translateY(0);
        }

        .verify-btn:disabled {
            opacity: .75;
            cursor: not-allowed;
            transform: none;
        }

        .verify-btn-spinner {
            display: none;
            width: 18px;
            height: 18px;
            border: 2px solid rgba(10, 37, 64, .3);
            border-top-color: var(--brand-navy);
            border-radius: 50%;
            animation: verify-spin .6s linear infinite;
        }

        .verify-btn.loading .verify-btn-spinner { display: inline-block; }
        .verify-btn.loading .verify-btn-text { display: none; }

        @keyframes verify-spin {
            to { transform: rotate(360deg); }
        }

        /* Secondary text link */
        .verify-link-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            color: #64748b;
            font-size: .875rem;
            font-family: inherit;
            display: inline-flex;
            align-items: center;
            margin-top: 1.5rem;
            transition: color .2s ease;
        }

        .verify-link-btn:hover {
            color: var(--brand-gold-dark);
        }

        .verify-footnote {
            text-align: center;
            color: #94a3b8;
            font-size: .8rem;
            margin: 1.25rem 0 0;
        }

        @media (max-width: 480px) {
            .verify-page {
                padding: 2.25rem 1rem 3rem;
            }

            .verify-card {
                padding: 2rem 1.5rem;
            }
        }
    </style>

    <div class="verify-page">
        <div class="verify-container">
            <div class="verify-card">
                <div class="verify-icon-wrap">
                    <i class="bi bi-envelope-check-fill" aria-hidden="true"></i>
                </div>

                <h1 class="verify-title">{{ __('Verify Your Email') }}</h1>
                <p class="verify-subtitle">{{ __('One last step to activate your account') }}</p>

                <div class="verify-shield">
                    <i class="bi bi-shield-check" aria-hidden="true"></i>
                </div>

                <p class="verify-text">
                    {{ __('Thanks for signing up! We sent a verification link to') }}
                    <strong>{{ auth()->user()->email }}</strong>.
                    {{ __('Click the link to activate your account. If you didn\'t receive the email, we will gladly send you another.') }}
                </p>

                @if (session('status') == 'verification-link-sent')
                    <div class="verify-alert" role="alert">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>{{ __('A new verification link has been sent to the email address you provided during registration.') }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('verification.send') }}" id="resendForm">
                    @csrf
                    <button type="submit" class="verify-btn" id="resendBtn">
                        <span class="verify-btn-spinner"></span>
                        <span class="verify-btn-text"><i class="bi bi-send me-1"></i> {{ __('Resend Verification Email') }}</span>
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="verify-link-btn">
                        <i class="bi bi-box-arrow-right me-1"></i> {{ __('Log out') }}
                    </button>
                </form>
            </div>

            <p class="verify-footnote">
                <i class="bi bi-info-circle me-1"></i>
                {{ __('Check your spam folder if you didn\'t receive the email.') }}
            </p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Staggered entrance animation
            const items = document.querySelectorAll('.verify-card > *');
            items.forEach((el, i) => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(14px)';
                el.style.transition = 'all .45s cubic-bezier(.4, 0, .2, 1)';
                setTimeout(() => {
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, 60 + (i * 60));
            });

            // Resend button loading state
            const form = document.getElementById('resendForm');
            const btn = document.getElementById('resendBtn');
            if (form && btn) {
                form.addEventListener('submit', function () {
                    btn.classList.add('loading');
                    btn.disabled = true;
                });
            }
        });
    </script>
</x-guest-layout>
