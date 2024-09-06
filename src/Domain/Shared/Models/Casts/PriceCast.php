<?php

namespace Domain\Shared\Models\Casts;

use Domain\Shared\ValueObjects\Price;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class PriceCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        return Price::from($value);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        if ($value instanceof Price) {
            return $value->cent;
        }

        return Price::transform($value)->cent;
    }
}
