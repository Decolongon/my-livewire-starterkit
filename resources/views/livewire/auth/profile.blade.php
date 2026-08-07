<div class="mx-auto w-full max-w-3xl px-4 py-10 sm:px-6 lg:px-8">
    {{-- Page header --}}
    <div class="mb-8 space-y-1.5">
        <h1 class="text-2xl font-semibold tracking-tight text-foreground">Profile</h1>
        <p class="text-muted-foreground text-sm">Manage your account details and security settings.</p>
    </div>

    <div class="space-y-6">
        {{-- ===== Update Profile ===== --}}
        <x-ui.card variant="sectioned" class="overflow-hidden">
            <x-ui.card-header>
                <x-ui.card-title>Update Profile</x-ui.card-title>
                <x-ui.card-description>Update your account details. Leave password fields blank to keep your current
                    password.</x-ui.card-description>
            </x-ui.card-header>

            <x-ui.card-content>
                <form wire:submit="updateProfile" class="flex flex-col gap-6">
                    <div class="grid gap-6 sm:grid-cols-2">
                        <x-ui.field>
                            <x-ui.field-label for="name">Name</x-ui.field-label>
                            <x-ui.input id="name" wire:model="name" type="text" placeholder="John Doe" />
                            @error('name')
                                <x-ui.error :message="$message" />
                            @enderror
                        </x-ui.field>
                        <x-ui.field>
                            <x-ui.field-label for="email">Email</x-ui.field-label>
                            <x-ui.input id="email" wire:model="email" type="email" placeholder="m@example.com" />
                            @error('email')
                                <x-ui.error :message="$message" />
                            @enderror
                        </x-ui.field>
                    </div>

                    <div class="grid gap-6 sm:grid-cols-3">
                        <x-ui.field>
                            <x-ui.field-label for="current_password">Current Password</x-ui.field-label>
                            <x-ui.input id="current_password" wire:model="current_password" type="password"
                                autocomplete="current-password" />
                            @error('current_password')
                                <x-ui.error :message="$message" />
                            @enderror
                        </x-ui.field>
                        <x-ui.field>
                            <x-ui.field-label for="new_password">New Password</x-ui.field-label>
                            <x-ui.input id="new_password" wire:model="new_password" type="password"
                                autocomplete="new-password" />
                            @error('new_password')
                                <x-ui.error :message="$message" />
                            @enderror
                        </x-ui.field>
                        <x-ui.field>
                            <x-ui.field-label for="new_password_confirmation">Confirm Password</x-ui.field-label>
                            <x-ui.input id="new_password_confirmation" wire:model="new_password_confirmation"
                                type="password" autocomplete="new-password" />
                            @error('new_password_confirmation')
                                <x-ui.error :message="$message" />
                            @enderror
                        </x-ui.field>
                    </div>

                    <div class="flex justify-end">
                        <x-ui.button type="submit" class="w-full sm:w-auto" wire:loading.attr="disabled" wire:target="updateProfile">Update
                            Profile</x-ui.button>
                    </div>
                </form>
            </x-ui.card-content>
        </x-ui.card>

        {{-- ===== Security (Two-Factor & Passkeys) ===== --}}
        @if ($this->securityConfirmed)
            {{-- ===== Two-Factor Authentication ===== --}}
            <livewire:auth.two-factor-auth />

            {{-- ===== Passkeys ===== --}}
            <x-ui.card variant="sectioned">
                <x-ui.card-header>
                    <x-ui.card-title>Passkeys</x-ui.card-title>
                    <x-ui.card-description>Use a passkey to sign in quickly and securely without a password.
                    </x-ui.card-description>
                </x-ui.card-header>

                <x-ui.card-content>
                    <div class="flex flex-col items-center justify-center rounded-lg border border-dashed p-8 text-center">
                        <span class="bg-muted flex size-10 items-center justify-center rounded-full">
                            <x-lucide-fingerprint class="text-muted-foreground size-5" />
                        </span>
                        <p class="mt-3 text-sm font-medium">No passkeys yet</p>
                        <p class="text-muted-foreground mt-1 max-w-xs text-xs">Add a passkey to sign in without a password
                            on
                            this device.</p>

                        <x-ui.button variant="outline" type="button" size="sm" class="mt-4">
                            <x-lucide-plus class="size-4" />
                            Add passkey
                        </x-ui.button>
                    </div>
                </x-ui.card-content>
            </x-ui.card>
        @else
            <x-ui.card variant="sectioned">
                <x-ui.card-header>
                    <x-ui.card-title>Security Settings</x-ui.card-title>
                    <x-ui.card-description>Confirm your password to manage two-factor authentication and passkeys.
                    </x-ui.card-description>
                </x-ui.card-header>

                <x-ui.card-content>
                    <form wire:submit="confirmSecurity" class="flex flex-col gap-4">
                        <x-ui.field>
                            <x-ui.field-label for="confirm_password">Password</x-ui.field-label>
                            <x-ui.input id="confirm_password" wire:model="confirm_password" type="password"
                                autocomplete="current-password" placeholder="Enter your password to confirm" />
                            @error('confirm_password')
                                <x-ui.error :message="$message" />
                            @enderror
                        </x-ui.field>

                        <div class="flex justify-end">
                            <x-ui.button type="submit" class="w-full sm:w-auto" wire:loading.attr="disabled" wire:target="confirmSecurity">Confirm
                                Password</x-ui.button>
                        </div>
                    </form>
                </x-ui.card-content>
            </x-ui.card>
        @endif
    </div>
</div>

