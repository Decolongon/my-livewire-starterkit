<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showCaptcha()
    {
        $captchaHtml = captcha_img('flat');
        return view('Auth.register', compact('captchaHtml'));
    }

    public function reloadCaptcha()
    {
        return response()->json([
            'captcha' => captcha_img('flat'),
        ]);
    }
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $user =  User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->intended(route('dashboard'));
    }
}
