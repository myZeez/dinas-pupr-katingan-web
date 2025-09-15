<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    /**
     * Tampilkan halaman pengaturan akun.
     */
    public function index()
    {
        $user = Auth::user();
        return view('admin.account.index', compact('user'));
    }

    /**
     * Update profil user (nama, email, avatar).
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name'   => ['required', 'string', 'max:255'],
            'email'  => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . Auth::id()],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'], // max 2MB
        ]);

        $user = Auth::user();

        // Handle upload avatar
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $path = $avatar->store('avatars', 'public');

            // Hapus avatar lama jika ada
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $user->avatar = $path;
        }

        // Update info profil
        $user->name  = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('admin.account.index')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Update password user.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = Auth::user();
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.account.index')
            ->with('success', 'Password berhasil diperbarui.');
    }
}
