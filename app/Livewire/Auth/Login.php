<?php

declare(strict_types=1);

namespace App\Livewire\Auth;

use App\Livewire\Forms\Auth\LoginForm;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
final class Login extends Component
{
    public LoginForm $form;

    public function login()
    {
        // $this->validate();
        $this->form->authenticate();

        session()->regenerate();
       return $this->redirectIntended(default: route('dashboard', absolute: false));

       // $this->form->reset();
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
