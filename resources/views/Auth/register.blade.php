<x-layouts.app>
    <div class="flex min-h-screen items-center justify-center">
        <x-ui.card variant="sectioned" class="w-full max-w-sm">
            <x-ui.card-header>
                <x-ui.card-title>Create your account</x-ui.card-title>
                <x-ui.card-description>Enter your credentials below.</x-ui.card-description>
                <x-ui.card-action>
                    <x-ui.button variant="link" href="{{ route('login') }}">Log in</x-ui.button>
                </x-ui.card-action>
            </x-ui.card-header>
            <x-ui.card-content>
                <form action="{{ route('register.post') }}" method="POST" class="flex flex-col gap-6">
                    @csrf
                    <x-ui.field>
                        <x-ui.field-label for="card-register-name">Name</x-ui.field-label>
                        <x-ui.input id="card-register-name" name="name" type="text" placeholder="John Doe" />
                        @error('name')
                            <x-ui.error :message="$message" />
                        @enderror
                    </x-ui.field>
                    <x-ui.field>
                        <x-ui.field-label for="card-register-email">Email</x-ui.field-label>
                        <x-ui.input id="card-register-email" name="email" type="email"
                            placeholder="m@example.com" />
                        @error('email')
                            <x-ui.error :message="$message" />
                        @enderror
                    </x-ui.field>
                    <x-ui.field>
                        <x-ui.field-label for="card-register-password">Password</x-ui.field-label>
                        <x-ui.input id="card-register-password" name="password" type="password" />
                        @error('password')
                            <x-ui.error :message="$message" />
                        @enderror
                    </x-ui.field>

                    <x-ui.field>
                        <x-ui.field-label for="card-register-password_confirmatiom">Password
                            Confirmation</x-ui.field-label>
                        <x-ui.input id="card-register-password_confirmation" name="password_confirmation"
                            type="password" />
                        @error('password_confirmation')
                            <x-ui.error :message="$message" />
                        @enderror
                    </x-ui.field>

                    <x-ui.field>
                        <div class="flex items-center">
                            <x-ui.field-label for="captcha">Captcha</x-ui.field-label>
                        </div>
                        <div class="captcha-image" id="captcha-image">
                            {!! $captchaHtml !!} {{-- passed from controller --}}
                        </div>
                        {{-- <button type="button" id="reload-captcha" class="text-sm underline reload-button">
                            Reload Captcha
                        </button> --}}
                        <x-ui.input id="captcha" name="captcha" type="number" />
                        @error('captcha')
                            <x-ui.error :message="$message" />
                        @enderror
                    </x-ui.field>

            </x-ui.card-content>
            <x-ui.card-footer class="flex-col gap-2">
                <x-ui.button type="submit" class="w-full">Register</x-ui.button>
            </x-ui.card-footer>
            </form>
        </x-ui.card>
    </div>

    {{-- <script>
        document.getElementById('reload-captcha').addEventListener('click', async function() {
            const response = await fetch('{{ route('captcha.reload.register') }}', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const data = await response.json();
            document.getElementById('captcha-image').innerHTML = data.captcha;
            document.getElementById('captcha').value = '';
        });
    </script> --}}
</x-layouts.app>
