<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
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
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email|lowercase',
            'password' => 'required|min:8|confirmed',
            'captcha'  => 'required|captcha',
            'password_confirmation' => 'required|same:password',
        ], [
            'captcha.required' => 'Enter the CAPTCHA',
            'captcha.captcha' => 'CAPTCHA is incorrect',
        ]);

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
