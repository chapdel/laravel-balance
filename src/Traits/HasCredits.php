<?php

namespace Chapdel\Credit\Traits;

use Chapdel\Credit\Models\Credit;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Number;

trait hasCredits
{
    protected string $currency;

    public function __construct()
    {
        $this->currency = config('credits.default_currency', 'XAF');
    }

    public function credits(): MorphMany
    {
        return $this->morphMany(Credit::class, 'creditable');
    }

    public function withCurrency(string $currency): self
    {
        $clone = clone $this;
        $clone->currency = $currency;

        return $clone;
    }

    protected function credit(): Attribute
    {

        $credits = $this->credits()->sum('amount');

        return Attribute::make(
            get: fn () => $credits > 0 ? $credits / 100 : 0,
        );
    }

    public function increaseCredit(int $amount, ?string $reason = null): Credit
    {
        return $this->createCredit($amount, $reason);
    }

    public function decreaseCredit(int $amount, ?string $reason = null): Credit
    {
        return $this->createCredit(-1 * abs($amount), $reason);
    }

    public function setCredit(int $amount, ?string $reason = null):Credit
    {
        return $this->createCredit($amount, $reason);
    }

    public function resetCredit(): void
    {
        $this->credits()->delete();
    }

    public function hasCredit(): bool
    {
        return $this->credit > 0;
    }

    protected function createCredit(int $amount, ?string $reason = null): Credit
    {
        return $this->credits()->create([
            'amount' => $amount,
            'reason' => $reason,
        ]);
    }
}
