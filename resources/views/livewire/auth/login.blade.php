<div class="flex min-h-screen items-center justify-center">
    {{-- It is quality rather than quantity that matters. - Lucius Annaeus Seneca --}}
    <x-ui.card variant="sectioned" class="w-full max-w-sm">
        <x-ui.card-header>
            <x-ui.card-title>Login to your account</x-ui.card-title>
            <x-ui.card-description>Enter your email below to login to your account.</x-ui.card-description>
            <x-ui.card-action>
                <x-ui.button variant="link" wire:navigate href="{{ route('register') }}">Register</x-ui.button>
            </x-ui.card-action>
        </x-ui.card-header>
        <x-ui.card-content>
            <form wire:submit.prevent="login" class="flex flex-col gap-6">
                <x-ui.field>
                    <x-ui.field-label for="card-login-email">Email</x-ui.field-label>
                    <x-ui.input id="card-login-email" wire:model="form.email" type="email"
                        placeholder="m@example.com" />
                    @error('form.email')
                        <x-ui.error :message="$message" />
                    @enderror
                </x-ui.field>
                <x-ui.field>
                    <div class="flex items-center">
                        <x-ui.field-label for="card-login-password">Password</x-ui.field-label>
                        <a href="#" class="ml-auto text-sm underline-offset-4 hover:underline">Forgot your
                            password?</a>
                    </div>
                    <x-ui.input id="card-login-password" wire:model="form.password" type="password" />
                    @error('form.password')
                        <x-ui.error :message="$message" />
                    @enderror
                </x-ui.field>

        </x-ui.card-content>
        <x-ui.card-footer class="flex-col gap-2">
            <x-ui.button type="submit" class="w-full" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="login">Login</span>
                <span wire:loading wire:target="login">Logging you in...</span>
            </x-ui.button>
        </x-ui.card-footer>
        </form>
    </x-ui.card>
</div>
