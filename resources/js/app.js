import './bootstrap';

import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

// Import SweetAlert2
import Swal from 'sweetalert2';
window.Swal = Swal;

/* Chart.js is intentionally NOT imported here — it ships in its own
   resources/js/charts.js entry, loaded only on pages that render charts. */

/* ==========================================================================
   EMPLOYEASE DESIGN SYSTEM — global feedback helpers
   ========================================================================== */

function escapeHtml(value) {
    const div = document.createElement('div');
    div.textContent = String(value);
    return div.innerHTML;
}

/**
 * Show an auto-dismissing toast in the top-right corner.
 * @param {string} message
 * @param {'success'|'error'|'warning'|'info'} [type='success']
 */
function showToast(message, type = 'success') {
    let stack = document.getElementById('appToastStack');
    if (!stack) {
        stack = document.createElement('div');
        stack.id = 'appToastStack';
        stack.className = 'app-toast-stack';
        stack.setAttribute('aria-live', 'polite');
        document.body.appendChild(stack);
    }

    const icons = {
        success: 'bi-check-circle-fill',
        error: 'bi-x-circle-fill',
        warning: 'bi-exclamation-triangle-fill',
        info: 'bi-info-circle-fill',
    };

    const toast = document.createElement('div');
    toast.className = `app-toast app-toast-${type}`;
    toast.setAttribute('role', 'status');
    toast.innerHTML = `
        <i class="bi ${icons[type] || icons.info}" aria-hidden="true"></i>
        <span>${escapeHtml(message)}</span>
        <button type="button" class="app-toast-close" aria-label="Dismiss"><i class="bi bi-x-lg" aria-hidden="true"></i></button>
    `;
    stack.appendChild(toast);

    const dismiss = () => {
        toast.classList.add('app-toast-leaving');
        setTimeout(() => toast.remove(), 250);
    };
    toast.querySelector('.app-toast-close').addEventListener('click', dismiss);
    setTimeout(dismiss, 4000);
}

window.showToast = showToast;

/* Convert server-flashed session alerts into toasts (progressive enhancement:
   the banners still render for no-JS users). */
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.session-alert').forEach(function (alert) {
        const type = alert.dataset.toastType || 'info';
        const message = alert.dataset.toastMessage || '';
        if (message) {
            showToast(message, type);
        }
        alert.remove();
    });
});

/* Delegated confirmation dialog for any <form class="confirm-form">.
   Configure via data-confirm-title / data-confirm-text / data-confirm-ok /
   data-confirm-color on the form element. */
document.addEventListener('submit', function (e) {
    const form = e.target;
    if (!(form instanceof HTMLFormElement) || !form.classList.contains('confirm-form')) {
        return;
    }
    if (form.dataset.confirmed) {
        return;
    }
    e.preventDefault();

    Swal.fire({
        title: form.dataset.confirmTitle || 'Are you sure?',
        text: form.dataset.confirmText || 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: form.dataset.confirmColor || '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: form.dataset.confirmOk || 'Yes, continue',
        cancelButtonText: 'Cancel',
    }).then(function (result) {
        if (result.isConfirmed) {
            form.dataset.confirmed = '1';
            form.submit();
        }
    });
});
