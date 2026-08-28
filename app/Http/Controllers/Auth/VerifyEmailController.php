<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->redirectToDashboard($request);
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return $this->redirectToDashboard($request, 'verified=1');
    }

    /**
     * Redirect user to their appropriate dashboard based on role.
     */
    private function redirectToDashboard(EmailVerificationRequest $request, string $params = ''): RedirectResponse
    {
        $route = $request->user()->isAdmin()
            ? route('admin.dashboard', absolute: false)
            : route('jobseeker.dashboard', absolute: false);

        if ($params) {
            $route .= '?' . $params;
        }

        return redirect()->intended($route);
    }
}
