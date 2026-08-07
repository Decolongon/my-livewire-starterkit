<x-layouts.app>
    <div class="flex min-h-screen items-center justify-center">
        <x-ui.card variant="sectioned" class="w-full max-w-sm">
            <x-ui.card-header>
                <x-ui.card-title>Two-Factor Authentication</x-ui.card-title>
                <x-ui.card-description>Enter the authentication code from your authenticator app to continue.</x-ui.card-description>
            </x-ui.card-header>

            <x-ui.card-content>
                <div x-data="{ showRecovery: @json($errors->has('recovery_code')) }" class="w-full">
                    <form method="POST" action="{{ route('two-factor.login.store') }}" class="flex flex-col gap-6">
                        @csrf

                        <div x-show="!showRecovery">
                            <x-ui.field>
                                <x-ui.field-label for="code">Authentication Code</x-ui.field-label>
                                <x-ui.input id="code" name="code" type="text" inputmode="numeric" maxlength="6"
                                    autocomplete="one-time-code" placeholder="123456" />
                                @error('code')
                                    <x-ui.error :message="$message" />
                                @enderror
                            </x-ui.field>
                        </div>

                        <div x-show="showRecovery" style="display: none;">
                            <x-ui.field>
                                <x-ui.field-label for="recovery_code">Recovery Code</x-ui.field-label>
                                <x-ui.input id="recovery_code" name="recovery_code" type="text"
                                    autocomplete="one-time-code" placeholder="Enter a recovery code" />
                                @error('recovery_code')
                                    <x-ui.error :message="$message" />
                                @enderror
                            </x-ui.field>
                        </div>

                        <div class="flex flex-col gap-3">
                            <x-ui.button type="submit" class="w-full">Continue</x-ui.button>
                            <button type="button" @click="showRecovery = !showRecovery"
                                class="text-muted-foreground text-sm underline underline-offset-4 hover:text-foreground">
                                <span x-show="!showRecovery">Login using a recovery code</span>
                                <span x-show="showRecovery" style="display: none;">Login using an authentication code</span>
                            </button>
                        </div>
                    </form>
                </div>
            </x-ui.card-content>
        </x-ui.card>
    </div>
</x-layouts.app>
