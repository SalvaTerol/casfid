<?php

namespace Domain\Shared\ValueObjects;

use Illuminate\Support\Number;

class Price
{
    public readonly int $cent;
    public readonly float $euro;
    public readonly string $formatted;

    public function __construct(int $cent)
    {
        $this->cent = $cent;
        $this->euro = $cent / 100;
        $this->formatted = Number::currency($this->euro, 'EUR', app()->getLocale());
    }

    public static function from(int $cent): self
    {
        return new self($cent);
    }

    public static function transform(float $euro): self
    {
        $cent = (int) round($euro * 100);
        return new self($cent);
    }

    public function toArray(): array
    {
        return [
            'cent' => $this->cent,
            'euro' => $this->euro,
            'formatted' => $this->formatted,
        ];
    }
}
