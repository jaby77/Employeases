<section>
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
        #confirmAffix input {
            transition: border-color .2s ease, box-shadow .2s ease;
        }

        #confirmAffix.has-success input {
            border-color: #16a34a;
            box-shadow: 0 0 0 2px rgba(22, 163, 74, .15);
        }

        #confirmAffix.has-error input {
            border-color: #dc3545;
            box-shadow: 0 0 0 2px rgba(220, 53, 69, .15);
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

    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <div class="pw-strength" id="pwStrength" hidden>
                <div class="pw-strength-bar">
                    <span class="pw-strength-fill" id="pwStrengthFill"></span>
                </div>
                <div class="pw-strength-label" id="pwStrengthLabel"></div>
            </div>
            <p class="mt-1 text-xs text-gray-500">Min. 8 characters with uppercase, number, and symbol</p>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
            <div id="confirmAffix">
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            </div>
            <div class="match-status" id="matchStatus" hidden></div>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>

    <script src="{{ asset('js/password-security.js') }}" defer></script>
</section>
