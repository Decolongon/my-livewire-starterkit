<div>
    {{-- Simplicity is the essence of happiness. - Cedric Bledsoe --}}
    @if ($this->canManageTwoFactor)
        <x-ui.card variant="sectioned">
            <x-ui.card-header>
                <x-ui.card-title>Two-Factor Authentication</x-ui.card-title>
                <x-ui.card-description>Add an extra layer of security to your account by enabling two-factor
                    authentication.</x-ui.card-description>
            </x-ui.card-header>

            <x-ui.card-content>
                @if ($twoFactorEnabled)
                    {{-- Enabled state --}}
                    <div class="space-y-6">
                        <div class="flex items-start gap-3 rounded-lg border p-4">
                            <span class="bg-muted flex size-9 shrink-0 items-center justify-center rounded-lg">
                                <x-lucide-shield-check class="text-muted-foreground size-4" />
                            </span>
                            <div class="space-y-1">
                                <p class="text-sm font-medium leading-none">Enabled</p>
                                <p class="text-muted-foreground text-xs">Two-factor authentication is enabled for your
                                    account.</p>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <p class="text-sm font-medium">Recovery codes</p>
                            <p class="text-muted-foreground text-xs">Store these codes somewhere safe. Each code can
                                only
                                be used once to recover access.</p>

                            <div x-data="{ copied: false }" class="space-y-3 rounded-lg border p-4">
                                <div class="grid grid-cols-1 gap-2 sm:grid-cols-2">
                                    @foreach ($recoveryCodes as $code)
                                        <code
                                            class="rounded-md bg-muted px-3 py-2 text-center font-mono text-xs select-all">{{ $code }}</code>
                                    @endforeach
                                </div>

                                <x-ui.button variant="outline" type="button" size="sm" class="w-full sm:w-auto"
                                    @click="navigator.clipboard.writeText(@json(implode(PHP_EOL, $recoveryCodes))).then(() => { copied = true; setTimeout(() => copied = false, 2000) })">
                                    <template x-if="copied"><x-lucide-check class="size-4" /> Copied!</template>
                                    <template x-if="!copied"><x-lucide-copy class="size-4" /> Copy recovery
                                        codes</template>
                                </x-ui.button>
                            </div>

                            <div class="flex flex-col gap-2 pt-2 sm:flex-row">
                                <x-ui.button variant="outline" type="button" size="sm"
                                    wire:click="regenerateRecoveryCodes" wire:loading.attr="disabled">
                                    <x-lucide-rotate-ccw class="size-4" /> Regenerate recovery codes
                                </x-ui.button>
                                <x-ui.button variant="destructive" type="button" size="sm" wire:click="disable2FA"
                                    wire:loading.attr="disabled">
                                    <x-lucide-shield-off class="size-4" /> Disable
                                </x-ui.button>
                            </div>
                        </div>
                    </div>
                @elseif ($qrCodeSvg)
                    <div class="space-y-6">
                        {{-- QR code --}}
                        <div class="flex flex-col items-center gap-4 rounded-lg border p-6 text-center">
                            <p class="text-sm font-medium">Scan this QR code with your authenticator app</p>
                            <div
                                class="rounded-xl border bg-white p-4 dark:bg-white [&_svg]:h-auto [&_svg]:w-full [&_svg]:max-w-[180px]">
                                {!! $qrCodeSvg !!}
                            </div>
                        </div>

                        {{-- Setup key --}}
                        <div class="space-y-2">
                            <p class="text-sm font-medium">Setup key</p>
                            <p class="text-muted-foreground text-xs">Can't scan the QR code? Enter this code manually in
                                your authenticator app.</p>

                            <div x-data="{ copied: false }"
                                class="flex flex-col gap-3 rounded-lg border p-4 sm:flex-row sm:items-center">
                                <code
                                    class="flex-1 break-all rounded-md bg-muted px-3 py-2 font-mono text-xs select-all">{{ $manualSetupKey }}</code>
                                <x-ui.button variant="outline" type="button" size="sm" class="w-full sm:w-auto"
                                    @click="navigator.clipboard.writeText(@json($manualSetupKey)).then(() => { copied = true; setTimeout(() => copied = false, 2000) })">
                                    <template x-if="copied">
                                        <x-lucide-check class="size-4" /> Copied!
                                    </template>
                                    <template x-if="!copied">
                                        <x-lucide-copy class="size-4" /> Copy setup key
                                    </template>
                                </x-ui.button>
                            </div>

                            <p class="text-muted-foreground text-xs">Store the setup key somewhere safe. You'll need it
                                to recover access to your account.</p>
                        </div>

                        {{-- Recovery codes --}}
                        <div class="space-y-2">
                            <p class="text-sm font-medium">Recovery codes</p>
                            <p class="text-muted-foreground text-xs">Store these codes somewhere safe before confirming.
                            </p>
                            <div x-data="{ copied: false }" class="space-y-3 rounded-lg border p-4">
                                <div class="grid grid-cols-1 gap-2 sm:grid-cols-2">
                                    @foreach ($recoveryCodes as $code)
                                        <code
                                            class="rounded-md bg-muted px-3 py-2 text-center font-mono text-xs select-all">{{ $code }}</code>
                                    @endforeach
                                </div>
                                <x-ui.button variant="outline" type="button" size="sm" class="w-full sm:w-auto"
                                    @click="navigator.clipboard.writeText(@json(implode(PHP_EOL, $recoveryCodes))).then(() => { copied = true; setTimeout(() => copied = false, 2000) })">
                                    <template x-if="copied"><x-lucide-check class="size-4" /> Copied!</template>
                                    <template x-if="!copied"><x-lucide-copy class="size-4" /> Copy recovery
                                        codes</template>
                                </x-ui.button>
                            </div>
                        </div>

                        <form wire:submit="confirm2FA" class="flex flex-col gap-3 sm:flex-row sm:items-end">
                            <x-ui.field class="flex-1">
                                <x-ui.field-label for="twoFactorCode">Authenticator code</x-ui.field-label>
                                <x-ui.input id="twoFactorCode" wire:model="twoFactorCode" type="text"
                                    inputmode="numeric" maxlength="6" placeholder="123456"
                                    autocomplete="one-time-code" />
                                @error('twoFactorCode')
                                    <x-ui.error :message="$message" />
                                @enderror
                            </x-ui.field>
                            <x-ui.button type="submit" class="w-full sm:w-auto">Confirm &amp; Enable</x-ui.button>
                        </form>
                    </div>
                @else
                    <div
                        class="flex flex-col gap-4 rounded-lg border p-4 sm:flex-row sm:items-center sm:justify-between sm:gap-6">
                        <div class="flex items-start gap-3">
                            <span class="bg-muted flex size-9 shrink-0 items-center justify-center rounded-lg">
                                <x-lucide-shield-off class="text-muted-foreground size-4" />
                            </span>
                            <div class="space-y-1">
                                <p class="text-sm font-medium leading-none">Disabled</p>
                                <p class="text-muted-foreground text-xs">You have not enabled two-factor authentication
                                    for your account.</p>
                            </div>
                        </div>

                        <x-ui.button variant="outline" type="button" size="sm" class="w-full sm:w-auto"
                            wire:click="enable2FA" wire:loading.attr="disabled">
                            <x-lucide-shield class="size-4" />
                            Enable two-factor authentication
                        </x-ui.button>
                    </div>
                @endif
            </x-ui.card-content>
        </x-ui.card>
    @endif
</div>
