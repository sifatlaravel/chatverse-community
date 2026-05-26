<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        $user = $request->user();
        return view('dashboard.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'company' => ['nullable','string','max:255'],
            'timezone' => ['nullable','string','max:64'],
            'email' => ['required','email','max:255'],
        ]);

        $emailChanged = $data['email'] !== $user->email;

        $user->fill($data);
        if ($emailChanged) {
            $user->email_verified_at = null;
        }
        $user->save();

        if ($emailChanged) {
            $user->sendEmailVerificationNotification();
        }

        return back()->with('status','Profile updated.');
    }

    public function password(Request $request)
    {
        $request->validate([
            'current_password' => ['required','string'],
            'password' => ['required','confirmed', Password::min(8)],
        ]);

        $user = $request->user();
        if (!Hash::check($request->input('current_password'), $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->password = Hash::make($request->input('password'));
        $user->save();

        return back()->with('status','Password updated.');
    }
}
