<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $this->configProhibitedCommand();
        $this->configureRateLimiting();
        $this->blazeConfig();
    }

    protected function configureRateLimiting(): void
    {
        RateLimiter::for('authLimit', function (Request $request) {
            return $request->user()
                  ? Limit::perMinute(60)->by($request->user()->id)
                  : Limit::perMinute(5)->by($request->ip());
        });
    }

    protected function configProhibitedCommand(): void
    {
        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );
    }

    protected function blazeConfig(): void
    {
        Blaze::optimize()
            ->in(resource_path('views/components/ui'), memo: true)
            ->in(resource_path('views/components/partials'), compile: false);

    }
}
