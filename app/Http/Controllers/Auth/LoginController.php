<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showCaptcha()
    {
        $captchaHtml = captcha_img('flat');
        return view('Auth.login', compact('captchaHtml'));
    }

    public function reloadCaptcha()
    {
        return response()->json([
            'captcha' => captcha_img('flat'),
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
            'captcha'  => 'required|captcha',
            'remember' => 'boolean',
        ], [
            'captcha.required' => 'Enter the CAPTCHA',
            'captcha.captcha' => 'CAPTCHA is incorrect',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}
