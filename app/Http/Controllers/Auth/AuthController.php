<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ==========================================
    // USER AUTHENTICATION
    // ==========================================

    public function showLoginForm()
    {
        if (Auth::check()) {
            return Auth::user()->isAdmin()
                ? redirect()->route('admin.dashboard')
                : redirect()->route('user.dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            if ($user->status === 'blocked') {
                Auth::logout();
                return back()->with('error', 'Your account has been deactivated. Please contact support.');
            }

            $request->session()->regenerate();

            if ($user->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'))->with('success', 'Welcome back, Administrator!');
            }

            return redirect()->intended(route('user.dashboard'))->with('success', 'Logged in successfully! Welcome, ' . $user->name);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:255',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
            'phone' => $validated['phone'] ?? null,
            'city' => $validated['city'] ?? null,
            'address' => $validated['address'] ?? null,
            'status' => 'active',
        ]);

        Auth::login($user);

        return redirect()->route('user.dashboard')->with('success', 'Account registered successfully! Welcome to Travel Booking.');
    }

    // ==========================================
    // ADMIN AUTHENTICATION
    // ==========================================

    public function showAdminLoginForm()
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();

            if (!$user->isAdmin()) {
                Auth::logout();
                return back()->with('error', 'Unauthorized. Only administrators can access this portal.');
            }

            if ($user->status === 'blocked') {
                Auth::logout();
                return back()->with('error', 'This administrator account has been disabled.');
            }

            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'))->with('success', 'Welcome back, Administrator!');
        }

        return back()->withErrors([
            'email' => 'Invalid administrator credentials.',
        ])->onlyInput('email');
    }

    public function showAdminRegisterForm()
    {
        return view('admin.auth.register');
    }

    public function adminRegister(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'nullable|string|max:20',
            'admin_secret' => 'required|string', // Security code for admin registration
        ]);

        // Default demo secret: "VU-CS619-ADMIN"
        if ($validated['admin_secret'] !== 'VU-CS619-ADMIN') {
            return back()->withErrors([
                'admin_secret' => 'Invalid Admin Security Key. Use "VU-CS619-ADMIN" to create an admin account.'
            ])->withInput();
        }

        $admin = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'admin',
            'phone' => $validated['phone'] ?? null,
            'status' => 'active',
        ]);

        Auth::login($admin);

        return redirect()->route('admin.dashboard')->with('success', 'Administrator registered successfully!');
    }

    // ==========================================
    // LOGOUT
    // ==========================================

    public function logout(Request $request)
    {
        $isAdmin = Auth::check() && Auth::user()->isAdmin();
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($isAdmin) {
            return redirect()->route('admin.login')->with('success', 'Admin session terminated successfully.');
        }

        return redirect()->route('home')->with('success', 'You have been logged out.');
    }
}
