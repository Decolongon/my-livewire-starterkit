<x-layouts.app>
    <div class="flex min-h-screen items-center justify-center">
        <x-ui.card variant="sectioned" class="w-full max-w-sm">
            <x-ui.card-header>
                <x-ui.card-title>Login to your account</x-ui.card-title>
                <x-ui.card-description>Enter your email below to login to your account.</x-ui.card-description>
                <x-ui.card-action>
                    <x-ui.button variant="link" href="{{ route('register') }}">Register</x-ui.button>
                </x-ui.card-action>
            </x-ui.card-header>

            <x-ui.card-content>
                <form method="POST" action="{{ route('login.post') }}" class="flex flex-col gap-6">
                    @csrf
                    <x-ui.field>
                        <x-ui.field-label for="email">Email</x-ui.field-label>
                        <x-ui.input id="email" name="email" type="email" placeholder="m@example.com"
                                   value="{{ old('email') }}" />
                        @error('email')
                            <x-ui.error :message="$message" />
                        @enderror
                    </x-ui.field>

                    <x-ui.field>
                        <div class="flex items-center">
                            <x-ui.field-label for="password">Password</x-ui.field-label>
                            <a href="{{ route('password.request') }}" class="ml-auto text-sm underline-offset-4 hover:underline">Forgot your password?</a>
                        </div>
                        <x-ui.input id="password" name="password" type="password" />
                        @error('password')
                            <x-ui.error :message="$message" />
                        @enderror
                    </x-ui.field>

                    <x-ui.field>
                        <div class="flex items-center">
                            <x-ui.field-label for="captcha">Captcha</x-ui.field-label>
                        </div>
                        <div class="captcha-image" id="captcha-image">
                            {!! $captchaHtml !!}  {{-- passed from controller --}}
                        </div>
                        {{-- <button type="button" id="reload-captcha" class="text-sm underline reload-button">
                            Reload Captcha
                        </button> --}}
                        <x-ui.input id="captcha" name="captcha" type="number" />
                        @error('captcha')
                            <x-ui.error :message="$message" />
                        @enderror
                    </x-ui.field>

                    <div class="flex flex-col gap-2 mt-4">
                        <x-ui.button type="submit" class="w-full">Login</x-ui.button>
                    </div>
                </form>
            </x-ui.card-content>
        </x-ui.card>
    </div>
{{-- 
    <script>
        document.getElementById('reload-captcha').addEventListener('click', async function () {
            const response = await fetch('{{ route('captcha.reload.login') }}', {
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