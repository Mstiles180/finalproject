<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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
            'nid_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'experience_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'province_id' => ['nullable','exists:provinces,id'],
            'district_id' => ['nullable','exists:districts,id'],
            'sector_id' => ['nullable','exists:sectors,id'],
            'cell_id' => ['nullable','exists:cells,id'],
            'village_id' => ['nullable','exists:villages,id'],
            'pickup_point_id' => ['nullable','exists:pickup_points,id'],
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        // Add worker-specific fields if user is a worker
        if ($user->role === 'worker') {
            $userData['location'] = $request->location;
            $userData['category'] = $request->category;
            $userData['other_category'] = $request->other_category;
            $userData['daily_rate'] = $request->daily_rate;
            $userData['province_id'] = $request->province_id;
            $userData['district_id'] = $request->district_id;
            $userData['sector_id'] = $request->sector_id;
            $userData['cell_id'] = $request->cell_id;
            $userData['village_id'] = $request->village_id;
            $userData['pickup_point_id'] = $request->pickup_point_id;

            if ($request->hasFile('nid_image')) {
                $path = $request->file('nid_image')->store('worker_docs', 'public');
                $userData['nid_image_url'] = Storage::url($path);
            }

            if ($request->hasFile('experience_image')) {
                $path = $request->file('experience_image')->store('worker_docs', 'public');
                $userData['experience_image_url'] = Storage::url($path);
            }
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
