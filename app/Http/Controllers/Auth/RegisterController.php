<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function show()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'company' => ['nullable','string','max:255'],
            'email' => ['required','string','email','max:255','unique:users'],
            'password' => ['required','confirmed', Password::min(8)],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'company' => $data['company'] ?? null,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'timezone' => $request->input('timezone'),
        ]);

        // Create inactive subscription row for easier gating
        Subscription::firstOrCreate(['user_id' => $user->id], [
            'plan_id' => 1,
            'status' => 'inactive',
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('verification.notice');
    }
}
