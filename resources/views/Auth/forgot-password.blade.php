<x-layouts.app>
    <div class="flex min-h-screen items-center justify-center">
        <x-ui.card variant="sectioned" class="w-full max-w-sm">
            <x-ui.card-header>
                <x-ui.card-title>Forgot your password?</x-ui.card-title>
                <x-ui.card-description>
                    Enter your email and we'll send you a link to reset your password.
                </x-ui.card-description>
                <x-ui.card-action>
                    <x-ui.button variant="link" href="{{ route('login') }}">Back to login</x-ui.button>
                </x-ui.card-action>
            </x-ui.card-header>

            <x-ui.card-content>
                @if (session('status'))
                    <div class="mb-4 rounded-md bg-green-50 px-4 py-3 text-sm text-green-700 dark:bg-green-950 dark:text-green-300">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-6">
                    @csrf
                    <x-ui.field>
                        <x-ui.field-label for="email">Email</x-ui.field-label>
                        <x-ui.input id="email" name="email" type="email" placeholder="m@example.com"
                                   value="{{ old('email') }}" required autofocus />
                        @error('email')
                            <x-ui.error :message="$message" />
                        @enderror
                    </x-ui.field>

                    <x-ui.button type="submit" class="w-full mt-4">Send reset link</x-ui.button>
                </form>
            </x-ui.card-content>
        </x-ui.card>
    </div>
</x-layouts.app>