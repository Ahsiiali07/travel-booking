<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    // ==========================================
    // USER FORGOT PASSWORD
    // ==========================================

    public function showLinkRequestForm()
    {
        return view('auth.forgot-password', ['isAdmin' => false]);
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $token = Str::random(60);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => Hash::make($token), 'created_at' => now()]
        );

        // For viva demonstration and local testing convenience:
        $resetUrl = route('password.reset', ['token' => $token, 'email' => $request->email]);

        return back()->with([
            'status' => 'Password reset request generated successfully!',
            'demo_reset_url' => $resetUrl,
            'demo_token' => $token,
        ]);
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.reset-password', [
            'token' => $token ?? $request->token,
            'email' => $request->email,
            'isAdmin' => false
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);

        $record = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (!$record) {
            return back()->withErrors(['email' => 'Invalid or expired password reset token.']);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'User does not exist.']);
        }

        $user->forceFill([
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60),
        ])->save();

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        if ($user->isAdmin()) {
            return redirect()->route('admin.login')->with('success', 'Admin password has been reset successfully. Please log in.');
        }

        return redirect()->route('login')->with('success', 'Your password has been reset successfully. You can now log in.');
    }

    // ==========================================
    // ADMIN FORGOT PASSWORD
    // ==========================================

    public function showAdminLinkRequestForm()
    {
        return view('admin.auth.forgot-password', ['isAdmin' => true]);
    }

    public function sendAdminResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user || !$user->isAdmin()) {
            return back()->withErrors(['email' => 'This email does not belong to an administrator account.']);
        }

        $token = Str::random(60);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => Hash::make($token), 'created_at' => now()]
        );

        $resetUrl = route('admin.password.reset', ['token' => $token, 'email' => $request->email]);

        return back()->with([
            'status' => 'Admin password reset link generated successfully!',
            'demo_reset_url' => $resetUrl,
            'demo_token' => $token,
        ]);
    }

    public function showAdminResetForm(Request $request, $token = null)
    {
        return view('admin.auth.reset-password', [
            'token' => $token ?? $request->token,
            'email' => $request->email,
            'isAdmin' => true
        ]);
    }
}
