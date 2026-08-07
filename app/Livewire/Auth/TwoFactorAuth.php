<?php

namespace App\Livewire\Auth;

use App\Concerns\HasRateLimit;
use App\Concerns\HasToast;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Actions\ConfirmTwoFactorAuthentication;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;
use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;
use Laravel\Fortify\Actions\GenerateNewRecoveryCodes;
use Laravel\Fortify\Features;
use Laravel\Fortify\Fortify;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Component;

#[Layout('components.layouts.app')]
final class TwoFactorAuth extends Component
{
    use HasToast, HasRateLimit;

    #[Locked]
    public bool $canManageTwoFactor;

    #[Locked]
    public bool $twoFactorEnabled;

    #[Locked]
    public bool $requiresConfirmation;

    #[Locked]
    public bool $canManagePasskeys;

    #[Locked]
    public $qrCodeSvg = '';

    #[Locked]
    public $manualSetupKey = '';

    public $twoFactorCode = '';

    #[Locked]
    public $recoveryCodes = [];


    public function mount(DisableTwoFactorAuthentication $disableTwoFactorAuthentication)
    {
        $this->canManageTwoFactor = Features::canManageTwoFactorAuthentication();

        if ($this->canManageTwoFactor) {
            if (Fortify::confirmsTwoFactorAuthentication() && is_null(Auth::user()->two_factor_confirmed_at)) {
                $disableTwoFactorAuthentication(Auth::user());
            }

            $this->twoFactorEnabled = Auth::user()->hasEnabledTwoFactorAuthentication();

            if ($this->twoFactorEnabled) {
                $this->loadRecoveryCodes();
            }

            $this->requiresConfirmation = Features::optionEnabled(Features::twoFactorAuthentication(), 'confirm');
        }
        $this->canManagePasskeys = Features::canManagePasskeys();

    }


     public function enable2FA(EnableTwoFactorAuthentication $enableTwoFactorAuthentication)
    {
        $enableTwoFactorAuthentication(Auth::user());

        if (! $this->requiresConfirmation) {
            $this->twoFactorEnabled = Auth::user()->hasEnabledTwoFactorAuthentication();
        }

        $this->generate2FA();

        $this->loadRecoveryCodes();
    }

    private function generate2FA()
    {
        $user = Auth::user();
        try {
            $this->qrCodeSvg = $user?->twoFactorQrCodeSvg();
            $this->manualSetupKey = decrypt($user->two_factor_secret);
        } catch (Exception) {
            $this->toastError('Failed to generate two-factor authentication QR code. Please try again later.');

            $this->reset('qrCodeSvg', 'manualSetupKey');
        }
    }

    public function confirm2FA(ConfirmTwoFactorAuthentication $confirmTwoFactorAuthentication)
    {
        $this->validate([
            'twoFactorCode' => ['required', 'string', 'size:6'],
        ]);

        try {
            $confirmTwoFactorAuthentication(Auth::user(), $this->twoFactorCode);
        } catch (ValidationException) {
            $this->addError('twoFactorCode', __('The provided two factor authentication code was invalid.'));

            return;
        }

        $this->twoFactorEnabled = Auth::user()->hasEnabledTwoFactorAuthentication();
        $this->reset('twoFactorCode', 'qrCodeSvg', 'manualSetupKey');
        $this->loadRecoveryCodes();
        $this->toastSuccess('Two factor authentication is now fully enabled.');
    }

    public function regenerateRecoveryCodes(GenerateNewRecoveryCodes $generateNewRecoveryCodes)
    {
        if(! $this->limitRate(3)){
            $this->toastError('Too many attempts. Please try again later.');
            return;
        }
        $generateNewRecoveryCodes(Auth::user());

        $this->loadRecoveryCodes();
        $this->toastSuccess('Recovery codes regenerated successfully.');
    }

    public function disable2FA(DisableTwoFactorAuthentication $disableTwoFactorAuthentication)
    {
        $disableTwoFactorAuthentication(Auth::user());

        $this->twoFactorEnabled = Auth::user()->hasEnabledTwoFactorAuthentication();
        $this->reset('twoFactorCode', 'qrCodeSvg', 'manualSetupKey', 'recoveryCodes');
        $this->toastSuccess('Two factor authentication has been disabled.');
    }

    private function loadRecoveryCodes()
    {
        $user = Auth::user();

        $this->recoveryCodes = $user->two_factor_secret && $user->two_factor_recovery_codes
            ? json_decode(Fortify::currentEncrypter()->decrypt($user->two_factor_recovery_codes), true)
            : [];
    }


    public function render()
    {
        return view('livewire.auth.two-factor-auth');
    }
}
