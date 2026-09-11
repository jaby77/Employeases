/**
 * password-security.js — shared live password UX
 *
 * Adds to any password form:
 *   1. Live strength meter (color bar + label)
 *   2. Live confirm-password match indicator with green/red field state
 *   3. Optional show/hide toggles
 *   4. Submit guard when the confirmation does not match
 *
 * Setup:
 *   - Add the .pw-* CSS (copied into each styled page's <style> block)
 *   - Include <script src="{{ asset('js/password-security.js') }}" defer></script>
 *   - Or set window.PW_SECURITY_CONFIG before this script loads.
 *
 * Config shape (all optional):
 *   window.PW_SECURITY_CONFIG = {
 *       strength: { input: '#password', meter: '#pwStrength' },
 *       match:    { password: '#password', confirm: '#password_confirmation', fieldWrap: '#confirmAffix', status: '#matchStatus' },
 *       form:     { id: '#registerForm', button: '#submitBtn' },
 *       autofocusMismatch: true,
 *   };
 *
 * Auto-discovery (when no config is given): finds password + password_confirmation
 * inputs on the page, plus optional elements by id:
 *   #pwStrength / #pwStrengthFill / #pwStrengthLabel  — strength meter markup
 *   #matchStatus / #confirmAffix                      — match indicator markup
 *   form#registerForm / #submitBtn                    — submit guard + loading state
 */
(function () {
    'use strict';

    function run() {
        var cfg = window.PW_SECURITY_CONFIG || {};
        var strengthCfg = cfg.strength || {};
        var matchCfg = cfg.match || {};
        var formCfg = cfg.form || {};

        // ---------- Resolve inputs ----------
        var pwInput = document.querySelector(strengthCfg.input || matchCfg.password || 'input[type="password"][name="password"]');
        var confirmInput = document.querySelector(matchCfg.confirm || 'input[type="password"][name="password_confirmation"]');

        if (!pwInput) return; // nothing to do on this page

        // ---------- Strength meter elements ----------
        var strengthBox = document.querySelector(strengthCfg.meter || '#pwStrength');
        var strengthFill = document.getElementById('pwStrengthFill');
        var strengthLabel = document.getElementById('pwStrengthLabel');

        var STRENGTH_LEVELS = [
            { min: 0, width: 25, cls: 'level-1', label: 'Very weak', icon: 'bi-emoji-frown' },
            { min: 2, width: 50, cls: 'level-2', label: 'Weak', icon: 'bi-emoji-neutral' },
            { min: 4, width: 75, cls: 'level-3', label: 'Medium', icon: 'bi-emoji-smile' },
            { min: 5, width: 100, cls: 'level-4', label: 'Strong', icon: 'bi-shield-check' }
        ];

        function passwordScore(val) {
            var score = 0;
            if (val.length >= 8) score++;
            if (val.length >= 12) score++;
            if (/[a-z]/.test(val)) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;
            return score;
        }

        function updateStrength() {
            if (!strengthBox || !strengthFill || !strengthLabel) return;

            var val = pwInput.value;
            if (!val) {
                strengthBox.hidden = true;
                strengthFill.style.width = '0';
                strengthLabel.className = 'pw-strength-label';
                strengthLabel.innerHTML = '';
                return;
            }

            var score = passwordScore(val);
            var level = STRENGTH_LEVELS[0];
            for (var i = 0; i < STRENGTH_LEVELS.length; i++) {
                if (score >= STRENGTH_LEVELS[i].min) level = STRENGTH_LEVELS[i];
            }

            strengthBox.hidden = false;
            strengthFill.style.width = level.width + '%';
            strengthFill.className = 'pw-strength-fill ' + level.cls;
            strengthLabel.className = 'pw-strength-label ' + level.cls;
            strengthLabel.innerHTML = '<i class="bi ' + level.icon + '"></i> ' + level.label;
        }

        // ---------- Confirm-match indicator ----------
        var matchStatus = document.querySelector(matchCfg.status || '#matchStatus');
        var confirmAffix = document.querySelector(matchCfg.fieldWrap || '#confirmAffix');

        function updateMatch() {
            if (!confirmInput) return;

            var pwVal = pwInput.value;
            var confirmVal = confirmInput.value;

            if (!confirmVal) {
                if (matchStatus) matchStatus.hidden = true;
                if (confirmAffix) confirmAffix.classList.remove('has-error', 'has-success');
                return;
            }

            if (!matchStatus && !confirmAffix) return;

            var matches = pwVal && confirmVal === pwVal;

            if (matchStatus) {
                matchStatus.hidden = false;
                matchStatus.className = 'match-status ' + (matches ? 'match-ok' : 'match-bad');
                matchStatus.innerHTML = matches
                    ? '<i class="bi bi-check-circle"></i> Passwords match'
                    : '<i class="bi bi-x-circle"></i> Passwords do not match';
            }
            if (confirmAffix) {
                confirmAffix.classList.remove('has-error', 'has-success');
                confirmAffix.classList.add(matches ? 'has-success' : 'has-error');
            }
        }

        // ---------- Wire up live events ----------
        pwInput.addEventListener('input', function () {
            updateStrength();
            updateMatch();
        });

        if (confirmInput) {
            confirmInput.addEventListener('input', updateMatch);

            if (pwInput.form) {
                pwInput.form.addEventListener('submit', function (e) {
                    if (confirmInput.value !== pwInput.value) {
                        e.preventDefault();
                        updateMatch();
                        if (cfg.autofocusMismatch !== false) confirmInput.focus();
                        return;
                    }

                    // Optional submit-button loading state
                    var btn = formCfg.button ? document.querySelector(formCfg.button) : null;
                    if (btn) {
                        btn.classList.add('loading');
                        btn.disabled = true;
                    }
                });
            }
        } else if (pwInput) {
            // Pages without a confirmation field still get the live meter.
            pwInput.addEventListener('input', updateStrength);
        }

        // Run once in case the page pre-fills values.
        updateStrength();
        updateMatch();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', run);
    } else {
        run();
    }
})();
