@php
    $navigations = [
        ['label' => 'Help Center', 'route' => 'help'],
        ['label' => 'Community', 'route' => 'community'],
        ['label' => 'Status', 'route' => 'status'],
        ['label' => 'Blog', 'route' => 'blog'],
    ];
@endphp

<header class="bg-background/80 supports-[backdrop-filter]:bg-background/60 sticky top-0 z-40 border-b backdrop-blur-xl">
    <div class="mx-auto flex h-16 max-w-6xl items-center gap-4 px-6">
        <a href="#" class="flex items-center gap-2 font-semibold">
            <span class="bg-primary text-primary-foreground flex size-7 items-center justify-center rounded-lg">
                <x-lucide-life-buoy class="size-4" />
            </span> My starter kits
        </a>

        <nav class="ml-4 hidden items-center gap-1 text-sm md:flex">
            @foreach ($navigations as $item)
                <a href="" wire:navigate
                    class="text-muted-foreground hover:text-foreground hover:bg-accent/60 rounded-md px-3 py-1.5 font-medium transition-colors">
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        {{-- Common toggle button – works for both guest and auth --}}
        <div class="ml-auto flex items-center gap-1.5">
            <button type="button" x-data
                @click="
                        const current = localStorage.getItem('theme') || 'system';
                        const next = current === 'dark' ? 'light' : 'dark';
                        localStorage.setItem('theme', next);
                        loadDarkMode();
                    "
                class="hover:bg-accent inline-flex size-9 items-center justify-center rounded-md transition-colors"
                aria-label="Toggle theme">
                <x-lucide-sun class="size-4 dark:hidden" />
                <x-lucide-moon class="hidden size-4 dark:block" />
            </button>

            @guest
                @if (request()->routeIs('register'))
                    <x-ui.button size="sm" variant="outline" wire:navigate href="{{ route('login') }}">Log in
                        </x-ui.button>
                @else
                    <x-ui.button size="sm" variant="outline" wire:navigate href="{{ route('register') }}">Register
                        </x-ui.button>
                @endif
            @endguest

            @auth
                <livewire:auth.logout />
            @endauth
        </div>
    </div>
</header>
