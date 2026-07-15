<div>
    {{-- Nothing in life is to be feared, it is only to be understood. Now is the time to understand more, so that we may fear less. - Maria Skłodowska-Curie --}}

    <div class="flex min-h-screen items-center justify-center">
        {{-- It is quality rather than quantity that matters. - Lucius Annaeus Seneca --}}
        <x-ui.card variant="sectioned" class="w-full max-w-sm">
            <x-ui.card-header>
                <x-ui.card-title>Create your account</x-ui.card-title>
                <x-ui.card-description>Enter your credentials below.</x-ui.card-description>
                <x-ui.card-action>
                    <x-ui.button variant="link" wire:navigate href="{{ route('login') }}">Log in</x-ui.button>
                </x-ui.card-action>
            </x-ui.card-header>
            <x-ui.card-content>
                <form wire:submit.prevent="submitRegistration" class="flex flex-col gap-6">
                    <x-ui.field>
                        <x-ui.field-label for="card-register-name">Name</x-ui.field-label>
                        <x-ui.input id="card-register-name" wire:model="form.name" type="text"
                            placeholder="John Doe" />
                        @error('form.name')
                            <x-ui.error :message="$message" />
                        @enderror
                    </x-ui.field>
                    <x-ui.field>
                        <x-ui.field-label for="card-register-email">Email</x-ui.field-label>
                        <x-ui.input id="card-register-email" wire:model="form.email" type="email"
                            placeholder="m@example.com" />
                        @error('form.email')
                            <x-ui.error :message="$message" />
                        @enderror
                    </x-ui.field>
                    <x-ui.field>
                        <x-ui.field-label for="card-register-password">Password</x-ui.field-label>
                        <x-ui.input id="card-register-password" wire:model="form.password" type="password" />
                        @error('form.password')
                            <x-ui.error :message="$message" />
                        @enderror
                    </x-ui.field>

                    <x-ui.field>
                        <x-ui.field-label for="card-register-password_confirmatiom">Password Confirmation</x-ui.field-label>
                        <x-ui.input id="card-register-password_confirmation" wire:model="form.password_confirmation" type="password" />
                        @error('form.password_confirmation')
                            <x-ui.error :message="$message" />
                        @enderror
                    </x-ui.field>

            </x-ui.card-content>
            <x-ui.card-footer class="flex-col gap-2">
                <x-ui.button type="submit" class="w-full" wire:loading.attr="disabled">Register</x-ui.button>
            </x-ui.card-footer>
            </form>
        </x-ui.card>
    </div>

</div>
