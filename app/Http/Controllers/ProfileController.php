<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage; 
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    // 👈 Ye file delete/save karne ke liye top par add karen

public function update(Request $request): RedirectResponse
{
    // 1. Validation mein avatar add kiya
    $validated = $request->validate([
        'phone'      => ['nullable', 'string', 'max:20'],
        'university' => ['nullable', 'string', 'max:255'],
        'degree'     => ['nullable', 'string', 'max:255'],
        'address'    => ['nullable', 'string', 'max:500'],
        'avatar'     => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // Max 2MB image
    ]);

    $user = $request->user();

    // 2. Agar user ne nayi picture upload ki hai
    if ($request->hasFile('avatar')) {
        // Agar purani picture pehle se majood hai to usay delete kar do taake storage full na ho
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Nayi picture ko 'public/avatars' folder mein save karen
        $folderPath = 'avatars/' . ($user->role === 'mentor' ? 'mentors' : 'interns');
        $path = $request->file('avatar')->store($folderPath, 'public');
        $user->avatar = $path; // Database column mein path save karein
    }

    // 3. Baki fields ko fill aur save karen
    $user->fill($request->except('avatar')); // avatar ko alag se handle kiya hai
    $user->save();

    return redirect()->route('intern.dashboard')->with('success', 'Profile updated successfully!');
}
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}