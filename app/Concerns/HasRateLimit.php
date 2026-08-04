<?php

namespace App\Concerns;

use Illuminate\Support\Facades\RateLimiter;

trait HasRateLimit
{
    protected function getRateLimitKey(): string
    {
        return request()->user()?->id ?: request()->ip();
    }

    protected function limitRate(int $maxAttempts = 3, int $decayMinutes = 1): void
    {
        if (RateLimiter::tooManyAttempts($this->getRateLimitKey(), $maxAttempts)) {
            throw new \Exception('Too many attempts please try again later.');
        }

        RateLimiter::hit($this->getRateLimitKey(), $decayMinutes * 60);
    }
}
