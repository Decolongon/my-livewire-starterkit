<?php

namespace App\Concerns;

use Illuminate\Support\Facades\RateLimiter;

trait HasRateLimit
{
    use HasToast;

    protected function getRateLimitKey(): string
    {
        return request()->user()?->id ?: request()->ip();
    }

    protected function limitRate(int $maxAttempts = 5, int $decayMinutes = 1): bool
    {
        if (RateLimiter::tooManyAttempts($this->getRateLimitKey(), $maxAttempts)) {
            // throw new \Exception('Too many attempts please try again later.');
            return false;
        }

        RateLimiter::hit($this->getRateLimitKey(), $decayMinutes * 60);

        return true;
    }
}
