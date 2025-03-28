<?php

namespace Chapdel\Credit\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Number;

class Credit extends Model
{
    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->guarded[] = $this->primaryKey;
        $this->table = config('credits.table');
    }

    protected function amountCurrency(): Attribute
    {
        return Attribute::make(
            get: fn () => Number::currency($this->amount / 100),
        );
    }

    public function creditable(): MorphTo
    {
        return $this->morphTo();
    }
}
