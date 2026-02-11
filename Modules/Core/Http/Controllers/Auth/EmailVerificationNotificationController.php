<?php

namespace Modules\Core\Http\Controllers\Auth;

use Illuminate\Routing\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', false));
        }
        $request->user()->sendEmailVerificationNotification();
        return back()->with('status', __('messages.verification_link_sent'));
    }
}
