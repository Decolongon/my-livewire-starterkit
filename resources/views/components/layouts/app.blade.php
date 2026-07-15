<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="flex min-h-screen flex-col"> {{-- Add flex classes --}}

    @include('partials.header')

    {{-- Main content area --}}
    <main class="flex-1"> {{-- This fills remaining space --}}
        {{ $slot }}
    </main>

    @include('partials.footer')

    @livewireScripts    
     <script>
        const loadDarkMode = () => {
            const theme = localStorage.getItem('theme') ?? 'system';
            if (
                theme === 'dark' ||
                (theme === 'system' &&
                    window.matchMedia('(prefers-color-scheme: dark)').matches)
            ) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        };
        loadDarkMode();
        document.addEventListener('livewire:navigated', loadDarkMode);
    </script>
</body>

</html>
