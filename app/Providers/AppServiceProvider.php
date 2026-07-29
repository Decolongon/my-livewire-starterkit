<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Livewire\Blaze\Blaze;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();
        // $this->blazeConfig();
    }

    protected function configureRateLimiting(): void
    {
        RateLimiter::for('authLimit', function (Request $request) {
            return Limit::perMinute(5)->by($request->user()?->id ?: $request->ip());
        });
    }

    protected function blazeConfig(): void
    {
        Blaze::optimize()
            ->in(resource_path('views/components'))
            ->in(resource_path('views/components/ui'), memo: false);
    }
}
