<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function forgotPassword(Request $request)
    {
        // Validate email
        $request->validate(['email' => ['required', 'email']]);

        // Try to send an email
        $status = Password::sendResetLink($request->only('email'));

        // If email was sent redirect user back with success message
        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('success', __($status));
        }

        // If there was an error, redirect user back with email error and with email input
        return back()
            ->withErrors(['email' => __($status)])
            ->withInput($request->only('email'));
    }

    public function showResetPassword()
    {
        return view('auth.reset-password');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'confirmed',
                \Illuminate\Validation\Rules\Password::min(8)
                    ->max(24)
                    ->numbers()
                    ->mixedCase()
                    ->symbols()
                    ->uncompromised()]
        ]);

        $status = Password::reset(
            $request->only(['email', 'password', 'password_confirmation', 'token']),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );
        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success', __($status));
        }

        return back()->withErrors(['email' => __($status)]);
    }
}
