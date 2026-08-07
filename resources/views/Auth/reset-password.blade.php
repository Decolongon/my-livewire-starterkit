<x-layouts.app>
    <div class="flex min-h-screen items-center justify-center">
        <x-ui.card variant="sectioned" class="w-full max-w-sm">
            <x-ui.card-header>
                <x-ui.card-title>Reset your password</x-ui.card-title>
                <x-ui.card-description>
                    Enter a new password for your account.
                </x-ui.card-description>
            </x-ui.card-header>

            <x-ui.card-content>
                @if (session('status'))
                    <div class="mb-4 rounded-md bg-green-50 px-4 py-3 text-sm text-green-700 dark:bg-green-950 dark:text-green-300">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.update') }}" class="flex flex-col gap-6">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <x-ui.field>
                        <x-ui.field-label for="email">Email</x-ui.field-label>
                        <x-ui.input id="email" name="email" type="email" placeholder="m@example.com"
                                   value="{{ old('email', $request->email) }}" required autofocus />
                        @error('email')
                            <x-ui.error :message="$message" />
                        @enderror
                    </x-ui.field>

                    <x-ui.field>
                        <x-ui.field-label for="password">New password</x-ui.field-label>
                        <x-ui.input id="password" name="password" type="password" required />
                        @error('password')
                            <x-ui.error :message="$message" />
                        @enderror
                    </x-ui.field>

                    <x-ui.field>
                        <x-ui.field-label for="password_confirmation">Confirm password</x-ui.field-label>
                        <x-ui.input id="password_confirmation" name="password_confirmation" type="password" required />
                    </x-ui.field>

                    <x-ui.button type="submit" class="w-full mt-4">Reset password</x-ui.button>
                </form>
            </x-ui.card-content>
        </x-ui.card>
    </div>
</x-layouts.app>