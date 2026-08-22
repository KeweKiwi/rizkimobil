<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function show(Request $request): View
    {
        return view('account.show', [
            'user' => $request->user(),
            'favoriteCount' => $request->user()->favoriteCars()->count(),
        ]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $user = $request->user();
        $emailWillChange = Str::lower((string) $request->input('email')) !== Str::lower($user->email);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => ['required', 'string', 'min:8', 'max:30'],
            'current_password' => [Rule::requiredIf($emailWillChange), 'nullable', 'current_password'],
        ]);

        unset($data['current_password']);

        if ($emailWillChange) {
            $data['email_verified_at'] = null;
        }

        $user->forceFill($data)->save();

        return back()->with('profile_status', 'Informasi akun berhasil diperbarui.');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $request->user()->forceFill([
            'password' => $data['password'],
            'remember_token' => Str::random(60),
        ])->save();
        $request->session()->regenerate();

        return back()->with('account_status', 'Password akun berhasil diperbarui.');
    }
}
