<?php

namespace Domain\Menu\DataTransferObject;

use Domain\Menu\FormRequests\IngredientRequest;
use Domain\Menu\Models\Ingredient;
use Domain\Shared\ValueObjects\Price;
use Illuminate\Support\Collection;

class IngredientData
{
    public function __construct(public readonly ?int $id, public readonly string $name, public readonly int|float|Price $price) {}

    public static function fromRequest(
        IngredientRequest $request,
        ?int $id = null
    ): self {
        return new self(
            id: $id,
            name: $request->get('name'),
            price: $request->get('price')
        );
    }

    public static function fromModel(Ingredient $ingredient): self
    {
        return new self(
            id: $ingredient->id,
            name: $ingredient->name,
            price: $ingredient->price
        );
    }

    public static function fromArray(array $ingredient): self
    {
        return new self(
            id: $ingredient['id'] ?? null,
            name: $ingredient['name'],
            price: $ingredient['price']
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
        ];
    }

    public static function collection(Collection $ingredients): Collection
    {
        return $ingredients->map(function (Ingredient $ingredient) {
            return new self(
                id: $ingredient->id,
                name: $ingredient->name,
                price: $ingredient->price
            );
        });
    }
}
