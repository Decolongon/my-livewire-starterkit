 {{-- Mobile drawer (mobile only) --}}
 <div class="fixed inset-0 z-50 md:hidden" x-show="mobileOpen" @keydown.escape.window="mobileOpen = false" x-cloak>
     <div class="absolute inset-0 bg-black/40" @click="mobileOpen = false"></div>

     <div class="absolute inset-y-0 left-0 flex w-80 max-w-[85%] flex-col bg-background shadow-2xl"
         x-transition:enter="transition ease-out duration-700" x-transition:enter-start="-translate-x-full"
         x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-700"
         x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full">

         {{-- Drawer header --}}
         <div class="flex h-16 shrink-0 items-center justify-between border-b px-4">
             <a href="#" @click="mobileOpen = false" class="flex items-center gap-2 font-semibold">
                 <span class="bg-primary text-primary-foreground flex size-7 items-center justify-center rounded-lg">
                     <x-lucide-life-buoy class="size-4" />
                 </span> {{ config('app.name') }}
             </a>
             <button type="button" @click="mobileOpen = false"
                 class="hover:bg-accent inline-flex size-9 items-center justify-center rounded-md transition-colors"
                 aria-label="Close navigation">
                 <x-lucide-x class="size-5" />
             </button>
         </div>

         {{-- Navigation links --}}
         <nav class="flex-1 overflow-y-auto px-3 py-4">
             <p class="text-muted-foreground px-3 pb-2 text-xs font-semibold uppercase tracking-wide">Menu</p>
             <div class="flex flex-col gap-1 text-sm">
                 @foreach ($navigations as $item)
                     <a href="" wire:navigate @click="mobileOpen = false"
                         class="text-foreground hover:bg-accent/60 flex items-center justify-between gap-3 rounded-md px-3 py-2.5 font-medium transition-colors">
                         {{ $item['label'] }}
                         <x-lucide-chevron-right class="text-muted-foreground size-4" />
                     </a>
                 @endforeach
             </div>
         </nav>

         {{-- Bottom actions --}}
         <div class="shrink-0 border-t p-3">
             @auth
                 <livewire:auth.logout />
             @endauth

             @guest
                 @if (request()->routeIs('register'))
                     <x-ui.button size="sm" variant="outline" href="{{ route('login') }}" class="w-full">
                         <x-lucide-log-in class="size-4" /> Log in
                     </x-ui.button>
                 @else
                     <x-ui.button size="sm" variant="outline" href="{{ route('register') }}" class="w-full">
                         <x-lucide-user-plus class="size-4" /> Register
                     </x-ui.button>
                 @endif
             @endguest
         </div>
     </div>
 </div>
