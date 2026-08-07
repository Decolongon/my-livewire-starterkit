@php
    $navigations = [
        ['label' => 'Help Center', 'route' => 'help'],
        ['label' => 'Community', 'route' => 'community'],
        ['label' => 'Status', 'route' => 'status'],
        ['label' => 'Blog', 'route' => 'dashboard'],
    ];

    $user = auth()->user();
@endphp

<div x-data="{ mobileOpen: false }">
    <header
        class="bg-background/80 supports-[backdrop-filter]:bg-background/60 sticky top-0 z-40 border-b backdrop-blur-xl">
        <div class="mx-auto flex h-16 max-w-6xl items-center gap-4 px-6">
            <a href="#" class="flex items-center gap-2 font-semibold">
                <span class="bg-primary text-primary-foreground flex size-7 items-center justify-center rounded-lg">
                    <x-lucide-life-buoy class="size-4" />
                </span> {{ config('app.name') }}
            </a>

            <nav class="ml-4 hidden items-center gap-1 text-sm md:flex">
                @foreach ($navigations as $item)
                    <a href="" wire:navigate
                        class="text-muted-foreground hover:text-foreground hover:bg-accent/60 rounded-md px-3 py-1.5 font-medium transition-colors">
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>

            {{-- Mobile hamburger toggle --}}
            <button type="button"
                class="hover:bg-accent inline-flex size-9 items-center justify-center rounded-md transition-colors md:hidden"
                @click="mobileOpen = !mobileOpen" aria-label="Toggle navigation" aria-expanded="false"
                :aria-expanded="mobileOpen.toString()">
                <x-lucide-menu class="size-5" x-show="!mobileOpen" />
                <x-lucide-x class="size-5" x-show="mobileOpen" x-cloak />
            </button>

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
                        <x-ui.button size="sm" variant="outline" href="{{ route('login') }}">Log in
                        </x-ui.button>
                    @else
                        <x-ui.button size="sm" variant="outline" href="{{ route('register') }}">Register
                        </x-ui.button>
                    @endif
                @endguest

                @auth
                    <div class="relative" x-data="{ open: false }">
                        <button type="button" @click="open = !open" @keydown.escape.window="open = false"
                            class="hover:bg-accent flex items-center gap-2 rounded-full p-1 pr-2 transition-colors"
                            aria-label="Open profile menu" aria-haspopup="menu" :aria-expanded="open.toString()"
                            x-transition>
                            <span
                                class="bg-primary text-primary-foreground flex size-8 items-center justify-center rounded-full text-sm font-semibold uppercase">
                                {{ $user->initial() }}
                            </span>
                            {{-- <span class="hidden text-sm font-medium sm:inline">{{ $user->name }}</span>
                        <x-lucide-chevron-down class="text-muted-foreground hidden size-4 sm:block" /> --}}
                        </button>

                        <div x-show="open" @click.outside="open = false" x-cloak x-transition
                            class="bg-card border-ring/40 absolute right-0 z-50 mt-2 w-60 overflow-hidden rounded-xl border shadow-lg"
                            role="menu">
                            <div class="border-b px-4 py-3">
                                <p class="text-sm font-semibold">{{ $user->name }}</p>
                                <p class="text-muted-foreground truncate text-xs">{{ $user->email }}</p>
                            </div>
                            <div class="p-1.5">
                                <a href="{{ route('dashboard') }}" wire:navigate role="menuitem"
                                    @class([
                                        'hover:bg-accent flex items-center gap-2 rounded-md px-3 py-2 text-sm font-medium transition-colors',
                                        'bg-accent text-foreground' => request()->routeIs('dashboard'),
                                    ])>
                                    <x-lucide-layout-dashboard class="text-muted-foreground size-4" /> Dashboard
                                </a>
                                <a href="{{ route('profile') }}" wire:navigate role="menuitem" @class([
                                    'hover:bg-accent flex items-center gap-2 rounded-md px-3 py-2 text-sm font-medium transition-colors',
                                    'bg-accent text-foreground' => request()->routeIs('profile'),
                                ])>
                                    <x-lucide-user class="text-muted-foreground size-4" /> Profile
                                </a>
                                <div class="my-1 h-px bg-border"></div>
                                <livewire:auth.logout />
                            </div>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </header>

    <x-partials.mobile-sidebar :navigations="$navigations" />
</div>
