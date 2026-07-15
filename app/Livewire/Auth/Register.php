<?php
declare(strict_types=1);

namespace App\Livewire\Auth;

use App\Livewire\Forms\Auth\RegisterForm;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
final class Register extends Component
{
    public RegisterForm $form;

    public function submitRegistration()
    {
        $this->form->register();

       return $this->redirectIntended(default: route('dashboard',absolute: false));
    }
    public function render()
    {
        return view('livewire.auth.register');
    }
}
