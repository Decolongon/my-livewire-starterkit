<?php

namespace App\Livewire\Auth;

use App\Concerns\HasRateLimit;
use App\Concerns\HasToast;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Profile')]
class Profile extends Component
{
    use HasRateLimit, HasToast;

    public $name = '';

    public $email = '';

    public $new_password = '';

    public $new_password_confirmation = '';

    public $current_password = '';

    public function mount()
    {
        $this->getNameEmail();
    }

    #[On('profile-updated')]
    public function getNameEmail()
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    protected function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . Auth::id()],
        ];

        if ($this->new_password || $this->current_password) {
            $rules['current_password'] = ['required', 'current_password'];
            $rules['new_password'] = ['required', 'string', 'min:8', 'confirmed'];
        }

        if ($this->new_password) {
            $rules['new_password_confirmation'] = ['required'];
        }

        return $rules;
    }

    public function updateProfile()
    {
        try {
            $this->limitRate();
            $validated = $this->validate();

            $user = Auth::user();
            $user->name = $validated['name'];
            $user->email = $validated['email'];

            if (! empty($validated['new_password'])) {
                $user->password = bcrypt($validated['new_password']);
            }

            $user->save();
            $this->reset('new_password', 'new_password_confirmation', 'current_password');
            $this->dispatch('profile-updated')->to(self:true);
            $this->toastSuccess('Profile updated successfully.');
        } catch (\Exception $e) {
            $this->toastError($e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.auth.profile');
    }
}
