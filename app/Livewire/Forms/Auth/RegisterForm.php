<?php

declare(strict_types=1);

namespace App\Livewire\Forms\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Form;

final class RegisterForm extends Form
{
    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    public function register(): void
    {
        $validated = $this->validate();

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        Auth::login($user);

        $this->reset();
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100', 'min:3'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
            'password' => ['required', 'string', 'confirmed', $this->passwordValidationRules()],
            'password_confirmation' => ['required', 'same:password'],
        ];
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 100 characters.',
            'name.min' => 'The name must be at least 3 characters.',
            'email.required' => 'The email field is required.',
            'email.string' => 'The email must be a string.',
            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'The email may not be greater than 100 characters.',
            'email.unique' => 'This email is already registered.',
            'password.required' => 'The password field is required.',
            'password.string' => 'The password must be a string.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password.letters' => 'The password must contain at least one letter.',
            'password.mixed' => 'The password must contain both uppercase and lowercase letters.',
            'password.numbers' => 'The password must contain at least one number.',
            'password.symbols' => 'The password must contain at least one symbol.',
            'password.min' => 'The password must be at least :min characters.',
            'password.uncompromised' => 'The password appears in a data breach. Please choose a different one.',
            'password_confirmation.required' => 'Please confirm your password.',
            'password_confirmation.same' => 'The password confirmation does not match.',
        ];
    }


    protected function passwordValidationRules(): Password
    {
        $isProduction = app()->isProduction();
        $min = $isProduction ? 12 : 8;

        return Password::min($min)
            ->letters()
            ->mixedCase()
            ->numbers()
            ->symbols()
            ->when($isProduction, fn($rules) => $rules->uncompromised());
    }
}
