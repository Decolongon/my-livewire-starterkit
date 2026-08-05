<div class="flex min-h-screen items-center justify-center">
    <x-ui.card variant="sectioned" class="w-full max-w-sm">
        <x-ui.card-header>
            <x-ui.card-title>Update Profile</x-ui.card-title>
            <x-ui.card-description>Update your account details. Leave password fields blank to keep your current
                password.</x-ui.card-description>
        </x-ui.card-header>

        <x-ui.card-content>
            <form wire:submit="updateProfile" class="flex flex-col gap-6">
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
                    <x-ui.field-label for="new_password_confirmation">Confirm New Password</x-ui.field-label>
                    <x-ui.input id="new_password_confirmation" wire:model="new_password_confirmation" type="password"
                        autocomplete="new-password" />
                    @error('new_password_confirmation')
                        <x-ui.error :message="$message" />
                    @enderror
                </x-ui.field>

                <x-ui.button type="submit" class="w-full" wire:loading.attr="disabled">Update Profile</x-ui.button>
            </form>
        </x-ui.card-content>
    </x-ui.card>
</div>
