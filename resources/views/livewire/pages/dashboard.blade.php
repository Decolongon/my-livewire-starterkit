@php
//NOTES: ALL of the data below is static for demonstration purposes. In a real application, you would likely fetch this data from a database or an API.
   // Static data for the dashboard page. In a real application, this would likely come from a database or API.
    $kpis = [
        ['label' => 'Total Revenue', 'value' => '$12,480', 'delta' => '+23.1%', 'icon' => 'circle-dollar-sign'],
        ['label' => 'Active Users', 'value' => '1,204', 'delta' => '+8.4%', 'icon' => 'users'],
        ['label' => 'Conversion Rate', 'value' => '3.42%', 'delta' => '+0.6%', 'icon' => 'percent'],
        ['label' => 'Avg. Session', 'value' => '4m 32s', 'delta' => '+1.2%', 'icon' => 'timer'],
    ];

    // Static bar heights (arbitrary units) for the revenue chart.
    $revenue = [
        'Jan' => 40, 'Feb' => 58, 'Mar' => 45, 'Apr' => 70, 'May' => 62,
        'Jun' => 80, 'Jul' => 66, 'Aug' => 88, 'Sep' => 74, 'Oct' => 92,
        'Nov' => 84, 'Dec' => 100,
    ];

    // Static goal-completion donut slices (percentages must total 100).
    $goals = [
        ['label' => 'Completed', 'pct' => 48, 'color' => 'var(--primary)'],
        ['label' => 'In progress', 'pct' => 32, 'color' => '#f59e0b'],
        ['label' => 'Pending', 'pct' => 20, 'color' => '#e2e8f0'],
    ];

    $sources = [
        ['label' => 'Direct', 'pct' => 42],
        ['label' => 'Organic search', 'pct' => 28],
        ['label' => 'Social', 'pct' => 18],
        ['label' => 'Referral', 'pct' => 12],
    ];

    $topKits = [
        ['name' => 'Livewire Starter Kit', 'sales' => 128, 'revenue' => '$3,840'],
        ['name' => 'Filament Admin Kit', 'sales' => 96, 'revenue' => '$2,880'],
        ['name' => 'Breeze Auth Kit', 'sales' => 74, 'revenue' => '$2,220'],
        ['name' => 'API Boilerplate', 'sales' => 61, 'revenue' => '$1,830'],
        ['name' => 'SaaS Landing Kit', 'sales' => 45, 'revenue' => '$1,350'],
    ];
@endphp

<div class="mx-auto max-w-6xl px-6 py-10">
    {{-- Page header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">Analytics</h1>
            <p class="text-muted-foreground mt-1 text-sm">A snapshot of how your starter kits are performing.</p>
        </div>
        <div class="flex items-center gap-2">
            <div class="bg-muted flex items-center gap-1 rounded-md p-1 text-sm">
                @foreach (['7d', '30d', '90d'] as $range)
                    <button type="button" class="{{ $loop->last ? 'bg-background shadow-xs' : '' }} rounded-sm px-3 py-1 font-medium transition-colors">
                        {{ $range }}
                    </button>
                @endforeach
            </div>
            <x-ui.button size="sm" variant="outline">
                <x-slot:before><x-lucide-download /></x-slot:before> Export
            </x-ui.button>
        </div>
    </div>

    {{-- KPI widget row --}}
    <section class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($kpis as $kpi)
            <x-ui.card class="flex flex-col gap-4">
                <div class="flex items-center justify-between">
                    <span class="text-muted-foreground text-sm font-medium">{{ $kpi['label'] }}</span>
                    <span class="bg-primary/10 text-primary inline-flex size-8 items-center justify-center rounded-lg">
                        <x-dynamic-component :component="'lucide-' . $kpi['icon']" class="size-4" />
                    </span>
                </div>
                <div>
                    <p class="text-2xl font-bold tracking-tight">{{ $kpi['value'] }}</p>
                    <p class="text-emerald-600 mt-1 inline-flex items-center gap-1 text-xs font-medium">
                        <x-lucide-trending-up class="size-3.5" /> {{ $kpi['delta'] }}
                    </p>
                </div>
                {{-- static sparkline --}}
                <div class="flex h-8 items-end gap-1">
                    @foreach ([35, 50, 40, 65, 55, 75, 60, 85, 70, 90, 80, 95, 72] as $h)
                        <div class="bg-primary/30 hover:bg-primary/60 w-1.5 rounded-sm transition-colors" style="height: {{ $h }}%;"></div>
                    @endforeach
                </div>
            </x-ui.card>
        @endforeach
    </section>

    {{-- Revenue chart + Goal completion --}}
    <section class="mt-8 grid gap-8 lg:grid-cols-3">
        <x-ui.card class="lg:col-span-2">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h2 class="font-semibold">Revenue overview</h2>
                    <p class="text-muted-foreground text-sm">Monthly revenue for the current year</p>
                </div>
                <x-ui.button size="sm" variant="ghost">View report</x-ui.button>
            </div>
            <div class="flex h-56 items-end gap-2">
                @foreach ($revenue as $month => $height)
                    <div class="group flex h-full flex-1 flex-col items-center justify-end gap-2">
                        <div class="bg-primary/60 hover:bg-primary w-full max-w-7 rounded-t-sm transition-colors" style="height: {{ $height }}%;"></div>
                        <span class="text-muted-foreground text-[10px]">{{ $month }}</span>
                    </div>
                @endforeach
            </div>
        </x-ui.card>

        <x-ui.card>
            <h2 class="font-semibold">Goal completion</h2>
            <p class="text-muted-foreground text-sm">Progress toward this quarter's targets</p>
            <div class="mx-auto mt-6 grid place-items-center">
                <div class="relative size-36 rounded-full" style="background: conic-gradient(var(--primary) 0 48%, #f59e0b 48% 80%, #e2e8f0 80% 100%);">
                    <div class="bg-card absolute inset-4 grid place-items-center rounded-full">
                        <div class="text-center">
                            <p class="text-2xl font-bold">78%</p>
                            <p class="text-muted-foreground text-xs">overall</p>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="mt-6 space-y-3 text-sm">
                @foreach ($goals as $goal)
                    <li class="flex items-center gap-2">
                        <span class="size-2.5 rounded-full" style="background: {{ $goal['color'] }};"></span>
                        <span class="text-muted-foreground flex-1">{{ $goal['label'] }}</span>
                        <span class="font-medium">{{ $goal['pct'] }}%</span>
                    </li>
                @endforeach
            </ul>
        </x-ui.card>
    </section>

    {{-- Traffic sources + Top kits --}}
    <section class="mt-8 grid gap-8 lg:grid-cols-3">
        <x-ui.card class="lg:col-span-2">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h2 class="font-semibold">Traffic sources</h2>
                    <p class="text-muted-foreground text-sm">Where your visitors come from</p>
                </div>
            </div>
            <div class="space-y-5">
                @foreach ($sources as $source)
                    <div>
                        <div class="mb-1.5 flex items-center justify-between text-sm">
                            <span class="font-medium">{{ $source['label'] }}</span>
                            <span class="text-muted-foreground">{{ $source['pct'] }}%</span>
                        </div>
                        <div class="bg-muted h-2.5 w-full overflow-hidden rounded-full">
                            <div class="bg-primary h-full rounded-full" style="width: {{ $source['pct'] }}%;"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-ui.card>

        <x-ui.card>
            <h2 class="mb-3 font-semibold">Top starter kits</h2>
            <p class="text-muted-foreground mb-5 text-sm">Best sellers this month</p>
            <ul class="divide-y">
                @foreach ($topKits as $i => $kit)
                    <li class="flex items-center gap-3 py-3 first:pt-0 last:pb-0">
                        <span class="text-muted-foreground w-4 text-sm font-medium">{{ $i + 1 }}</span>
                        <span class="min-w-0 flex-1">
                            <span class="block truncate text-sm font-medium">{{ $kit['name'] }}</span>
                            <span class="text-muted-foreground text-xs">{{ $kit['sales'] }} sales</span>
                        </span>
                        <span class="text-sm font-semibold">{{ $kit['revenue'] }}</span>
                    </li>
                @endforeach
            </ul>
            <x-ui.button variant="outline" size="sm" class="mt-5 w-full">View all kits</x-ui.button>
        </x-ui.card>
    </section>
</div>
