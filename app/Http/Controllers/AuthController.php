<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Block suspended users
            if (auth()->user()->is_suspended ?? false) {
                Auth::logout();
                return back()->withErrors(['email' => 'Your account is suspended.'])->onlyInput('email');
            }

            // Redirect admins to admin dashboard
            if (auth()->user()->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'));
            }

            // Force new/incomplete profiles to go to profile settings first
            if (empty(auth()->user()->phone) || (auth()->user()->isWorker() && empty(auth()->user()->pickup_point_id))) {
                return redirect()->intended(route('settings.profile'));
            }

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => ['required', 'in:worker,boss'],
            'phone' => ['nullable', 'string', 'max:20'],
            'location' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'in:laundry,builder,builder_helper,farmer,cleaner,other'],
            'other_category' => ['nullable', 'string', 'max:255'],
            'daily_rate' => ['nullable', 'numeric', 'min:0'],
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ];

        // Add worker-specific fields if role is worker
        if ($request->role === 'worker') {
            $userData['phone'] = $request->phone;
            $userData['location'] = $request->location;
            $userData['category'] = $request->category;
            $userData['other_category'] = $request->other_category;
            $userData['daily_rate'] = $request->daily_rate;
            $userData['is_available'] = true;
        }

        $user = User::create($userData);

        Auth::login($user);

        // After registration, send users to profile to complete info
        return redirect()->route('settings.profile');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
} 