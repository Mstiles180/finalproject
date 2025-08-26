<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        return view('settings.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'location' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'in:laundry,builder,builder_helper,farmer,cleaner,other'],
            'other_category' => ['nullable', 'string', 'max:255'],
            'daily_rate' => ['nullable', 'numeric', 'min:0'],
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // Add worker-specific fields if user is a worker
        if ($user->role === 'worker') {
            $userData['phone'] = $request->phone;
            $userData['location'] = $request->location;
            $userData['category'] = $request->category;
            $userData['other_category'] = $request->other_category;
            $userData['daily_rate'] = $request->daily_rate;
        }

        $user->update($userData);

        return redirect()->route('settings.profile')->with('success', 'Profile updated successfully!');
    }

    public function changePassword()
    {
        return view('settings.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('settings.change-password')->with('success', 'Password changed successfully!');
    }
}
