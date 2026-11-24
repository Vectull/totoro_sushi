<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationController extends Controller
{
    public function notice(): View
    {
        return view('auth.verify-email');
    }

    public function verify(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('home')->with('status', 'Адрес электронной почты уже подтверждён.');
        }

        $request->fulfill();

        return redirect()->route('home')->with('status', 'Адрес электронной почты подтверждён.');
    }

    public function resend(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('home')->with('status', 'Адрес электронной почты уже подтверждён.');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'Письмо со ссылкой для подтверждения отправлено повторно.');
    }
}
