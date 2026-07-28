<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', [LoginController::class, 'showCaptcha'])->name('login');
Route::get('/reload-captcha-login', [LoginController::class, 'reloadCaptcha'])->name('captcha.reload.login');

Route::get('/register', [RegisterController::class, 'showCaptcha'])->name('register');
Route::get('/reload-captcha-register', [RegisterController::class, 'reloadCaptcha'])->name('captcha.reload.register');

Route::middleware('throttle:authLimit')->group(function () {
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
